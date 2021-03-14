<?php

namespace Tray2\SimpleCrud\Tests\Unit;

use Tray2\SimpleCrud\MasterLayoutParser;
use Tray2\SimpleCrud\Tests\TestCase;

class MasterLayoutParserTest extends TestCase
{
    /**
    * @test
    */
    public function it_can_instantiate_the_class()
    {
        $masterLayoutParser = new MasterLayoutParser();
        $this->assertInstanceOf(MasterLayoutParser::class, $masterLayoutParser);
    }

    /**
    * @test
    */
    public function it_returns_true_if_master_layout_is_found()
    {
        $file1 = resource_path('views/books/create.blade.php');
        $file2 = resource_path('views/layout/app.blade.php');
        mkdir(resource_path('views/books'));
        mkdir(resource_path('views/layout'));
        file_put_contents($file1, 'Test');
        file_put_contents($file2, '<!DOCTYPE html>');

        $masterLayoutParser = new MasterLayoutParser();
        $this->assertTrue($masterLayoutParser->hasMaster());
        unlink($file1);
        unlink($file2);
        rmdir(resource_path('/views/books'));
        rmdir(resource_path('/views/layout'));
    }
}
