<?php

use App\Http\Controllers\Social\CompanyController;
use App\Http\Controllers\Social\EmployeeController;
use App\Http\Controllers\Social\ProductController;
use App\Http\Controllers\Social\SiteController;
use App\Http\Controllers\Social\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('site-supplier', [SiteController::class, 'getSiteSupplier']);
Route::get('company-supplier', [CompanyController::class, 'getCompanySupplier']);
Route::get('supplier-person', [EmployeeController::class, 'getSupplierPerson']);
Route::get('/{supplier}/products', [ProductController::class, 'getProductSupplier']);
Route::get('/{supplier}/top-five-product', [ProductController::class, 'getTopFiveBoughtProducts']);
Route::get('/{supplier}/total-amount-five-year', [SupplierController::class, 'getFiveYearTotalAmount']);
