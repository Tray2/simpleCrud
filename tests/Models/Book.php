<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = ['some_guarded_field'];
    protected $fillable = ['some_fillable_field'];
    protected $hidden = ['some_hidden_field'];
}