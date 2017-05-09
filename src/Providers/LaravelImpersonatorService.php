<?php namespace GeneaLabs\LaravelImpersonator\Providers;

use GeneaLabs\LaravelImpersonator\Console\Commands\Publish;
use GeneaLabs\LaravelImpersonator\Policies\Impersonation;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

class LaravelImpersonatorService extends AuthServiceProvider
{
    protected $defer = false;
    protected $policies = [];

    public function boot()
    {
        $configPath = __DIR__ . '/../../config/genealabs-laravel-impersonator.php';
        $migrationsFolder = __DIR__ . '/../../database/migrations';
        $publicFolder = __DIR__ . '/../../public/';
        $routesPath = __DIR__ . '/../../routes/web.php';
        $viewsFolder = __DIR__ . '/../../resources/views';

        $this->publishes([
            $configPath => config_path('genealabs-laravel-impersonator.php')
        ], 'config');
        $this->publishes([
            $migrationsFolder => database_path('migrations')
        ], 'migrations');
        $this->publishes([
            $publicFolder => public_path('genealabs-laravel-impersonator'),
        ], 'assets');

        $this->loadMigrationsFrom($migrationsFolder);
        $this->loadRoutesFrom($routesPath);
        $this->loadViewsFrom($viewsFolder, 'genealabs-laravel-impersonator');
        $this->mergeConfigFrom($configPath, 'genealabs-laravel-impersonator');

        app('router')->model(
            'impersonatee',
            config('genealabs-laravel-impersonator.user-model')
        );

        $this->policies = [
            config('genealabs-laravel-impersonator.user-model') => Impersonation::class,
        ];

        $this->registerPolicies();

        // app('Illuminate\Contracts\Auth\Access\Gate')->before(function ($user) {
        //     return $user->canImpersonate;
        // });
    }

    public function register()
    {
        $this->commands(Publish::class);
    }

    public function provides() : array
    {
        return ['genealabs-laravel-impersonator'];
    }
}
