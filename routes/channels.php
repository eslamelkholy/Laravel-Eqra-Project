<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{id}', function ($user) {
    return Auth::check();
});

Broadcast::channel('chat.{id}', function ($user) {
    return Auth::check();
});

Broadcast::channel('followed.{id}', function ($user) {
    return Auth::check();
});

// Broadcast::channel('chat.{recieverid}', function ($user,$recieverid) {
//     return Auth::check();
// });
