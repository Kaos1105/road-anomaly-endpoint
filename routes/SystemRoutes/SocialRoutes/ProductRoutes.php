<?php

use App\Http\Controllers\Social\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('dropdown-supplier', [ProductController::class, 'getDropdownSupplierCompany']);
Route::get('/{product}/social-data-five-year', [ProductController::class, 'getFiveYearSocialData']);
