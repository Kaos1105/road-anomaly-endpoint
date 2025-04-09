<?php

use App\Http\Controllers\Social\CustomerController;
use App\Http\Controllers\Social\EventClassificationController;
use App\Http\Controllers\Social\ManagementGroupController;
use App\Http\Controllers\Social\SocialDataController;
use App\Http\Controllers\Social\SocialEventController;
use App\Http\Controllers\Social\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('dropdown-management-group', [ManagementGroupController::class, 'dropdownManagementGroup']);
Route::get('dropdown-event-classification', [EventClassificationController::class, 'dropdownEventClassification']);
Route::get('{social_event}/social-data-event', [SocialEventController::class, 'showSocialDataEventDetail']);
Route::get('{social_event}/registrable-customer', [CustomerController::class, 'getUnRegisCustomers']);
Route::get('{social_event}/dropdown-supplier', [SupplierController::class, 'getSocialEventSuppliers']);
Route::get('{social_event}/dropdown-order-date', [SocialDataController::class, 'getOrderedDate']);
Route::get('{social_event}/social-event-supplier', [SocialEventController::class, 'showSocialEventWithSupplier']);
Route::get('{social_event}/social-data-list', [SocialEventController::class, 'getSocialDataByEvent']);
