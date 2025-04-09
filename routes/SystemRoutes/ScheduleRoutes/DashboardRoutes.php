<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Schedule\DashboardController;
use App\Http\Controllers\Schedule\GroupController;

Route::get('calendar', [DashboardController::class, 'calendar']);
Route::get('dropdown-group', [GroupController::class, 'dropdownGroup']);
