<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','full_name','username' ,'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // posts OneToMany Relationship
    public function posts()
    {
        return $this->hasMany('App\Post', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function Books()
    {
        return $this->hasMany('App\Books');
    }

    // genres ManytoMany Relationship
    public function genres()
    {
        return $this->belongsToMany('App\Genre', 'user_genres')->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany('App\Message','user_id');
    }

    // User Events
    public function events()
    {
        return $this->hasMany('App\Event');
    }

    // Events & Participants ManyToMany Relationship
    public function userJoinedEvents()
    {
        return $this->belongsToMany('App\Event', 'event_participants')->withTimestamps();
    }

    public function followers(){
        return $this->hasMany('App\Follow','followed_id');
    }

    public function following(){
        return $this->hasMany('App\Follow','follower_id');
    }
}
