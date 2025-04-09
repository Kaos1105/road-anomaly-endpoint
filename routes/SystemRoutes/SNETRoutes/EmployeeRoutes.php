<?php

use App\Http\Controllers\SNET\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('dropdown-employee', [EmployeeController::class, 'dropdownEmployee']);
Route::get('dropdown-transfer-employee', [EmployeeController::class, 'dropdownTransferEmployee']);

Route::get('accessible-employee', [EmployeeController::class, 'getAccessibleEmployee'])->name('employee.getAccessibleEmployee');
Route::get('{employee}', [EmployeeController::class, 'show']);
