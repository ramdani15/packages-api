<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::name('api.v1.')
->namespace('Api\\V1')
->prefix('v1')
->group(function () {
    Route::resource('source-tariffs', 'SourceTariffController');
    Route::resource('payment-types', 'PaymentTypeController');
    Route::resource('states', 'StateController');
    Route::resource('formulas', 'FormulaController');
    Route::resource('organizations', 'OrganizationController');
    Route::resource('locations', 'LocationController');
    Route::resource('packages', 'PackageController');
    Route::resource('transactions', 'TransactionController');
    Route::resource('connotes', 'ConnoteController');
    Route::resource('connote-histories', 'ConnoteHistoryController');
    Route::resource('kolis', 'KoliController');
    Route::resource('customers', 'CustomerController');
    Route::resource('origins', 'OriginController');
    Route::resource('destinations', 'DestinationController');
});
