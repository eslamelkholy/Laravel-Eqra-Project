<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventPost;
use App\Event;
use App\Http\Resources\Post as PostResource;
class EventPostController extends Controller
{
    public function getEventPosts(Request $request,Event $event)
    {
        $posts = $event->posts()->paginate(10);
        return PostResource::collection($posts);
    }
}
