<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RestaurantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/user/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::get('/restaurants', [RestaurantController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/restaurant/register', [RestaurantController::class, 'register']);
    Route::post('/driver/register', [DriverController::class, 'register']);

    Route::put('/user/update-latlong', [AuthController::class, 'updateLatLong']);


    Route::apiResource('/products', ProductController::class);

    Route::post('/order', [OrderController::class, 'createOrder']);

    Route::get('/order/user', [OrderController::class, 'orderHistory']);

    Route::get('/order/restaurant', [OrderController::class, 'getOrdersByStatus']);

    Route::get('/order/driver', [OrderController::class, 'getOrdersByStatusDriver']);

    Route::put('/order/restaurant/update-status/{id}', [OrderController::class, 'updateOrderStatus']);

    Route::put('/order/driver/update-status/{id}', [OrderController::class, 'updateOrderStatusDriver']);

    Route::put('/order/user/update-status/{id}', [OrderController::class, 'updatePurchaseStatus']);
});
