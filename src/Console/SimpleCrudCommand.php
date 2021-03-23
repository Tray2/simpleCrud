<?php


namespace Tray2\SimpleCrud\Console;


use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Symfony\Component\Console\Exception\RuntimeException;
use Tray2\SimpleCrud\ModelParser;

class SimpleCrudCommand extends Command
{
    protected $signature = 'crud:make {model}';

    public function handle(): int
    {
        try {
            $model = new ModelParser($this->argument('model'));
        } catch (BindingResolutionException $e) {
           $this->error($e->getMessage());
        }
        return 0;
    }
}