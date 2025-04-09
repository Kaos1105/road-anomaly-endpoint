<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Schedule\TimeScheduleController;

Route::get('/', [TimeScheduleController::class, 'index']);
Route::post('/', [TimeScheduleController::class, 'upsertTime']);
Route::delete('{time}', [TimeScheduleController::class, 'destroy']);
