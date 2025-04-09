<?php

use App\Http\Controllers\Main\LayoutController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LayoutController::class, 'getLayout']);
Route::post('/drag-drop', [LayoutController::class, 'dragDropCard']);
