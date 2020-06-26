<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Auth;
use App\User;
class AddNewFollower implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $followed;
    public $message;
    public function __construct($followed)
    {
        $this->followed = $followed;
        $this->message = Auth::user()->full_name. " Has Been Followed You";
    }
    // Channel
    public function broadcastOn()
    {
        return new Channel('followed.'.$this->followed);
    }
    // Event
    public function broadcastAs()
    {
        return 'followed';
    }
}
