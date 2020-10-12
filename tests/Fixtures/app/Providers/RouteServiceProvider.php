<?php

namespace GeneaLabs\LaravelImpersonator\Tests\Fixtures\App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'genealabs-laravel-impersonator-tests');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
    }
}
