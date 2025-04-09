<?php

use App\Http\Controllers\Main\DeviceInformationController;
use Illuminate\Support\Facades\Route;

Route::get('/using', [DeviceInformationController::class, 'getListInUse']);
Route::patch('{device}/use-classification', [DeviceInformationController::class, 'changeNotUse']);
Route::get('token', [DeviceInformationController::class, 'getToken']);
Route::post('token', [DeviceInformationController::class, 'updateToken']);
