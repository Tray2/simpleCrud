<?php
namespace Tray2\SimpleCrud\Tests\Unit;

use Illuminate\Contracts\Container\BindingResolutionException;
use Tray2\SimpleCrud\ModelParser;
use Tray2\SimpleCrud\Tests\TestCase;

class ModelParserTest extends TestCase
{
    /**
    * @test
    */
    public function it_can_instantiate_the_class(): void
    {
        $modelParser = new ModelParser('Book');
        self::assertInstanceOf(ModelParser::class, $modelParser );
    }

    /**
    * @test
    */
    public function id_created_at_updated_at_and_deleted_at_is_always_in_the_no_display_array(): void
    {
        $modelParser = new ModelParser('Book');
        self::assertContains('id', $modelParser->getNoDisplayItems());
        self::assertContains('created_at', $modelParser->getNoDisplayItems());
        self::assertContains('updated_at', $modelParser->getNoDisplayItems());
        self::assertContains('deleted_at', $modelParser->getNoDisplayItems());
    }

    /**
    * @test
    */
    public function guarded_array_items_are_in_the_no_display_array(): void
    {
        $modelParser = new ModelParser('Book');
        self::assertContains('some_guarded_field', $modelParser->getNoDisplayItems());
    }

    /**
    * @test
    */
    public function hidden_array_items_are_in_the_no_display_array(): void
    {
        $modelParser = new ModelParser('Book');
        self::assertContains('some_hidden_field', $modelParser->getNoDisplayItems());
    }

    /**
    * @test
    */
    public function fillable_array_items_are_in_the_display_array(): void
    {
        $modelParser = new ModelParser('Book');
        self::assertContains('some_fillable_field', $modelParser->getDisplayItems());
    }

    /**
    * @test
    */
    public function when_guarded_is_set_to_empty_array_only_the_hidden_by_default_are_in_no_display(): void
    {
        $modelParser = new ModelParser('Record');
        self::assertContains('id', $modelParser->getNoDisplayItems());
        self::assertContains('created_at', $modelParser->getNoDisplayItems());
        self::assertContains('updated_at', $modelParser->getNoDisplayItems());
        self::assertContains('deleted_at', $modelParser->getNoDisplayItems());
    }

    /**
    * @test
    */
    public function it_returns_the_models_database_connection_name(): void
    {
        $modelParser = new ModelParser('Record');
        self::assertEquals( 'sqlite', $modelParser->getConnectionName());
    }

    /**
    * @test
    */
    public function it_returns_the_models_relations(): void
    {
        $modelParser = new ModelParser('Book');
        $actual = $modelParser->getRelationships();
        self::assertArrayHasKey('authors', $actual);
        self::assertEquals('belongsTo', $actual['authors']);
    }

    /**
    * @test
    */
    public function if_the_model_doesnt_exists_it_throws_an_exception(): void
    {
        $this->expectException(BindingResolutionException::class);
        new ModelParser('NoExist');
    }
}