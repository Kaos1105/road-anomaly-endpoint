<?php

use App\Http\Controllers\Organization\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/{site}/departments', [SiteController::class, 'getDepartments']);
Route::get('/dropdown-site', [SiteController::class, 'dropdownSites']);
Route::put('{site}/representative', [SiteController::class, 'setRepresentative']);
