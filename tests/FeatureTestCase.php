<?php namespace GeneaLabs\LaravelImpersonator\Tests;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Orchestra\Testbench\BrowserKit\TestCase;

abstract class FeatureTestCase extends TestCase
{
    use CreatesApplication;
    // use DatabaseMigrations;
    // use DatabaseTransactions;
    public function test()
    {

    }
}
