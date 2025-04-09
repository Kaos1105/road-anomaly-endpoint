<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Contract\IndividualContractController;

Route::prefix('{basic_contract}')->group(function () {
    Route::apiResource('individual-contract', IndividualContractController::class);
});

