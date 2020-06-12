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
    public function privateMessages($id){
        $messages=Message::with('user')
        ->where(['user_id'=>Auth::user()->id,'reciever_id'=>$id])
        ->orWhere(function($query) use($id){
            $query->where(['user_id'=>$id,'reciever_id'=>Auth::user()->id]);
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
