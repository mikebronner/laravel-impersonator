<?php namespace GeneaLabs\LaravelImpersonator\Tests\Feature\Console\Commands;

use GeneaLabs\LaravelImpersonator\Tests\TestCase;

class PublishTest extends TestCase
{
    private function delTree($folder)
    {
        if (! is_dir($folder)) {
            return false;
        }

        $files = array_diff(scandir($folder), ['.','..']);

        foreach ($files as $file) {
            is_dir("$folder/$file") ? $this->delTree("$folder/$file") : unlink("$folder/$file");
        }

        return rmdir($folder);
    }

    public function testConfigFileIsPublished()
    {
        unlink(config_path('genealabs-laravel-impersonator.php'));

        $this->artisan('impersonator:publish', ['--config' => true]);

        $this->assertFileExists(config_path('genealabs-laravel-impersonator.php'));
    }

    public function testViewsArePublished()
    {
        $this->delTree(resource_path('views/vendor/genealabs/laravel-impersonator'));

        $this->artisan('impersonator:publish', ['--views' => true]);

        $this->assertDirectoryExists(resource_path('views/vendor/genealabs/laravel-impersonator'));
    }
}
