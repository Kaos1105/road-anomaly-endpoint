<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SNET\AccessPermissionController;
use App\Http\Controllers\SNET\AnnouncementController;
use App\Http\Controllers\SNET\ChatContentController;
use App\Http\Controllers\SNET\ChatThreadController;
use App\Http\Controllers\SNET\ContentController;
use App\Http\Controllers\SNET\DisplayController;
use App\Http\Controllers\SNET\QuestionController;
use App\Http\Controllers\SNET\SystemController;
use Illuminate\Support\Facades\Route;

//61000
Route::prefix('system')->group(__DIR__ . '/SNETRoutes/SystemRoutes.php');
Route::apiResource('system', SystemController::class);

// common permission
Route::prefix('employee')->group(__DIR__ . '/SNETRoutes/EmployeeRoutes.php');

Route::prefix('department')->group(__DIR__ . '/SNETRoutes/DepartmentRoutes.php');
//62000
Route::prefix('access-permission')->group(__DIR__ . '/SNETRoutes/AccessPermissionRoutes.php');
Route::apiResource('access-permission', AccessPermissionController::class);

// Login
Route::apiResource('login', AuthController::class);

// display
Route::prefix('display')->group(__DIR__ . '/SNETRoutes/DisplayRoutes.php');
Route::apiResource('display', DisplayController::class)->except(['index']);

Route::apiResource('content', ContentController::class);

// Access history
Route::prefix('access-history')->group(__DIR__ . '/SNETRoutes/AccessHistoryRoutes.php');

// 65000 FAQs
Route::prefix('question')->group(__DIR__ . '/SNETRoutes/QuestionRoutes.php');
Route::apiResource('question', QuestionController::class);

// 68000 Chat
Route::apiResource('chat-content', ChatContentController::class);

// 66000 Chat Thread
Route::prefix('chat-thread')->group(__DIR__ . '/SNETRoutes/ChatThreadRoutes.php');
Route::apiResource('chat-thread', ChatThreadController::class);

// Dashboard
Route::prefix('dashboard')->group(__DIR__ . '/SNETRoutes/DashboardRoutes.php');

//6B000
Route::prefix('announcement')->group(__DIR__ . '/SNETRoutes/AnnouncementRoutes.php');
Route::apiResource('announcement', AnnouncementController::class);

// Authentication history
Route::prefix('authentication-history')->group(__DIR__ . '/SNETRoutes/AuthenticationHistoryRoutes.php');
