<?php

use App\Http\Controllers\SNET\AccessPermissionController;
use Illuminate\Support\Facades\Route;

Route::put('batch-update', [AccessPermissionController::class, 'updatePermissions'])->name('access_permission.updatePermissions');
Route::put('check-employee-permission/{employee}', [AccessPermissionController::class, 'checkEmployeeAccessPermission'])->name('access_permission.checkEmployeeAccessPermission');
Route::put('check-creating-employee-permission/{employee}', [AccessPermissionController::class, 'checkCreatingEmployeeAccessPermission'])->name('access_permission.checkCreateEmployeeAccessPermission');
Route::get('get-employee-permission/{employee}', [AccessPermissionController::class, 'getEmployeeAccessPermission'])->name('access_permission.getEmployeeAccessPermission');
Route::get('get-user-permission/{employee}', [AccessPermissionController::class, 'getUserPermission'])->name('access_permission.getUserPermission');
Route::put('update-user-permission/{employee}', [AccessPermissionController::class, 'updateUserPermission'])->name('access_permission.updateUserPermission');
Route::get('get-creating-employee-permission/{employee}', [AccessPermissionController::class, 'getCreatingEmployeePermission'])->name('access_permission.getCreateEmployeePermission');
Route::put('update-user-permission/{employee}', [AccessPermissionController::class, 'updateUserPermission'])->name('access_permission.updateUserPermission');
Route::post('create-user-permission/{employee}', [AccessPermissionController::class, 'createUserPermission'])->name('access_permission.createUserPermission');
