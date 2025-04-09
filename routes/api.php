<?php

use App\Http\Controllers\AnomalyUploadController;
use Illuminate\Support\Facades\Route;

Route::get('/system-name', function () {
    return [env('APP_NAME', 'Laravel') => app()->version()];
});

//Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/anomalies/upload', [AnomalyUploadController::class, 'upload']);
