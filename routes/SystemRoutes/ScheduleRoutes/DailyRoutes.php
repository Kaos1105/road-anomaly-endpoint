<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Schedule\DailyScheduleController;

Route::post('/', [DailyScheduleController::class, 'upsertDaily']);
