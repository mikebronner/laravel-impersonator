<?php namespace GeneaLabs\LaravelImpersonator\Tests;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadFactoriesFrom(__DIR__ . '/Fixtures/database/factories');
        $this->loadRoutesFrom(__DIR__ . '/Fixtures/routes/web.php');
    }
}
