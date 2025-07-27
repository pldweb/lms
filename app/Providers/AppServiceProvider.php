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
    {}

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
            return response()->view('error.404', [], 404);
        });
    }

    public function registerRoutesFromFolder($folder, $namespace, $prefix = '')
    {
        // Scan setiap file di dalam folder controller
        foreach (scandir($folder) as $file) {

            // Skip . pada nama file
            if ($file === '.' || $file === '..') {
                continue;
            }

            $fullPath = $folder . DIRECTORY_SEPARATOR . $file;
            $className = pathinfo($file, PATHINFO_FILENAME);

            if (is_dir($fullPath)) {

                // Memastikan pemanggilan metode benar
                $this->registerRoutesFromFolder($fullPath, $namespace . '\\' . $className, $prefix . strtolower($className) . '/');

            } elseif (str_ends_with($file, 'Controller.php')) {

                // Pastikan hanya file controller yang diproses
                $controllerClass = $namespace . '\\' . $className;

                // Cek apakah ada class
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
            $controllerName = str::kebab($controllerName);
            $prefix .= $controllerName . '/';
        }

        // Cek apakah controller ada di dalam folder Auth
        $isAuthController = str_contains($namespace, 'App\Http\Controllers\Auth');

        Route::middleware(['web'])->group(function () use ($methods, $controllerClass, $prefix, $isAuthController) {
            foreach ($methods as $method) {
                if ($method->class !== $controllerClass || $method->isConstructor()) {
                    continue;
                }

                $methodName = $method->name;
                preg_match('/^(get|post|put|delete|patch)(.+)$/', $methodName, $matches);

                if (count($matches) === 3) {
                    [$fullMatch, $httpVerb, $name] = $matches;
                    $routeName = strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $name));

                    if ($routeName === 'index') {
                        $routeName = '';
                    }

                    $fullRoute = rtrim($prefix, '/') . ($routeName ? '/' . $routeName : '');

                    // Ambil parameter function (jika ada)
                    $parameters = $method->getParameters();
                    $routeParamName = 'params';

                    if (!empty($parameters)) {
                        $routeParamName = $parameters[0]->getName(); // Nama parameter pertama
                    }

                    // Jika controller dalam folder Auth, tidak pakai middleware auth
                    if ($isAuthController || $fullRoute === 'admin/umkm/store') {
                        Route::match(strtolower($httpVerb), $fullRoute . '/{' . $routeParamName . '?}', [$controllerClass, $methodName])
                            ->where($routeParamName, '.*');
                    } else {
                        if (strtolower($httpVerb) === 'get') {
                            $route = Route::get($fullRoute . (!empty($parameters) ? '/{' . $routeParamName . '?}' : ''), [$controllerClass, $methodName]);

                            if ($routeName === 'login') {
                                $route->name('login');
                            }
                        } else {
                            Route::middleware(['auth'])->group(function () use ($httpVerb, $fullRoute, $controllerClass, $methodName, $routeParamName, $parameters) {
                                Route::match(strtolower($httpVerb), $fullRoute . (!empty($parameters) ? '/{' . $routeParamName . '?}' : ''), [$controllerClass, $methodName])
                                    ->where($routeParamName, '.*');
                            });
                        }
                    }
                }
            }
        });
    }
}
