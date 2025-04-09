<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Organization\TransferController;

Route::get('{transfer}/copy', [TransferController::class, 'copyTransfer']);
Route::put('{transfer}/representative', [TransferController::class, 'setRepresentative']);
