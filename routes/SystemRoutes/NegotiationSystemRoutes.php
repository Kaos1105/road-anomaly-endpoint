<?php

use App\Http\Controllers\Negotiation\NegotiationController;
use App\Http\Controllers\Negotiation\ManagementDepartmentController;
use App\Http\Controllers\Negotiation\ClientSiteController;
use App\Http\Controllers\Negotiation\EmployeeController;
use Illuminate\Support\Facades\Route;

//Dropdown

Route::get('calendar', [NegotiationController::class, 'calendar']);
Route::get('dropdown-management-department', [NegotiationController::class, 'dropdownManagementDepartmentDashboard']);
Route::get('dropdown-client-site-employee', [EmployeeController::class, 'dropdownClientSiteEmployee']);
Route::get('dropdown-my-company-employee', [EmployeeController::class, 'dropdownMyCompanyEmployee']);

//41000
Route::prefix('management-department')->group(__DIR__ . '/NegotiationRoutes/ManagementDepartmentRoutes.php');
Route::apiResource('management-department', ManagementDepartmentController::class);

// 43000
Route::prefix('client-site')->group(__DIR__ . '/NegotiationRoutes/ClientSiteRoutes.php');
Route::apiResource('client-site', ClientSiteController::class);

// 45000
Route::prefix('history')->group(__DIR__ . '/NegotiationRoutes/NegotiationHistoryRoutes.php');
Route::apiResource('history', NegotiationController::class);

// Access history
Route::prefix('dashboard')->group(__DIR__ . '/NegotiationRoutes/DashboardRoutes.php');
