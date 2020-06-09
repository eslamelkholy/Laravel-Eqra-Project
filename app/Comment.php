<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content', 'user_id','post_id','image'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function likes()
    {
        return $this->hasMany('App\Clike', 'comment_id');
    }

    public function image()
    {
        return $this->hasOne('App\Comment_image','comment_id');
    }
}
