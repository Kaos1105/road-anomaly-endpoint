<?php

use App\Http\Controllers\SNET\ExcelFileController;

Route::prefix('import')->group(function () {
    Route::post('system', [ExcelFileController::class, 'importSystem']);
    Route::post('display', [ExcelFileController::class, 'importDisplay']);
    Route::post('content', [ExcelFileController::class, 'importContent']);
});

Route::prefix('export')->group(function () {
    Route::get('system', [ExcelFileController::class, 'exportSystem']);
    Route::get('display', [ExcelFileController::class, 'exportDisplay']);
    Route::get('content', [ExcelFileController::class, 'exportContent']);
});
