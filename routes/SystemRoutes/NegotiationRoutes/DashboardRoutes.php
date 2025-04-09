<?php

use App\Http\Controllers\Negotiation\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/management-department', [DashboardController::class, 'getManagementDepartment'])->name('dashboard.getManagementDepartment');
Route::get('/client-site', [DashboardController::class, 'getClientSite'])->name('dashboard.getClientSite');
Route::get('/negotiation-history', [DashboardController::class, 'getNegotiationHistory'])->name('dashboard.getNegotiationHistory');
