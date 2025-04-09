<?php

use App\Http\Controllers\SNET\ChatThreadController;
use Illuminate\Support\Facades\Route;

Route::get('user-chat-thread', [ChatThreadController::class, 'getUserChatThread']);
Route::get('admin-threads', [ChatThreadController::class, 'getAllChatThreads']);
Route::put('{chat_thread}/mark-as-read', [ChatThreadController::class, 'markChatThreadRead']);


