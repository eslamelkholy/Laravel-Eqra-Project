<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Event extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'user' => $this->user,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_at' => $this->created_at,
            'event_pending_users' => $this->pendingUsers()->count(),
            'event_interested_users' => $this->interestedUsers()->count(),
            'event_going_users' => $this->goingUsers()->count(),
            'event_users' => $this->users,
        ];
    }

    public function with($request){
        return [
            'version' => '1.0.0',
            'events_url' => url("http://127.0.0.1:8000/api/event")
        ];
    }
}
