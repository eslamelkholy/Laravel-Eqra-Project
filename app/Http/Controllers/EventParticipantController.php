<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventParticipant;
use App\Event;
use App\Http\Requests\EventParticipantRequest;
use Auth;

class EventParticipantController extends Controller
{
    public function addParticipant(EventParticipantRequest $request, $id)
    {
        $event = Event::find($id);
        if (is_null($event))
            return response()->json(["message" => "Event Not Found"], 404);
        $event->users()->attach($request->participants);
        return response()->json(["event" => $event]);

    }
    public function ParticipantStatus(Request $request, $id)
    {
        $event = Event::find($id);
        if (is_null($event))
            return response()->json(["message" => "Event Not Found"], 404);
        EventParticipant::UpdateOrCreate(
            ['user_id' => Auth::id(), 'event_id' => $id],
            [ 'state' => $request->state ]
        );
    }
}
