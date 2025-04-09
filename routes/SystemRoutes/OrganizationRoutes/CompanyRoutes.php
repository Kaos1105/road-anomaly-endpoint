<?php

use App\Http\Controllers\Organization\CompanyController;
use Illuminate\Support\Facades\Route;

Route::get('dropdown-company', [CompanyController::class, 'dropdownCompany']);
Route::get('check-shinnichiro', [CompanyController::class, 'checkShinnichiro']);
Route::get('dropdown-group-name', [CompanyController::class, 'dropdown']);
Route::get('{company}/sites', [CompanyController::class, 'getSites']);
Route::put('{company}/representative', [CompanyController::class, 'setRepresentative']);
