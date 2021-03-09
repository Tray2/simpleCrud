<?php
namespace Tray2\SimpleCrud\Tests\Unit;

use Illuminate\Contracts\Filesystem\FileExistsException;
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
      $view = resource_path('views/books/create.blade.php');
      $this->assertFileDoesNotExist($view);
      $viewWriter = new ViewWriter();
      $viewWriter->save('Book', 'create');
      $this->assertFileExists($view);
    }

    /**
    * @test
    */
    public function if_the_file_already_exists_throw_an_file_exists_exception()
    {
        $file = resource_path('views/books/create.blade.php');
        file_put_contents($file, 'Test');
        $this->assertFileExists($file);
        $this->expectException(FileExistsException::class);
        $viewWriter = new ViewWriter();
        $viewWriter->save('Book', 'create');
    }

    /**
    * @test
    */
    public function the_file_is_named_after_the_view()
    {
        $view = resource_path('views/books/index.blade.php');
        $this->assertFileDoesNotExist($view);
        $viewWriter = new ViewWriter();
        $viewWriter->save('Book', 'index');
        $this->assertFileExists($view);

    }

    protected function tearDown(): void
    {
        parent::tearDown();
        array_map('unlink', glob(resource_path('views/books/*.php')));
    }

}