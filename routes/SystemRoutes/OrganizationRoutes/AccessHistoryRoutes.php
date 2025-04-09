<?php

use App\Http\Controllers\SNET\AccessHistoryController;
use Illuminate\Support\Facades\Route;

Route::get('', [AccessHistoryController::class, 'getHistoryCompany']);
Route::get('employee', [AccessHistoryController::class, 'getHistoryEmployee']);
Route::get('shinnichiro', [AccessHistoryController::class, 'getHistoryShinichiroEmployee']);

