<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->map();
        Paginator::useBootstrapFive();
    }

    public function map()
    {
        $this->mapDynamicRoutes();
    }

    public function mapDynamicRoutes()
    {
        $controllerPath = app_path('Http/Controllers');
        $namespace = 'App\Http\Controllers';

        $this->registerRoutesFromFolder($controllerPath, $namespace);

        Route::fallback(function (Request $request) {
            return response()->view('error.404', [
                'url' => $request->url(),
                'previousUrl' => url()->previous()
            ], 404);
        });
    }

    public function registerRoutesFromFolder($folder, $namespace, $prefix = '')
    {
        foreach (scandir($folder) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $fullPath = $folder . DIRECTORY_SEPARATOR . $file;
            $className = pathinfo($file, PATHINFO_FILENAME);

            if (is_dir($fullPath)) {
                $this->registerRoutesFromFolder($fullPath, $namespace . '\\' . $className, $prefix . strtolower($className) . '/');
            } elseif (str_ends_with($file, 'Controller.php')) {
                $controllerClass = $namespace . '\\' . $className;
                if (class_exists($controllerClass)) {
                    $this->registerRoutesFromController($controllerClass, $prefix);
                }
            }
        }
    }

    protected function registerRoutesFromController($controllerClass, $prefix) {
        $reflection = new ReflectionClass($controllerClass);
        $namespace = $reflection->getNamespaceName();
        $controllerName = $reflection->getShortName();

        if ($controllerName === 'HomeController' || $controllerName === 'landingController') {
            $prefix = '/';
        } else {
            $controllerNameKebab = Str::kebab(str_replace('Controller', '', $controllerName));
            $prefix .= $controllerNameKebab . '/';
        }

        $middlewares = ['web'];

        // Cek apakah controller berada di dalam namespace 'admin'
        if (str_contains($namespace, 'App\Http\Controllers\admin')) {
            // Jika ya, maka controller ini dilindungi dan wajib login
            $middlewares[] = 'auth';

            // Ambil juga peran yang diizinkan dari properti controller
            if ($reflection->hasProperty('roles')) {
                $roles = $reflection->getDefaultProperties()['roles'];
                if (!empty($roles)) {
                    $middlewares[] = 'role:' . implode('|', $roles);
                }
            }
        }

        Route::middleware($middlewares)->prefix($prefix)->group(function () use ($reflection, $controllerClass) {
        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->class !== $controllerClass || $method->isConstructor()) {
                continue;
            }

            $methodName = $method->name;
            if (preg_match('/^(get|post|put|patch|delete)(.+)$/', $methodName, $matches)) {
                [$fullMatch, $httpVerb, $actionName] = $matches;
                $uri = ($actionName === 'Index') ? '' : Str::kebab($actionName);

                $paramString = '';
                foreach ($method->getParameters() as $param) {
                    $paramType = $param->getType();
                    if ($paramType && $paramType->getName() === 'Illuminate\Http\Request') {
                        continue; // Lewati parameter ini
                    }
                    $paramString .= '/{' . $param->getName() . ($param->isOptional() ? '?' : '') . '}';
                }

                $route = Route::match([$httpVerb], rtrim($uri . $paramString, '/'), [$controllerClass, $methodName]);

                if ($reflection->getShortName() === 'LoginController' && $methodName === 'getIndex') {
                    $route->name('login');
                }
            }
        }
    });
    }
}