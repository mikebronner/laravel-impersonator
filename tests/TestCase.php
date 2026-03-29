<?php

namespace GeneaLabs\LaravelImpersonator\Tests;

use GeneaLabs\LaravelImpersonator\Providers\Service;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations();

        // Register a minimal layout view for testing
        $this->app['view']->addLocation(__DIR__ . '/Fixtures/views');

        // Register a login route so auth middleware redirects work
        Route::get('/login', fn () => 'login')->name('login');
    }

    protected function getPackageProviders($app): array
    {
        return [
            Service::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('auth.providers.users.model', Fixtures\User::class);
        $app['config']->set('genealabs-laravel-impersonator.user-model', Fixtures\User::class);
    }
}
