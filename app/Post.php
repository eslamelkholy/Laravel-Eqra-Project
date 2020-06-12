<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'body_content', 'user_id', 'isFeatured'
    ];
    // Inverse Relationship
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    // PostFiles OneToMany Relationship
    public function postFiles(){
        return $this->hasMany('App\PostFile', 'post_id');
    }
    // Post Likes
    public function likes()
    {
        return $this->hasMany('App\Plike', 'post_id');
    }

    // genres ManytoMany Relationship One Side Only
    public function genres()
    {
        return $this->belongsToMany('App\Genre', 'post_genres');
    }
}
