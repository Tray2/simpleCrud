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
    public function it_can_instantiate_the_class(): void
    {
        $viewWriter = new ViewWriter();
        self::assertInstanceOf(ViewWriter::class, $viewWriter);
    }

    /**
     * @test
     * @throws FileExistsException
     */
    public function it_can_write_a_file_to_the_file_system(): void
    {
      $view = resource_path('views/books/create.blade.php');
      self::assertFileDoesNotExist($view);
      $viewWriter = new ViewWriter();
      $viewWriter->save('Book', 'create');
      self::assertFileExists($view);
    }

    /**
    * @test
    */
    public function if_the_file_already_exists_throw_an_file_exists_exception(): void
    {
        $file = resource_path('views/books/create.blade.php');
        mkdir(resource_path('views/books'));
        file_put_contents($file, 'Test');
        self::assertFileExists($file);
        $this->expectException(FileExistsException::class);
        $viewWriter = new ViewWriter();
        $viewWriter->save('Book', 'create');
    }

    /**
     * @test
     * @throws FileExistsException
     */
    public function the_file_is_named_after_the_view(): void
    {
        $view = resource_path('views/books/index.blade.php');
        self::assertFileDoesNotExist($view);
        $viewWriter = new ViewWriter();
        $viewWriter->save('Book', 'index');
        self::assertFileExists($view);
    }

    /**
     * @test
     * @throws FileExistsException
     */
    public function if_the_directory_does_not_exists_its_created(): void
    {
        $path = resource_path('views/books');
        self::assertDirectoryDoesNotExist($path);
        $viewWriter = new ViewWriter();
        $viewWriter->save('Book', 'create');
        self::assertDirectoryExists($path);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        array_map('unlink', glob(resource_path('views/books/*.php')));
        if (file_exists(resource_path('views/books'))) {
            rmdir(resource_path('views/books'));
        }
    }
}