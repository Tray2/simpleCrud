<?php

namespace Tray2\SimpleCrud\Tests\Unit;

use Tray2\SimpleCrud\MasterLayoutParser;
use Tray2\SimpleCrud\Tests\TestCase;

class MasterLayoutTest extends TestCase
{
    /**
    * @test
    */
    public function it_can_instantiate_the_class()
    {
        $masterLayoutParser = new MasterLayoutParser();
        $this->assertInstanceOf(MasterLayoutParser::class, $masterLayoutParser);
    }
}
