<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Organization\DivisionController;

Route::get('/dropdown-division', [DivisionController::class, 'dropdownDivisions']);
