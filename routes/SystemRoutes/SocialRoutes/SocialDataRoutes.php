<?php

use App\Http\Controllers\Social\CompanyController;
use App\Http\Controllers\Social\CustomerController;
use App\Http\Controllers\Social\EmployeeController;
use App\Http\Controllers\Social\ManagementGroupController;
use App\Http\Controllers\Social\ProductController;
use App\Http\Controllers\Social\SocialDataController;
use Illuminate\Support\Facades\Route;

Route::get('dropdown-customer-category', [ManagementGroupController::class, 'dropdownCustomerCategory']);
Route::get('dropdown-customer-company', [CompanyController::class, 'getCustomerCompany']);
Route::get('dropdown-responsible-employee', [EmployeeController::class, 'dropdownResponsibleEmployee']);
Route::post('{social_event}/create-social-data', [SocialDataController::class, 'regisCustomer']);
Route::get('edit/{social_data}', [SocialDataController::class, 'editDetail']);
Route::get('workflow/{social_data}', [SocialDataController::class, 'workflowDetail']);
Route::get('dropdown-product', [ProductController::class, 'getSocialDataProducts']);
Route::get('all-social-data/{customer}', [SocialDataController::class, 'getSocialDataByCustomer']);
Route::put('update-order-customer/{customer}', [CustomerController::class, 'updateOrder']);
Route::put('update-progress/{social_data}', [SocialDataController::class, 'updateDataProgress']);
Route::get('shipping-info/{social_data}', [SocialDataController::class, 'getShippingInfo']);
Route::get('major-transfer/{social_data}', [SocialDataController::class, 'getMajorTransfers']);
