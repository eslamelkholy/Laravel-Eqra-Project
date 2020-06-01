<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clike extends Model
{
    protected $fillable = [
        'comment_id', 'user_id',
    ];
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function comment()
    {
        return $this->belongsTo('App\Post', 'comment_id');
    }
}
