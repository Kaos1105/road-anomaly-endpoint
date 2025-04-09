<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Organization\EmployeeController;

Route::get('all-by-unit', [EmployeeController::class, 'getEmployeeByUnit']);
Route::get('{employee}', [EmployeeController::class, 'show']);
Route::get('{employee}/transfers', [EmployeeController::class, 'getTransfers']);
