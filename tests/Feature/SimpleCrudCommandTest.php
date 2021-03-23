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

    /**
    * @test
    */
    public function it_displays_an_error_if_the_model_doesnt_exist(): void
    {
        $this->artisan('crud:make SomeModel')
            ->expectsOutput('Target class [App\Models\SomeModel] does not exist.');
    }

    /**
    * @test
    */
    public function an_optional_custom_model_path_can_be_provided(): void
    {
        $this->artisan('crud:make SomeModel --modelpath=App')
            ->expectsOutput('Target class [App\SomeModel] does not exist.');
    }
}
