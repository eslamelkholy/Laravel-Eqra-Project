<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventParticipant extends Model
{
    protected $fillable = [
        'state', 'event_id', 'user_id'
    ];
}
