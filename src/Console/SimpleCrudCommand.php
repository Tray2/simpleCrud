<?php


namespace Tray2\SimpleCrud\Console;


use Illuminate\Console\Command;

class SimpleCrudCommand extends Command
{
    protected $signature = 'crud:make {model}';

    public function handle(): int
    {
        return 0;
    }
}