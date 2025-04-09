<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Facility\FacilityController;

Route::prefix('{group}')->group(function () {
    Route::get('facility', [FacilityController::class, 'index']);
});
