<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
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

        Route::fallback(function () {
            return response()->view('pages.error.404', [], 404);
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

    protected function registerRoutesFromController($controllerClass, $prefix)
{
    $reflection = new ReflectionClass($controllerClass);
    $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

    $controllerName = $reflection->getShortName();
    $namespace = $reflection->getNamespaceName();

    if ($controllerName === 'HomeController' || $controllerName === 'landingController') {
        $prefix = '/';
    } else {
        $controllerName = str_replace('Controller', '', $controllerName);
        $controllerName = Str::kebab($controllerName);
        $prefix .= $controllerName . '/';
    }

    $isAuthController = str_contains($namespace, 'App\Http\Controllers\Auth');

    Route::middleware(['web'])->group(function () use ($methods, $controllerClass, $prefix, $isAuthController) {
        foreach ($methods as $method) {
            if ($method->class !== $controllerClass || $method->isConstructor()) {
                continue;
            }

            // Inisialisasi variabel untuk menghindari error 'Undefined variable'
            $routeName = null; 

            $methodName = $method->name;
            preg_match('/^(get|post|put|delete|patch)(.+)$/', $methodName, $matches);

            if (count($matches) === 3) {
                [$fullMatch, $httpVerb, $name] = $matches;
                $routeName = strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $name));

                if ($routeName === 'index') {
                    $routeName = '';
                }

                $fullRoute = rtrim($prefix, '/') . ($routeName ? '/' . $routeName : '');
                
                $parameters = $method->getParameters();
                $routeParamName = 'params';
                if (!empty($parameters)) {
                    $routeParamName = $parameters[0]->getName();
                }

                if ($isAuthController || $fullRoute === 'admin/umkm/store') {
                    Route::match(strtolower($httpVerb), $fullRoute . '/{' . $routeParamName . '?}', [$controllerClass, $methodName])
                        ->where($routeParamName, '.*');
                } else {
                    Route::middleware(['auth'])->group(function () use ($httpVerb, $fullRoute, $controllerClass, $methodName, $routeParamName, $parameters, $routeName) {
                        if (strtolower($httpVerb) === 'get') {
                            $route = Route::get($fullRoute . (!empty($parameters) ? '/{' . $routeParamName . '?}' : ''), [$controllerClass, $methodName]);

                            // Pengecekan nama rute login
                            if ($routeName === 'login') {
                                $route->name('login');
                            }
                        } else {
                            Route::match(strtolower($httpVerb), $fullRoute . (!empty($parameters) ? '/{' . $routeParamName . '?}' : ''), [$controllerClass, $methodName])
                                ->where($routeParamName, '.*');
                        }
                    });
                }
            }
        }
    });
}
}