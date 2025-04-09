<?php

use App\Http\Middleware\UpdateInactivityTimestamp;
use App\Http\Middleware\VerifyInactivityToken;
use App\Http\Controllers\SNET\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/system-name', function () {
    return [env('APP_NAME', 'Laravel') => app()->version()];
});

Route::get('/content-login', [LoginController::class, 'getContent']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(__DIR__ . '/SystemRoutes/AuthRoutes.php');

Route::middleware([VerifyInactivityToken::class, 'auth:sanctum', UpdateInactivityTimestamp::class])->group(function () {
    Route::prefix('/setting-default')->group(__DIR__ . '/SystemRoutes/BatchDataRoutes.php');

    //SNET System
    Route::prefix('snet')->group(__DIR__ . '/SystemRoutes/SNETSystemRoutes.php');

    // Common
    Route::prefix('favorite')->group(__DIR__ . '/SystemRoutes/FavoriteRoutes.php');
    Route::prefix('attachment-file')->group(__DIR__ . '/SystemRoutes/AttachmentFileRoutes.php');
    Route::prefix('access-history')->group(__DIR__ . '/SystemRoutes/AccessHistoryRoutes.php');

    Route::prefix('external')->group(__DIR__ . '/SystemRoutes/ExternalServiceRoutes.php');

    // Organization System
    Route::prefix('organization')->group(__DIR__ . '/SystemRoutes/OrganizationSystemRoutes.php');

    // Social System
    Route::prefix('social')->group(__DIR__ . '/SystemRoutes/SocialSystemRoutes.php');

    // Negotiation System
    Route::prefix('negotiation')->group(__DIR__ . '/SystemRoutes/NegotiationSystemRoutes.php');

    // Schedule System
    Route::prefix('schedule')->group(__DIR__ . '/SystemRoutes/ScheduleSystemRoutes.php');

    // Main System
    Route::prefix('main')->group(__DIR__ . '/SystemRoutes/MainSystemRoutes.php');

    // Facility management System
    Route::prefix('facility-management')->group(__DIR__ . '/SystemRoutes/FacilitySystemRoutes.php');

    Route::prefix('layout')->group(__DIR__ . '/SystemRoutes/LayoutRoutes.php');

    // Contract system
    Route::prefix('contract')->group(__DIR__ . '/SystemRoutes/ContractSystemRoutes.php');

});
