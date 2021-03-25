<?php /** @noinspection PhpMissingFieldTypeInspection */


namespace Tray2\SimpleCrud\Console;


use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Filesystem\FileExistsException;
use Tray2\SimpleCrud\ModelParser;
use Tray2\SimpleCrud\ViewWriter;

class SimpleCrudCommand extends Command
{
    protected $signature = 'crud:make {model} {--modelpath=}';

    public function handle(): int
    {
        $modelPath = $this->option('modelpath') ?? '';

        try {
            $model = new ModelParser($this->argument('model'), $modelPath);
        } catch (BindingResolutionException $e) {
           $this->error($e->getMessage());
        }
        $viewWriter = new ViewWriter();
        try {
            $viewWriter->save($this->argument('model'), 'create');
            $viewWriter->save($this->argument('model'), 'edit');
        } catch (FileExistsException $e) {
            $this->error($e->getMessage());
        }
        return 0;
    }
}
