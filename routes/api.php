<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\BrandController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CheckoutController;
use App\Http\Controllers\Api\V1\LivePhotoController;
use App\Http\Controllers\Api\V1\BankAccountController;
use App\Http\Controllers\Api\V1\DeliveryFeeController;
use App\Http\Controllers\Api\V1\NotificationController;

Route::prefix('auth')->group(function () {
  Route::post('/login', [AuthController::class, 'loginWithPhone']);
  Route::post('/register', [AuthController::class, 'registerWithPhone']);
});

//Products
Route::get('/products', [ProductController::class, 'listing']);
Route::get('/products/{id}', [ProductController::class, 'detail']);
Route::get('/new_products', [ProductController::class, 'newProductListing']);

//Brand
Route::get('/brands', [BrandController::class, 'listing']);

// live photo
Route::get('/live_photos', [LivePhotoController::class, 'listing']);

//Category
Route::get('/categories', [CategoryController::class, 'listing']);

Route::middleware('auth:api')->group(function () {
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::get('/user', [AuthController::class, 'user']);

  //Bank Account
  Route::get('/bank_accounts', [BankAccountController::class, 'listing']);

  //Delivery Fees
  Route::get('/delivery_regions', [DeliveryFeeController::class, 'regionListing']);
  Route::get('/delivery_fees/{regionId}', [DeliveryFeeController::class, 'listing']);

  //carts
  Route::get('/carts', [CartController::class, 'listing']);
  Route::get('/carts_count', [CartController::class, 'getCartsCount']);
  Route::post('/carts', [CartController::class, 'create']);
  Route::put('/carts/{id}', [CartController::class, 'update']);
  Route::delete('/carts/{id}', [CartController::class, 'destroy']);
  Route::delete('/cart_clear', [CartController::class, 'cartClear']);

  Route::get('/checkout', [CheckoutController::class, 'getCheckout']);
  Route::post('/checkout', [CheckoutController::class, 'checkout']);

  Route::get('/orders', [OrderController::class, 'listing']);
  Route::get('/orders/{id}', [OrderController::class, 'detail']);

  Route::get('/notifications', [NotificationController::class, 'listing']);
  Route::get('/noti_count', [NotificationController::class, 'getNotiCount']);
});
