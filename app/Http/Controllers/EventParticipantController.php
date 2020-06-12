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
    public function changeParticipantStatus(Request $request, $id)
    {
        $event = Event::find($id);
        if (is_null($event))
            return response()->json(["message" => "Event Not Found"], 404);
        EventParticipant::UpdateOrCreate(
            ['user_id' => Auth::id(), 'event_id' => $id],
            [ 'state' => $request->state ]
        );
        return response()->json(["message" => "State Updated Successfully", 'state' => $request->state]);
    }

    public function getUserEventStatus(Request $request, $id)
    {
        $currentUserStatus = EventParticipant::where(['user_id' => Auth::id(), 'event_id' => $id])->first();
        if(is_null($currentUserStatus))
            return response()->json(['state' => 'clickToJoin'], 200);
        return response()->json(['state' => $currentUserStatus->state], 200);
    }
}
