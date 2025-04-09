<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Contract\BasicContractController;
use App\Http\Controllers\Contract\ContractConditionController;
use App\Http\Controllers\Contract\ContractWorkplaceController;
use App\Http\Controllers\Contract\IndividualContractController;

Route::prefix('{basic_contract}')->group(function () {
    Route::apiResource('condition', ContractConditionController::class)->except('show');
    Route::apiResource('individual', IndividualContractController::class);
    Route::apiResource('workplace', ContractWorkplaceController::class)->except('show');
    Route::patch('approval_flag', [BasicContractController::class, 'updateApprovalFlg']);
    Route::get('download-pdf', [BasicContractController::class, 'downloadPDF']);
});

Route::get('download', [BasicContractController::class, 'downloadExcel']);
Route::post('upload', [BasicContractController::class, 'uploadExcel']);
Route::post('batch-registration', [BasicContractController::class, 'batchRegistration']);
