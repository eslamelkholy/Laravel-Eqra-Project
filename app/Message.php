<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    protected $fillable = [
        'message', 'user_id','reciever_id','seen'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
