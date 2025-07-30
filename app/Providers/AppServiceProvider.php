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
        // Panggil metode pemetaan rute
        $this->map();
        // Atur Paginator untuk menggunakan Bootstrap 5
        Paginator::useBootstrapFive();
    }

    /**
     * Definisikan pemetaan rute untuk aplikasi.
     */
    public function map()
    {
        $this->mapDynamicRoutes();
    }

    /**
     * Petakan rute secara dinamis dari controller.
     */
    public function mapDynamicRoutes()
    {
        $controllerPath = app_path('Http/Controllers');
        $namespace = 'App\Http\Controllers';

        $this->registerRoutesFromFolder($controllerPath, $namespace);

        // Rute fallback jika tidak ada rute lain yang cocok (untuk halaman 404)
        Route::fallback(function () {
            return response()->view('error.404', [], 404);
        });
    }

    /**
     * Pindai folder secara rekursif untuk mendaftarkan controller.
     */
    public function registerRoutesFromFolder($folder, $namespace, $prefix = '')
    {
        foreach (scandir($folder) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $fullPath = $folder . DIRECTORY_SEPARATOR . $file;
            $className = pathinfo($file, PATHINFO_FILENAME);

            if (is_dir($fullPath)) {
                // Jika ini adalah direktori, lakukan pemindaian rekursif
                $this->registerRoutesFromFolder($fullPath, $namespace . '\\' . $className, $prefix . strtolower($className) . '/');
            } elseif (str_ends_with($file, 'Controller.php')) {
                // Jika ini adalah file Controller, daftarkan rutenya
                $controllerClass = $namespace . '\\' . $className;
                if (class_exists($controllerClass)) {
                    $this->registerRoutesFromController($controllerClass, $prefix);
                }
            }
        }
    }

    /**
     * Daftarkan rute dari sebuah controller.
     */
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

        // Tentukan middleware dasar
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

        // Grup semua rute dari controller ini dengan middleware yang sudah ditentukan
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
                    foreach($method->getParameters() as $param) {
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