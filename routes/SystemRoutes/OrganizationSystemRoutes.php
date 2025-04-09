<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Organization\CompanyController;
use App\Http\Controllers\Organization\SiteController;
use App\Http\Controllers\Organization\DepartmentController;
use App\Http\Controllers\Organization\DivisionController;
use App\Http\Controllers\Organization\EmployeeController;
use App\Http\Controllers\Organization\TransferController;

// 22000
Route::prefix('company')->group(__DIR__ . '/OrganizationRoutes/CompanyRoutes.php');
Route::apiResource('company', CompanyController::class);

// 23000
Route::prefix('site')->group(__DIR__ . '/OrganizationRoutes/SiteRoutes.php');
Route::apiResource('site', SiteController::class);

// 24000
Route::prefix('department')->group(__DIR__ . '/OrganizationRoutes/DepartmentRoutes.php');
Route::apiResource('department', DepartmentController::class)->except('index');

// 25000
Route::prefix('division')->group(__DIR__ . '/OrganizationRoutes/DivisionRoutes.php');
Route::apiResource('division', DivisionController::class)->except('index');

// 26000
Route::prefix('employee')->group(__DIR__ . '/OrganizationRoutes/EmployeeRoutes.php');
Route::apiResource('employee', EmployeeController::class)->except('show');

// 27000
Route::prefix('transfer')->group(__DIR__ . '/OrganizationRoutes/TransferRoutes.php');
Route::apiResource('transfer', TransferController::class)->except('index');

Route::prefix('access-history')->group(__DIR__ . '/OrganizationRoutes/AccessHistoryRoutes.php');
