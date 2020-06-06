<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_genres')->withTimestamps();;
    }
}
