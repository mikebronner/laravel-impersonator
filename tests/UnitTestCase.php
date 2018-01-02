<?php namespace GeneaLabs\LaravelImpersonator\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class UnitTestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;
}
