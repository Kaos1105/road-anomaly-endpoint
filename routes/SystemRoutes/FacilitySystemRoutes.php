<?php

use App\Http\Controllers\Facility\ReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Facility\EmployeeController;
use App\Http\Controllers\Facility\FacilityGroupController;
use App\Http\Controllers\Facility\MainGroupController;
use App\Http\Controllers\Facility\FacilityController;
use App\Http\Controllers\Facility\UserSettingController;

Route::get('dropdown-main-group', [MainGroupController::class, 'dropdownGroup']);
Route::get('dropdown-facility-group', [FacilityGroupController::class, 'dropdownFacilityGroup']);
Route::get('dropdown-employee', [EmployeeController::class, 'dropdownEmployee']);

Route::prefix('group')->group(__DIR__ . '/FacilityManagementRoutes/GroupRoutes.php');
Route::apiResource('group', FacilityGroupController::class)->names([
    'index' => 'facility-group.index',
    'store' => 'facility-group.store',
    'show' => 'facility-group.show',
    'update' => 'facility-group.update',
    'destroy' => 'facility-group.destroy',
]);

Route::apiResource('facility', FacilityController::class)->except('index');
Route::apiResource('reservation', ReservationController::class);
Route::prefix('reservation')->group(__DIR__ . '/FacilityManagementRoutes/ReservationRoutes.php');

//801
Route::get('user-setting', [UserSettingController::class, 'show']);
Route::post('user-setting', [UserSettingController::class, 'store']);

//80
Route::get('dropdown-facility-group-user', [FacilityGroupController::class, 'dropdownFacilityGroupUserSetting']);
Route::get('dropdown-use-person', [EmployeeController::class, 'dropdownUsePerson']);
