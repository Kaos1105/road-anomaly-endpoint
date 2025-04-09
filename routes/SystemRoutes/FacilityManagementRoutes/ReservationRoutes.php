<?php

use App\Http\Controllers\Facility\ReservationController;
use Illuminate\Support\Facades\Route;

Route::post('{facility}/copy', [ReservationController::class, 'copy']);
