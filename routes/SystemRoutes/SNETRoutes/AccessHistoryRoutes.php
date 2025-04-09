<?php

use App\Http\Controllers\SNET\AccessHistoryController;
use App\Http\Controllers\SNET\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/login-dashboard', [AccessHistoryController::class, 'getAccessHistoryLogin'])->name('access_history.getAccessHistoryLogin');
Route::get('/dropdown-users', [EmployeeController::class, 'dropdownUsers'])->name('access_history.dropdownUsers');
Route::get('/', [AccessHistoryController::class, 'index'])->name('access_history.index');
Route::get('/dropdown-year', [AccessHistoryController::class, 'dropdownYear'])->name('access_history.dropdownYear');
Route::prefix('summary')->group(function () {
    Route::get('system', [AccessHistoryController::class, 'summarySystem'])->name('access_history.summarySystem');
    Route::get('user', [AccessHistoryController::class, 'summaryUser'])->name('access_history.summaryUser');
    Route::get('time', [AccessHistoryController::class, 'summaryTime'])->name('access_history.summaryTime');
});




