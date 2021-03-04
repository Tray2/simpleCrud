<?php


namespace Tray2\SimpleCrud\Tests\Unit;


use Tray2\SimpleCrud\DataTypeTranslator;
use Tray2\SimpleCrud\Tests\TestCase;

class DataTypeTranslatorTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_instantiate_the_class()
    {
        $dataTypeTranslator = new DataTypeTranslator();
        $this->assertInstanceOf(DataTypeTranslator::class, $dataTypeTranslator );
    }

    /**
    * @test
    * @dataProvider  mysqlDataTypesProvider
    * @param $fieldName
    * @param $dataType
    * @param $expectedType
    */
    public function if_returns_the_correct_input_type_for_the_datatype($fieldName, $dataType, $expectedType)
    {
        $dataTypeTranslator = new DataTypeTranslator();
        $this->assertEquals($expectedType, $dataTypeTranslator->getDataType($fieldName, $dataType));
    }

    public function mysqlDataTypesProvider(): array
    {
        return [
            'tinyint is number' => ['id', 'bigint', 'number'],
            'smallint is number' => ['id', 'smallint', 'number'],
            'mediumint is number' => ['id', 'mediumint', 'number'],
            'int is number' => ['id', 'int', 'number'],
            'bigint is number' => ['id', 'bigint', 'number'],
            'decimal is number' => ['id', 'decimal', 'number'],
            'float is number' => ['id', 'float', 'number'],
            'double is number' => ['id', 'double', 'number'],
            'bit is number' => ['id', 'bit', 'number'],
            'char is text' => ['id', 'char', 'text'],
            'varchar is text' => ['id', 'varchar', 'text'],
            'tinytext is textarea' => ['id', 'tinytext', 'textarea'],
            'text is textarea' => ['id', 'text', 'textarea'],
            'mediumtext is textarea' => ['id', 'mediumtext', 'textarea'],
            'longtext is textarea' => ['id', 'longtext', 'textarea'],
            'date is date' => ['id', 'date', 'date'],
            'time is date' => ['id', 'time', 'date'],
            'datetime is date' => ['id', 'datetime', 'date'],
            'timestamp is date' => ['id', 'timestamp', 'date'],
            'year is date' => ['id', 'year', 'date'],
            'foreign keys are selects' => ['artist_id', 'bigint', 'select'],
        ];
    }



}