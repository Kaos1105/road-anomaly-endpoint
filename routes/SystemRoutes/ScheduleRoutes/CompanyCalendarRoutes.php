<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Schedule\CompanyCalendarController;

Route::get('/date', [CompanyCalendarController::class, 'checkDate']);
