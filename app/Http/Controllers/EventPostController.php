<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventPost;
use App\Event;
class EventPostController extends Controller
{
    public function saveEventPost(Request $request,Event $event)
    {
        $event->posts()->attach($request->post);
    }
}
