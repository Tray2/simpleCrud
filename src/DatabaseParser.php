<?php


namespace Tray2\SimpleCrud;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseParser
{
    public function parse($model): array
    {
        $table =  Str::plural(Str::snake($model));
        return $this->getMysqlTableAttributes($table);
    }

    protected function getDatabaseName(): string
    {
        return DB::connection()->getDatabaseName();
    }

    protected function getMysqlTableAttributes($table): array
    {
        $database = $this->getDatabaseName();
        return DB::select(
     "SELECT column_name, data_type, is_nullable, column_default
             FROM information_schema.columns
             WHERE table_schema = '{$database}'
             AND table_name = '{$table}'"
        );
    }

}