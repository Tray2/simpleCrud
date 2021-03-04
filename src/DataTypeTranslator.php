<?php


namespace Tray2\SimpleCrud;


class DataTypeTranslator
{
    protected $mysqlNumberTypes = ['tinyint', 'smallint', 'mediumint', 'int', 'bigint', 'decimal', 'float', 'double', 'bit'];
    protected $mysqlTextTypes = ['char', 'varchar'];
    protected $mysqlClobTypes = ['tinytext', 'text', 'mediumtext', 'longtext'];
    protected $mysqlDateTypes = ['date', 'time', 'datetime', 'timestamp', 'year'];
    protected $mysqlDataTypes;

    public function __construct()
    {
        $this->mysqlDataTypes = collect([
            'numbers' => collect($this->mysqlNumberTypes),
            'text' => collect($this->mysqlTextTypes),
            'date' => collect($this->mysqlDateTypes),
            'clob' => collect($this->mysqlClobTypes)
        ]);
    }

    public function getDataType($field, $dataType): string
    {
        if ($this->isForeignKey($field)) return 'select';
        return $this->getColumnType($dataType);
    }

    protected function getColumnType($dataType): string
    {
        if ($this->isNumericalType($dataType)) return 'number';
        if ($this->isStringType($dataType)) return 'text';
        if ($this->isDateType($dataType)) return 'date';
        if ($this->isClobType($dataType)) return 'textarea';
        return 'text';
    }

    protected function isNumericalType($dataType)
    {
        return $this->mysqlDataTypes['numbers']->contains($dataType);
    }

    protected function isStringType($dataType)
    {
        return $this->mysqlDataTypes['text']->contains($dataType);
    }

    protected function isDateType($dataType)
    {
        return $this->mysqlDataTypes['date']->contains($dataType);
    }

    protected function isClobType($dataType)
    {
        return $this->mysqlDataTypes['clob']->contains($dataType);
    }

    protected function isForeignKey($field): bool
    {
        return (substr($field, -3) == '_id' );
    }

}