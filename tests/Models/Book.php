<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $guarded = ['some_guarded_field'];
    protected $fillable = ['some_fillable_field'];
    protected $hidden = ['some_hidden_field'];

    public function authors(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function format(): BelongsTo
    {
        return $this->belongsTo(Format::class);
    }
}