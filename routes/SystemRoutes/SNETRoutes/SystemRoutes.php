<?php

use App\Http\Controllers\SNET\SystemController;
use Illuminate\Support\Facades\Route;

Route::get('dropdown-system', [SystemController::class, 'dropdownSystem']);
Route::get('dropdown-systems-sorted', [SystemController::class, 'getSystemsSorted']);
