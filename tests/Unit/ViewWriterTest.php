<?php
namespace Tray2\SimpleCrud\Tests\Unit;

use Tray2\SimpleCrud\Tests\TestCase;
use Tray2\SimpleCrud\ViewWriter;

class ViewWriterTest extends TestCase
{
    /**
    * @test
    */
    public function it_can_instantiate_the_class()
    {
        $viewWriter = new ViewWriter();
        $this->assertInstanceOf(ViewWriter::class, $viewWriter);
    }
    
    /**
    * @test
    */
    public function it_can_write_a_file_to_the_file_system()
    {
      $file = resource_path('views/books/create.blade.php');
      $this->assertFileDoesNotExist($file);
      file_put_contents($file, 'Test');
      $this->assertFileExists($file);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        array_map('unlink', glob(resource_path('views/books/*.php')));
    }

}