<?php

use App\Http\Controllers\Social\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/social-event', [DashboardController::class, 'socialEventList']);
Route::get('/event-classification', [DashboardController::class, 'eventClassificationList']);
Route::get('/management-group', [DashboardController::class, 'managementGroupList']);
Route::get('/supplier', [DashboardController::class, 'supplierCard']);
Route::get('/product', [DashboardController::class, 'productCard']);
Route::get('/customer', [DashboardController::class, 'customerCard']);
Route::get('/social-data', [DashboardController::class, 'summaryGraph']);
