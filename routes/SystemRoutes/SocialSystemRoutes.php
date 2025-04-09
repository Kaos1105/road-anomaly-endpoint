<?php

use App\Http\Controllers\Social\CustomerController;
use App\Http\Controllers\Social\EventClassificationController;
use App\Http\Controllers\Social\ManagementGroupController;
use App\Http\Controllers\Social\ProductController;
use App\Http\Controllers\Social\SocialDataController;
use App\Http\Controllers\Social\SocialEventController;
use App\Http\Controllers\Social\SupplierController;
use Illuminate\Support\Facades\Route;

//31000
Route::apiResource('event-classification', EventClassificationController::class);

// 32000
Route::prefix('management-group')->group(__DIR__ . '/SocialRoutes/ManagementGroupRoutes.php');
Route::apiResource('management-group', ManagementGroupController::class)->except('index');

// 33000
Route::prefix('customer')->group(__DIR__ . '/SocialRoutes/CustomerRoutes.php');
Route::apiResource('customer', CustomerController::class);

// 34000
Route::prefix('supplier')->group(__DIR__ . '/SocialRoutes/SupplierRoutes.php');
Route::apiResource('supplier', SupplierController::class);

// Dashboard
Route::prefix('dashboard')->group(__DIR__ . '/SocialRoutes/DashboardRoutes.php');

// 35000
Route::prefix('product')->group(__DIR__ . '/SocialRoutes/ProductRoutes.php');
Route::apiResource('product', ProductController::class);

// 36000
Route::prefix('social-event')->group(__DIR__ . '/SocialRoutes/SocialEventRoutes.php');
Route::apiResource('social-event', SocialEventController::class);

//37000
Route::prefix('social-data')->group(__DIR__ . '/SocialRoutes/SocialDataRoutes.php');
Route::apiResource('social-data', SocialDataController::class);
