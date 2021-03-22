<?php

namespace Tray2\SimpleCrud\Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tray2\SimpleCrud\Tests\TestCase;

class SimpleCrudCommandTest extends TestCase
{
    /**
    * @test
    */
    public function it_can_be_called(): void
    {
        $this->artisan('crud:make', ['model' => 'Author'])
        ->assertExitCode(0);
    }
}
