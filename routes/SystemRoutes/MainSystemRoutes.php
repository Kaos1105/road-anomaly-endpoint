<?php

use App\Http\Controllers\Main\GroupController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Main\DashboardController;
use App\Http\Controllers\Main\DeviceInformationController;


//10200
Route::prefix('group')->group(__DIR__ . '/MainRoutes/GroupRoutes.php');
Route::apiResource('group', GroupController::class)->except('delete');

Route::prefix('schedule')->group(__DIR__ . '/MainRoutes/ScheduleRoutes.php');

Route::get('facility', [DashboardController::class, 'getFacilityReservationCard']);

Route::prefix('dashboard')->group(__DIR__ . '/MainRoutes/DashboardRoutes.php');

Route::prefix('device')->group(__DIR__ . '/MainRoutes/DeviceRoutes.php');
Route::apiResource('device', DeviceInformationController::class)->except('delete');
