<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

/* Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
}); */

Broadcast::channel('notify.stream.{userId}', function ($user, $userId) {
    //$user = $user->cases();
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('login', function ($user) {
    $user->profile_image = url($user->image);
    return (int) auth()->user()->id === (int) $user->id ? $user : false;
});

Broadcast::channel('App.Models.User.{id}', function ($user, $classID) {
    return true;
});