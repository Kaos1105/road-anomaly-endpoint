<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Schedule\WeeklyScheduleController;

Route::post('/', [WeeklyScheduleController::class, 'upsertWeekly'])->name('weekly_schedule.upsert');
Route::get('/', [WeeklyScheduleController::class, 'index'])->name('weekly_schedule.index');
Route::put('/drag-n-drop', [WeeklyScheduleController::class, 'updateDisplayOrder'])->name('weekly_schedule.updateDisplayOrder');
