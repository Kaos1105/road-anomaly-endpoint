<?php

use App\Http\Controllers\SNET\ChatContentController;
use Illuminate\Support\Facades\Route;

Route::post('{question}/answer-file/{answer_file}', [ChatContentController::class, 'store']);

