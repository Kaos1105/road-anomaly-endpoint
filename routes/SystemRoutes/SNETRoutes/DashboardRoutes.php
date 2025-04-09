<?php

use App\Http\Controllers\SNET\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/unread-chat', [DashboardController::class, 'getUnreadChatInfo']);
Route::get('/system-management', [DashboardController::class, 'getSystemManagement']);
Route::get('/authentication-history', [DashboardController::class, 'getAuthenticationHistory']);
