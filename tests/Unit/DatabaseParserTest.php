<?php


namespace Tray2\SimpleCrud\Tests\Unit;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tray2\SimpleCrud\DatabaseParser;
use Tray2\SimpleCrud\Tests\TestCase;

class DatabaseParserTest extends TestCase
{
    protected function useMysqlConnection($app)
    {
        $app->config->set('database.default', 'mysql');
    }

    /**
     * @test
     * @environment-setup useMysqlConnection
     */
    public function it_can_instantiate_the_class()
    {
        $databaseParser = new DatabaseParser();
        $this->assertInstanceOf(DatabaseParser::class, $databaseParser );
    }

    /**
    * @test
    * @environment-setup useMysqlConnection
    */
    public function it_can_fetch_the_table_information_in_mysql()
    {
        $databaseParser = new DatabaseParser();
        $tableInformation = $databaseParser->parse('Book');
        $this->assertEquals('id', $tableInformation[0]->column_name);
        $this->assertEquals('bigint', $tableInformation[0]->data_type);
        $this->assertEquals('NO', $tableInformation[0]->is_nullable);
        $this->assertNull($tableInformation[0]->column_default);
    }

    /**
    * @test
    */
    public function if_the_table_doesnt_exist_it_throws_an_exception()
    {
        $this->expectException(ModelNotFoundException::class);
        $databaseParser = new DatabaseParser();
        $tableInformation = $databaseParser->parse('NotExist');
    }

}