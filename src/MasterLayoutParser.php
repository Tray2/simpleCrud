<?php /** @noinspection PhpPureAttributeCanBeAddedInspection */


namespace Tray2\SimpleCrud;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MasterLayoutParser
{
    protected array $masterFiles = [];
    protected array $masterPaths = [];
    protected array $yields = [];

    public function __construct()
    {
        $this->getMaster();
    }

    public function hasMaster(): bool
    {
        return (count($this->masterFiles) > 0);
    }

    protected function getMaster(): string
    {
        $views = File::allFiles(resource_path('views'));
        foreach ($views as $view) {
            if ($this->isMasterLayout($view)) {
                $this->masterPaths[] = $view->getPathName();
                $this->masterFiles[] =  $view->getFilename();
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

    public function getYields(): array
    {
       $i = 0;
       foreach ($this->masterPaths as $masterPath) {
           $fileName = str_replace('.blade.php', '', $this->masterFiles[$i]);
           $i++;
           $body = $this->getBody($masterPath);
           $pattern = '/@yield[(]\'(\w+)\'[)]/';
           preg_match_all($pattern, $body, $matches);
           $this->yields[$fileName] = $matches[1];
        }
        return $this->yields;
    }

    protected function getBody(string $masterPath)
    {
        $pattern = '/(?s)(?<=<body>).*(?=<\/body>)/';
        $masterBody = file_get_contents($masterPath);
        preg_match($pattern, $masterBody, $match);
        return $match[0];
    }
}