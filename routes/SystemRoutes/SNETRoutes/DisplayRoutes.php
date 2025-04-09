<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SNET\DisplayController;

Route::get('{display}/questions', [DisplayController::class, 'getAllQuestions']);
Route::get('all-screens', [DisplayController::class, 'getAllScreens']);
Route::get('system/{systemId}/dropdown-displays', [DisplayController::class, 'getDisplaysBySystem']);

