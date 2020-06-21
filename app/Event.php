<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 'description', 'location', 'start_date', 'end_date', 'user_id', 'cover_image'
    ];
    // User Events Inverse Relationship
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    // User Joined Specified Event [ The Most Important Relationship While Inviting New Users to Event ]
    public function users()
    {
        return $this->belongsToMany('App\User', 'event_participants')->withTimestamps();;
    }

    // Pending Users
    public function pendingUsers()
    {
        return $this->belongsToMany('App\User', 'event_participants')->where('state', 'pending')->withTimestamps();
    }

    // Interested Users
    public function interestedUsers()
    {
        return $this->belongsToMany('App\User', 'event_participants')->where('state', 'interested')->withTimestamps();
    }

    // Going Users
    public function goingUsers()
    {
        return $this->belongsToMany('App\User', 'event_participants')->where('state', 'going')->withTimestamps();
    }

    public function posts()
    {
        return $this->belongsToMany('App\Post', 'event_posts');
    }

}
