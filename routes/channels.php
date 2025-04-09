<?php

use App\Broadcasting\AdminThreadsChannel;
use App\Broadcasting\ChatThreadChannel;
use Illuminate\Support\Facades\Broadcast;

//Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
//});

Broadcast::channel('chat_thread.{chatThread}', ChatThreadChannel::class);
Broadcast::channel('admin_threads.{adminEmployeeId}', AdminThreadsChannel::class);
