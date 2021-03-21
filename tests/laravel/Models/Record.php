<?php /** @noinspection PhpMissingFieldTypeInspection */


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $guarded = [];
    protected $connection = 'sqlite';
}