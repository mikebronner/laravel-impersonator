<?php namespace GeneaLabs\LaravelImpersonator\Providers;

use GeneaLabs\LaravelImpersonator\Console\Commands\Publish;
use GeneaLabs\LaravelImpersonator\Policies\Impersonation;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

class Service extends AuthServiceProvider
{
    protected $defer = false;
    protected $policies = [];

    public function boot()
    {
        $configPath = __DIR__ . '/../../config/genealabs-laravel-impersonator.php';
        $routesPath = __DIR__ . '/../../routes/web.php';
        $viewsFolder = __DIR__ . '/../../resources/views';

        $this->publishes([
            $configPath => config_path('genealabs-laravel-impersonator.php')
        ], 'config');
        $this->publishes([
            $viewsFolder => resource_path('views/vendor/genealabs-laravel-impersonator'),
        ], 'views');

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
        $this->commands(Publish::class);
    }
}
