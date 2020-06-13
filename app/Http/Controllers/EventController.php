<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Http\Resources\Event as EventResource;
use App\Http\Requests\EventRequest;
use Auth;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('WriterMiddleware')->except(['index', 'show']);
    }
    public function index()
    {
        $events = Event::orderBy('start_date', 'desc')->paginate(10);
        return EventResource::collection($events);
    }

    public function store(EventRequest $request)
    {
        $request['user_id'] = Auth::id();
        $event = Event::create($request->all());
        return response()->json($event, 201);
    }

    public function show($id)
    {
        $event = Event::find($id);
        if (is_null($event))
            return response()->json(["message" => "Event Not Found"], 404);
        return new EventResource($event);
    }

    public function update(EventRequest $request, $id)
    {
        $event = Event::find($id);
        if (is_null($event))
            return response()->json(["message" => "Event Not Found"], 404);
        $event->update($request->all());
        return response()->json($event, 200);
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        if (is_null($event))
            return response()->json(["message" => "Event Not Found"], 404);
        $event->delete();
        return response()->json(null, 204);
    }
}
