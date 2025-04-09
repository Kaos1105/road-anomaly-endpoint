<?php

use App\Http\Controllers\SNET\AccessHistoryController;
use Illuminate\Support\Facades\Route;

Route::post('/', [AccessHistoryController::class, 'store'])->name('access_history.store');
Route::post('batch-insert', [AccessHistoryController::class, 'createAccessHistories'])->name('access_history.createAccessHistories');
Route::post('/', [AccessHistoryController::class, 'store'])->name('access_history.store');
Route::get('/topic', [AccessHistoryController::class, 'getTopicDashboard'])->name('access_history.getAccessHistoryDashboard');
Route::get('/user-permission-setting', [AccessHistoryController::class, 'getUserPermissionSettingDashboard'])->name('access_history.getUserPermissionSettingDashboard');
