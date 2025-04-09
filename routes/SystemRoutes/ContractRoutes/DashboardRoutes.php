<?php

use App\Http\Controllers\Contract\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/basic-contract-history', [DashboardController::class, 'basicContractHistory']);
Route::get('/individual-contract-history', [DashboardController::class, 'individualContractHistory']);
Route::get('/basic-contract-status', [DashboardController::class, 'basicContractList']);
