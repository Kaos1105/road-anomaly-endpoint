<?php

use App\Http\Controllers\Contract\BasicContractController;

use App\Http\Controllers\Contract\DropdownController;

use Illuminate\Support\Facades\Route;

// Dashboard
Route::prefix('dashboard')->group(__DIR__ . '/ContractRoutes/DashboardRoutes.php');

// 91000
Route::prefix('basic-contract')->group(__DIR__ . '/ContractRoutes/BasicContractRoutes.php');
Route::apiResource('basic-contract', BasicContractController::class);

// Dropdown
Route::get('dropdown-division', [DropdownController::class, 'dropdownDivision']);
// 91000
Route::get('dropdown-site-company', [DropdownController::class, 'dropdownSiteCompanyContract']);
Route::get('dropdown-employee-contract', [DropdownController::class, 'dropdownEmployeeContract']);
// 9120
Route::get('dropdown-site', [DropdownController::class, 'dropdownSite']);
Route::get('dropdown-company', [DropdownController::class, 'dropdownCompany']);
Route::get('dropdown-employee', [DropdownController::class, 'dropdownEmployee']);
