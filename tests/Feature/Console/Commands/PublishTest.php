<?php namespace GeneaLabs\LaravelImpersonator\Tests\Feature\Console\Commands;

use GeneaLabs\LaravelImpersonator\Tests\TestCase;

class PublishTest extends TestCase
{
    public function testConfigFileIsPublished()
    {
        $this->artisan('impersonator:publish', ['--config' => true]);

        $this->assertFileExists(config_path('genealabs-laravel-impersonator.php'));
    }
}
