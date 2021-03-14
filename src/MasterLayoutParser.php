<?php


namespace Tray2\SimpleCrud;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MasterLayoutParser
{
    protected $masterFile;

    public function __construct()
    {
        $this->masterFile = $this->getMaster();
    }

    public function hasMaster(): bool
    {
        return ($this->masterFile != NULL);
    }

    protected function getMaster()
    {
        $views = File::allFiles(resource_path('views'));
        foreach ($views as $view) {
            if ($this->isMasterLayout($view)) {
                return $view->getFilename();
            }
        }
    }

    protected function isMasterLayout($view): bool|string
    {
        if ($view->getFileName() != 'welcome.blade.php') {
            return Str::lower(file_get_contents($view->getPathName(), false, null, 0, 9)) == '<!doctype';
        }
        return false;
    }
}