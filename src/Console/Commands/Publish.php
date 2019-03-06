<?php namespace GeneaLabs\LaravelImpersonator\Console\Commands;

use GeneaLabs\LaravelImpersonator\Providers\Service;
use Illuminate\Console\Command;

class Publish extends Command
{
    protected $signature = 'impersonator:publish {--config} {--views}';
    protected $description = 'Publish various assets of the Laravel Impersonator package.';

    public function handle()
    {
        if (count($this->options()) === 0) {
            $this->info('Please use at least one of the options: "impersonator:publish {--config} {--views}"');
        }

        if ($this->option('views')) {
            $this->delTree(resource_path('views/vendor/genealabs-laravel-impersonator'));
            $this->call('vendor:publish', [
                '--provider' => Service::class,
                '--tag' => ['views'],
                '--force' => true,
            ]);
        }

        if ($this->option('config')) {
            $this->call('vendor:publish', [
                '--provider' => Service::class,
                '--tag' => ['config'],
                '--force' => true,
            ]);
        }
    }

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
}
