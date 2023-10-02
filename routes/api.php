<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\Admin\InvoiceApiController;

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Branch
    Route::apiResource('branches', 'BranchApiController');

    // Products
    Route::apiResource('products', 'ProductsApiController');

    // Invoice
    Route::post('invoice/qty/{id}/{pid}',[InvoiceApiController::class,'updateQty']);
    Route::apiResource('invoices', 'InvoiceApiController');

    // Customer
    Route::apiResource('customers', 'CustomerApiController');

    // Categories
    Route::apiResource('categories', 'CategoriesApiController');

    // Customer Assign
    Route::apiResource('customer-assigns', 'CustomerAssignApiController');
    Route::post('customer-assigns/change/action', 'CustomerAssignApiController@changeAction')->name('change.action');
    Route::get('customer-assigns/action/confirmed', 'CustomerAssignApiController@showConfirmed')->name('customer.assign.confirmed');
    Route::get('customer-assigns/action/completed', 'CustomerAssignApiController@showCompleted')->name('customer.assign.completed');
    Route::get('customer-assigns/action/suspend', 'CustomerAssignApiController@showSuspend')->name('customer.assign.suspend');
});

Route::post('register', 'Api\\AuthController@register');
Route::post('login', [AuthController::class,'login']);
