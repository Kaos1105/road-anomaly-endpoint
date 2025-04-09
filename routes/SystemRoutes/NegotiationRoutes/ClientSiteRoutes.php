<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Negotiation\ClientSiteController;
use App\Http\Controllers\Negotiation\ClientEmployeeController;

Route::get('dropdown-company', [ClientSiteController::class, 'dropdownCompany']);
Route::get('dropdown-site', [ClientSiteController::class, 'dropdownSite']);
Route::prefix('{client_site}')->group(function () {
    Route::get('negotiation', [ClientSiteController::class, 'getNegotiations']);
    Route::apiResource('employee', ClientEmployeeController::class)->names([
        'index' => 'client-site-employee.index',
        'store' => 'client-site-employee.store',
        'show' => 'client-site-employee.show',
        'update' => 'client-site-employee.update',
        'destroy' => 'client-site-employee.destroy',
    ]);
});
