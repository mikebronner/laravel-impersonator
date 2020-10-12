<?php

namespace GeneaLabs\LaravelImpersonator\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class UnitTestCase extends BaseTestCase
{
    use CreatesApplication;
    // use DatabaseMigrations;
}
