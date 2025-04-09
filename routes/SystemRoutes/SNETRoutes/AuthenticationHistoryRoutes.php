<?php

use App\Http\Controllers\SNET\AuthenticationHistoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthenticationHistoryController::class, 'index'])->name('authentication_history.index');
Route::get('/dropdown-year', [AuthenticationHistoryController::class, 'dropdownYears'])->name('authentication_history.dropdownYears');
Route::get('/summary', [AuthenticationHistoryController::class, 'summary'])->name('authentication_history.summary');
