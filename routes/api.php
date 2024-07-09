<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('merchant')->middleware('merchant')->group(function () {
        Route::post('products', [MerchantController::class, 'createProduct']);
        Route::put('products/{id}', [MerchantController::class, 'updateProduct']);
        Route::delete('products/{id}', [MerchantController::class, 'deleteProduct']);
        Route::get('customers', [MerchantController::class, 'getCustomers']);
    });

    Route::prefix('customer')->middleware('customer')->group(function () {
        Route::get('products', [CustomerController::class, 'listProducts']);
        Route::post('buy', [CustomerController::class, 'buyProduct']);
    });
});
