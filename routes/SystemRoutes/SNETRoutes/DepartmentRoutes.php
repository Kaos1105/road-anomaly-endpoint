<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SNET\DepartmentController;

Route::get('dropdown-department', [DepartmentController::class, 'dropdownDepartments']);
