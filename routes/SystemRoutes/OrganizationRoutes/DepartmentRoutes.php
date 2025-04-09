<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Organization\DepartmentController;

Route::get('dropdown-department', [DepartmentController::class, 'organizationDropdownDepartments']);
Route::get('shinnichiro', [DepartmentController::class, 'getShinnichiroDepartments']);
Route::get('{department}/divisions', [DepartmentController::class, 'getDivisions']);
Route::put('{department}/representative', [DepartmentController::class, 'setRepresentative']);
