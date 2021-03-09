<?php


namespace Tray2\SimpleCrud;


use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ViewWriter
{
    public function save($model, $view)
    {
        $file = resource_path('views/' . Str::lower(Str::plural($model)) . '/' . $view . '.blade.php');
        if (File::exists($file)) {
            throw new FileExistsException();
        }
        file_put_contents($file, 'Test');
    }
}