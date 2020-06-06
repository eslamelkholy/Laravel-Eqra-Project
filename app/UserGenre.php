<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGenre extends Model
{
    protected $fillable = [
        'user_id', 'genre_id'
    ];
}
