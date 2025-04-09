<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Negotiation\MyCompanyEmployeeController;
use App\Http\Controllers\Negotiation\DepartmentController;

Route::get('/dropdown-department', [DepartmentController::class, 'dropdownDepartment']);
Route::prefix('{management_department}')->group(function() {
    Route::apiResource('employee', MyCompanyEmployeeController::class)->names([
        'index' => 'my-company-employee.index',
        'store' => 'my-company-employee.store',
        'show' => 'my-company-employee.show',
        'update' => 'my-company-employee.update',
        'destroy' => 'my-company-employee.destroy',
    ]);
});

