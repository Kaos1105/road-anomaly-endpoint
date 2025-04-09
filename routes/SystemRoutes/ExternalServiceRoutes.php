<?php

use App\Http\Controllers\Main\ExternalController;

Route::post('/zipcode', [ExternalController::class, 'getZipCodeInfo']);
Route::post('/hiragana', [ExternalController::class, 'getHiragana']);
