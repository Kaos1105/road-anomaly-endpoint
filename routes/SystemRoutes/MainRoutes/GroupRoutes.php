<?php

use App\Http\Controllers\Main\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('dropdown-employee', [EmployeeController::class, 'groupDropdownEmployee']);
