<?php


namespace Tray2\SimpleCrud;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MasterLayoutParser
{
    protected string $masterFile;
    protected string $masterPath;

    public function __construct()
    {
        $this->getMaster();
    }

    public function hasMaster(): bool
    {
        return ($this->masterFile !== NULL);
    }

    protected function getMaster(): string
    {
        $views = File::allFiles(resource_path('views'));
        foreach ($views as $view) {
            if ($this->isMasterLayout($view)) {
                $this->masterPath = $view->getPathName();
                $this->masterFile =  $view->getFilename();
            }
        }
        return '';
    }

    protected function isMasterLayout($view): bool
    {
        if ($view->getFileName() !== 'welcome.blade.php') {
            return Str::lower(file_get_contents($view->getPathName(), false, null, 0, 9)) === '<!doctype';
        }
        return false;
    }

    public function getYields()
    {
        $body = $this->getBody($this->masterPath);
        $pattern = '/@yield[(]\'(\w+)\'[)]/';
        preg_match_all($pattern, $body, $matches);

        if (count($matches) > 1) {
            return $matches[1];
        }
        return [];
    }

    protected function getBody(string $masterPath)
    {
        $pattern = '/(?s)(?<=<body>).*(?=<\/body>)/';
        $masterBody = file_get_contents($masterPath);
        preg_match($pattern, $masterBody, $match);
        return $match[0];
    }
}