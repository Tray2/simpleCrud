<?php

namespace Tray2\SimpleCrud\Tests\Unit;

use Tray2\SimpleCrud\MasterLayoutParser;
use Tray2\SimpleCrud\Tests\TestCase;

class MasterLayoutParserTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        if (file_exists(resource_path('views'))) {
            $this->deleteAll(resource_path('views'));
        }
        mkdir(resource_path('views'));
    }

    /**
    * @test
    */
    public function it_can_instantiate_the_class(): void
    {
        $masterLayoutParser = new MasterLayoutParser();
        self::assertInstanceOf(MasterLayoutParser::class, $masterLayoutParser);
    }

    /**
    * @test
    */
    public function it_returns_true_if_master_layout_is_found(): void
    {
        $file1 = resource_path('views/books/create.blade.php');
        $file2 = resource_path('views/layout/app.blade.php');
        mkdir(resource_path('views/books'));
        mkdir(resource_path('views/layout'));
        file_put_contents($file1, 'Test');
        file_put_contents($file2, '<!DOCTYPE html>');

        $masterLayoutParser = new MasterLayoutParser();
        self::assertTrue($masterLayoutParser->hasMaster());
    }
    
    /**
    * @test
    */
    public function it_returns_the_yields_in_the_master_layout(): void
    {
        $file = resource_path('views/layout/app.blade.php');
        mkdir(resource_path('views/layout'));
        file_put_contents($file, "<!DOCTYPE html> <body> @yield('content') @yield('main') </body>");

        $masterLayoutParser = new MasterLayoutParser();
        self::assertEquals(['content', 'main'], $masterLayoutParser->getYields());
    }

    /**
    * @test
    */
    public function it_does_not_return_yields_outside_the_body(): void
    {
        $file = resource_path('views/layout/app.blade.php');
        mkdir(resource_path('views/layout'));
        file_put_contents($file, "<!DOCTYPE html><head><title>@yield('title')</title></head><body> @yield('main') </body>");

        $masterLayoutParser = new MasterLayoutParser();
        self::assertEquals(['main'], $masterLayoutParser->getYields());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->deleteAll(resource_path('views'));
    }
}
