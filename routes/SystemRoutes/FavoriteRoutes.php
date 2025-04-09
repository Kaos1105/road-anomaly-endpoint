<?php

use App\Http\Controllers\Main\FavoriteController;
use Illuminate\Support\Facades\Route;

Route::post('/', [FavoriteController::class, 'store'])->name('favorite.store');
