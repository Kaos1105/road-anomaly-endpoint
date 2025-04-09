<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Negotiation\ClientSiteController;
use App\Http\Controllers\Negotiation\MyCompanyEmployeeController;
use App\Http\Controllers\Negotiation\ClientEmployeeController;
use App\Http\Controllers\Negotiation\NegotiationController;

Route::get('dropdown-client-site', [ClientSiteController::class, 'dropdownClientSite']);
Route::get('dropdown-my-company-employee', [MyCompanyEmployeeController::class, 'dropdownMyCompanyEmployee']);
Route::get('dropdown-client-employee', [ClientEmployeeController::class, 'dropdownClientEmployee']);
Route::post('{history}/comment', [NegotiationController::class, 'comment']);
Route::patch('{history}/like', [NegotiationController::class, 'like']);

