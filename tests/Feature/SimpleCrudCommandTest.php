<?php

namespace Tray2\SimpleCrud\Tests\Feature;

use Tray2\SimpleCrud\Tests\TestCase;

class SimpleCrudCommandTest extends TestCase
{
    /**
    * @test
    */
    public function it_can_be_called(): void
    {
        $this->artisan('crud:make Author')
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

    /**q
    * @test
    */
    public function an_optional_custom_model_path_can_be_provided(): void
    {
        $this->artisan('crud:make SomeModel --modelpath=App')
            ->expectsOutput('Target class [App\SomeModel] does not exist.');
    }

    /**
    * @test
    */
    public function it_generates_the_create_blade_view_for_the_given_model(): void
    {
        $this->artisan('crud:make Book');
        self::assertFileExists(resource_path('views/books/create.blade.php'));
    }

    /**
    * @test
    */
    public function it_generates_the_edit_blade_view_for_the_given_model(): void
    {
        $this->artisan('crud:make Book');
        self::assertFileExists(resource_path('views/books/edit.blade.php'));
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->deleteAll(resource_path('views'));
    }
}
