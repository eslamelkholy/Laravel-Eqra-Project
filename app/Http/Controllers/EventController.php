<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Event;
use App\Http\Resources\Event as EventResource;
use App\Http\Requests\EventRequest;
use Auth;
use Illuminate\Support\Facades\Storage;

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
        $event = Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'user_id' => Auth::id(),
            'cover_image' => $this->uploadEventCoverHandler($request)

        ]);
        return response()->json($event, 201);
    }

    public function show($id)
    {
        $event = $this->getEvent($id);
        if (is_null($event))
            return response()->json(["message" => "Event Not Found"], 404);
        return new EventResource($event);
    }

    public function update(EventRequest $request, $id)
    {
        $event = $this->getEvent($id);
        if (is_null($event))
            return response()->json(["message" => "Event Not Found"], 404);
        $event->update($request->all());
        return response()->json($event, 200);
    }

    public function destroy($id)
    {
        $event = $this->getEvent($id);
        if (is_null($event))
            return response()->json(["message" => "Event Not Found"], 404);
        $event->delete();
        return response()->json(null, 204);
    }

    // Upload Event Cover Handler
    public function uploadEventCoverHandler($request)
    {
        $file = $request->file('cover_image')->store('public');
        return Storage::url($file);
    }

    public function getEvent($eventId)
    {
        return Event::find($eventId);
    }
}
