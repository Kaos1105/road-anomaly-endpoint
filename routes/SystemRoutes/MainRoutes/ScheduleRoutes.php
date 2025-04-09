<?php

use App\Http\Controllers\Main\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('weekly', [DashboardController::class, 'getWeeklySchedule']);
Route::get('year', [DashboardController::class, 'getScheduleManagement']);
