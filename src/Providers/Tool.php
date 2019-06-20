<?php namespace GeneaLabs\LaravelImpersonator\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use GeneaLabs\LaravelImpersonator\Http\Middleware\Authorize;

class Tool extends ServiceProvider
{
    public function boot()
    {
        if (class_exists("Laravel\Nova\Nova")) {
            $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'laravel-impersonator');

            $this->app->booted(function () {
                $this->routes();
            });

            \Laravel\Nova\Nova::serving(function (\Laravel\Nova\Events\ServingNova $event) {
                //
            });
        }
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
            ->prefix('genealabs/laravel-impersonator/nova')
            ->namespace("GeneaLabs\LaravelImpersonator\Http\Controllers\Nova")
            ->group(__DIR__ . '/../../routes/nova.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
