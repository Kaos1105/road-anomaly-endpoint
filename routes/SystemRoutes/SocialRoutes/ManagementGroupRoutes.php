<?php

use App\Http\Controllers\Social\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Social\ManagementGroupController;

Route::get('dropdown-employee', [EmployeeController::class, 'dropdownEmployee']);
