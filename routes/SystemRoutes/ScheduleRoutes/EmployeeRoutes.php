<?php

use App\Http\Controllers\Schedule\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('weekly-dropdown-employee', [EmployeeController::class, 'weeklyScheduleDropdownEmployee'])->name('weekly_schedule.dropdown_employee');
