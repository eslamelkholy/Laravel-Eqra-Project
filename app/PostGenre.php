<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostGenre extends Model
{
    protected $fillable = [
        'genre_id','post_id'
    ];

}
