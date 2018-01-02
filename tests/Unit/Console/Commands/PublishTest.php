<?php namespace GeneaLabs\LaravelImpersonator\Tests\Unit\Console\Commands;

use GeneaLabs\LaravelImpersonator\Tests\UnitTestCase;

class PublishTest extends UnitTestCase
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
        if (file_exists(config_path('genealabs-laravel-impersonator.php'))) {
            unlink(config_path('genealabs-laravel-impersonator.php'));
        }

        $this->artisan('impersonator:publish', ['--config' => true]);

        $this->assertFileExists(config_path('genealabs-laravel-impersonator.php'));
    }

    public function testViewsArePublished()
    {
        $this->delTree(resource_path('views/vendor/genealabs/laravel-impersonator'));

        $this->artisan('impersonator:publish', ['--views' => true]);

        $this->assertDirectoryExists(resource_path('views/vendor/genealabs/laravel-impersonator'));
    }

    public function testViewsAreDeletedBeforePublishing()
    {
        $this->artisan('impersonator:publish', ['--views' => true]);
        app('files')->makeDirectory(resource_path('views/vendor/genealabs/laravel-impersonator/test'), 0755, true);
        app('files')->put(resource_path('views/vendor/genealabs/laravel-impersonator/test/testfile.php'), '');

        $testFileExistedBefore = file_exists(resource_path('views/vendor/genealabs/laravel-impersonator/test/testfile.php'));
        $this->artisan('impersonator:publish', ['--views' => true]);
        $testFileExistsAfter = file_exists(resource_path('views/vendor/genealabs/laravel-impersonator/test/testfile.php'));

        $this->assertTrue($testFileExistedBefore);
        $this->assertFalse($testFileExistsAfter);
        $this->assertDirectoryExists(resource_path('views/vendor/genealabs/laravel-impersonator'));
    }
}
