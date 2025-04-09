<?php

use App\Http\Controllers\SNET\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/system-name', function () {
    return [env('APP_NAME', 'Laravel') => app()->version()];
});

Route::get('/content-login', [LoginController::class, 'getContent']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(__DIR__ . '/SystemRoutes/AuthRoutes.php');

Route::middleware([])->group(function () {

});
