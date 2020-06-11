<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\PostAdded;
use App\Events\PrivateMessageSent;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function privateMessages(User $user){
        $messages=Message::with('user')
        ->where(['user_id'=>auth()->id,'reciever_id'=>$user->id])
        ->orWhere(function($query) use($user){
            $query->where(['user_id'=>$user->id,'reciever_id'=>auth()->id]);
        })->get();

        return $messages;
    }

    public function sendPrivateMessage(Request $request){
        $message=new Message([
            'user_id'=>Auth::user()->id,
            'message'=>$request->message,
            'reciever_id'=>$request->reciever_id
        ]);
        $message->save();
        broadcast(new MessageSent($message))->toOthers();
        return ['status' => 'Message Sent!'];
    }


}
