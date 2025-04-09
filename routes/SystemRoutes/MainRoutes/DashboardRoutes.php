<?php

use App\Http\Controllers\Main\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('subsystem-card', [DashboardController::class, 'getCardBySystem']);
Route::get('announcement-card-subsystem', [DashboardController::class, 'getAnnouncementCardBySystem']);
