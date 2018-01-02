<?php namespace GeneaLabs\LaravelImpersonator\Tests;

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
            __DIR__ . '/Fixtures/routes/web.php' => __DIR__ . '/../vendor/laravel/laravel/routes/web.php',
        ]);
        $app = require __DIR__ . '/../vendor/laravel/laravel/bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
        $app->make(Factory::class)->load(__DIR__ . '/Fixtures/database/factories');
        $app->register(LaravelImpersonatorService::class);

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
