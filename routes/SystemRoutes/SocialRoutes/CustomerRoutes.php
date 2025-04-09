<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Social\CustomerController;
use App\Http\Controllers\Social\EmployeeController;

Route::get('dropdown-customer-category', [CustomerController::class, 'dropdownCustomerCategory']);
Route::get('dropdown-affiliated', [CustomerController::class, 'dropdownAffiliated']);
Route::get('dropdown-shinnichiro-department', [CustomerController::class, 'dropdownShinnichiroDepartment']);
Route::get('dropdown-company', [EmployeeController::class, 'dropdownCompanySelectEmployees']);
Route::get('employee', [EmployeeController::class, 'getSelectEmployees']);
Route::get('/{employee}/transfers', [EmployeeController::class, 'getTransferByEmployee']);
