<?php

use App\Http\Controllers\SNET\AnnouncementController;
use Illuminate\Support\Facades\Route;

Route::get('display-system-dropdown', [AnnouncementController::class, 'getDisplaySystemDropdown']);
Route::get('/display-posting', [AnnouncementController::class, 'getDisplayPosting']);
