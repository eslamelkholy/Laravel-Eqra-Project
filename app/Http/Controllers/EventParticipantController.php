<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventParticipant;
use App\Event;
class EventParticipantController extends Controller
{

    public function addParticipant(Request $request, $id)
    {
        $event = Event::find($id);
        if (is_null($event))
            return response()->json(["message" => "Event Not Found"], 404);
        return response()->json(["event" => $event]);
    }
    public function update(Request $request, $id)
    {
        //
    }
}
