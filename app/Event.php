<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 'name', 'description', 'start_date', 'end_date', 'user_id'
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
}
