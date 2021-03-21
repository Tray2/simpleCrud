<?php


namespace Tray2\SimpleCrud;


use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ViewWriter
{
    /** @noinspection PhpUnhandledExceptionInspection */
    public function save($model, $view): void
    {
        $path = resource_path('views/' . Str::lower(Str::plural($model)));
        $file =  $path . '/' . $view . '.blade.php';
        if (! File::exists($path)) {
            File::makeDirectory($path, recursive: true);
        }
        if (File::exists($file)) {
            throw new FileExistsException();
        }
        file_put_contents($file, 'Test');
    }
}