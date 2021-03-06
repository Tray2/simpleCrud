<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    public function profiles(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }
}