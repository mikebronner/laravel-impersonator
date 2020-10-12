<?php namespace GeneaLabs\LaravelImpersonator\Tests;

use Laravel\Ui\UiServiceProvider;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use GeneaLabs\LaravelImpersonator\Tests\Fixtures\App\Models\User;
use GeneaLabs\LaravelImpersonator\Providers\Service as LaravelImpersonatorService;
use GeneaLabs\LaravelImpersonator\Tests\Fixtures\App\Providers\RouteServiceProvider;

trait CreatesApplication
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations();
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('genealabs-laravel-impersonator.layout', 'genealabs-laravel-impersonator-tests::layouts.app');
        $app['config']->set('auth.providers.users.model', User::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            UiServiceProvider::class,
            RouteServiceProvider::class,
            LaravelImpersonatorService::class,
        ];
    }

    // public function createApplication()
    // {
    //     $this->copyFixtures([
    //         __DIR__ . '/Fixtures/app/Http/Controllers/HomeController.php' => __DIR__ . '/../vendor/laravel/laravel/app/Http/Controllers/HomeController.php',
    //         __DIR__ . '/Fixtures/resources/views/home.blade.php' => __DIR__ . '/../vendor/laravel/laravel/resources/views/home.blade.php',
    //         __DIR__ . '/Fixtures/resources/views/layouts/app.blade.php' => __DIR__ . '/../vendor/laravel/laravel/resources/views/layouts/app.blade.php',
    //     ]);
    // }

    // protected function copyFixtures(array $fixtures)
    // {
    //     $fixtures = collect($fixtures)
    //         ->each(function ($destination, $source) {
    //             if (! file_exists(dirname($destination))) {
    //                 mkdir(dirname($destination), 0777, true);
    //             }

    //             $contents = file_get_contents($source);
    //             file_put_contents($destination, $contents);
    //         });
    // }
}
