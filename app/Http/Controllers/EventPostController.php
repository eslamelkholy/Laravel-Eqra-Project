<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventPost;
use App\Event;
class EventPostController extends Controller
{
    public function getEventPosts(Request $request,Event $event)
    {
        return response()->json(["event >>>" => $event->posts]);
    }
}
