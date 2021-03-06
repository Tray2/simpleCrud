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

}