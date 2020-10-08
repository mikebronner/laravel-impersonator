<?php namespace GeneaLabs\LaravelImpersonator\Tests;

use Laravel\Ui\UiServiceProvider;
use GeneaLabs\LaravelImpersonator\Providers\Service as LaravelImpersonatorService;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Artisan;

trait CreatesApplication
{
    public function createApplication()
    {
        $this->copyFixtures([
            __DIR__ . '/Fixtures/app/Http/Controllers/HomeController.php' => __DIR__ . '/../vendor/laravel/laravel/app/Http/Controllers/HomeController.php',
            __DIR__ . '/Fixtures/resources/views/home.blade.php' => __DIR__ . '/../vendor/laravel/laravel/resources/views/home.blade.php',
            __DIR__ . '/Fixtures/resources/views/layouts/app.blade.php' => __DIR__ . '/../vendor/laravel/laravel/resources/views/layouts/app.blade.php',
        ]);
        $app = require __DIR__ . '/../vendor/laravel/laravel/bootstrap/app.php';
        $app->register(UiServiceProvider::class);
        $app->register(TestServiceProvider::class);
        $app->register(LaravelImpersonatorService::class);
        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    protected function copyFixtures(array $fixtures)
    {
        $fixtures = collect($fixtures)
            ->each(function ($destination, $source) {
                if (! file_exists(dirname($destination))) {
                    mkdir(dirname($destination), 0777, true);
                }

                $contents = file_get_contents($source);
                file_put_contents($destination, $contents);
            });
    }
}
