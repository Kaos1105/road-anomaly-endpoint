<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Schedule\CompanyCalendarController;

Route::prefix('dashboard')->group(__DIR__ . '/ScheduleRoutes/DashboardRoutes.php');
Route::prefix('weekly')->group(__DIR__ . '/ScheduleRoutes/WeeklyRoutes.php');
Route::prefix('employee')->group(__DIR__ . '/ScheduleRoutes/EmployeeRoutes.php');
Route::prefix('daily')->group(__DIR__ . '/ScheduleRoutes/DailyRoutes.php');
Route::prefix('time')->group(__DIR__ . '/ScheduleRoutes/TimeRoutes.php');
Route::prefix('company-calendar')->group(__DIR__ . '/ScheduleRoutes/CompanyCalendarRoutes.php');
Route::apiResource('company-calendar', CompanyCalendarController::class);
