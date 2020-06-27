<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\PostAdded;
use App\Events\PrivateMessageSent;
use App\Http\Resources\Message as ResourcesMessage;
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

    public function getUnseenMessagesUsers(){
        $messages=Message::where([['seen','=','false'],['reciever_id','=',Auth::user()->id]])->get();
        return ResourcesMessage::collection($messages);
    }

    public function seenMessages($id){
        Message::where([['user_id','=',$id],['reciever_id','=',Auth::user()->id]])->update(['seen'=>'1']);
    }

    public function sendPrivateMessage(Request $request){
        $message=new Message([
            'user_id'=>Auth::user()->id,
            'message'=>$request->message,
            'reciever_id'=>$request->reciever_id,
            'seen'=>false
        ]);
        $message->save();
        $user=Message::find($message->id)->user;
        broadcast(new MessageSent($message,$user))->toOthers();
        return ['status' => 'Message Sent!'];
    }


}