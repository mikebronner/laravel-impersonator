<?php namespace GeneaLabs\LaravelImpersonator\Tests;

use GeneaLabs\LaravelImpersonator\Providers\Service as LaravelImpersonatorService;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Eloquent\Factory;

trait CreatesApplication
{
    public function createApplication()
    {
        $this->preLoadRoutes();
        $app = require __DIR__ . '/../vendor/laravel/laravel/bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
        $app->make(Factory::class)->load(__DIR__ . '/Fixtures/database/factories');
        $app->register(LaravelImpersonatorService::class);

        return $app;
    }

    protected function preLoadRoutes()
    {
        $routes = file_get_contents(__DIR__ . '/../vendor/laravel/laravel/routes/web.php');
        $routes .= str_contains($routes, 'Auth::routes();') ? '' : "\nAuth::routes();\n";
        file_put_contents(__DIR__ . '/../vendor/laravel/laravel/routes/web.php', $routes);
    }
}
