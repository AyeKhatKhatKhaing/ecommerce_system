<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\LivePhotoController;
use App\Http\Controllers\Other\ApplicationController;
use App\Http\Controllers\Backend\BankAccountController;
use App\Http\Controllers\Backend\DeliveryFeeController;
use App\Http\Controllers\Backend\DeliveryRegionController;

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/user_login', [AuthController::class, 'login'])->name('user_login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [AuthController::class, 'domain']);

Route::middleware('auth')->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('/profile', [DashboardController::class, 'editProfile'])->name('profile');
  Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');

  //Products
  Route::get('/products', [ProductController::class, 'listing'])->name('product');
  Route::get('/products/datatable/ssd', [ProductController::class, 'serverSide']);
  Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
  Route::post('/products', [ProductController::class, 'store'])->name('product.store');
  Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
  Route::put('/products/{id}/update', [ProductController::class, 'update'])->name('product.update');
  Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
  Route::get('product-images/{id}', [ProductController::class, 'images']); // get images from edit

  // Categories
  Route::get('/categories', [CategoryController::class, 'index'])->name('category');
  Route::get('/categories/datatable/ssd', [CategoryController::class, 'serverSide']);
  Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
  Route::post('/categories', [CategoryController::class, 'store'])->name('category.store');
  Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
  Route::put('/categories/{id}/update', [CategoryController::class, 'update'])->name('category.update');
  Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

  // Brands
  Route::get('/brands', [BrandController::class, 'index'])->name('brand');
  Route::get('/brands/datatable/ssd', [BrandController::class, 'serverSide']);
  Route::get('/brands/create', [BrandController::class, 'create'])->name('brand.create');
  Route::post('/brands', [BrandController::class, 'store'])->name('brand.store');
  Route::get('/brands/{id}/edit', [BrandController::class, 'edit'])->name('brand.edit');
  Route::put('/brands/{id}/update', [BrandController::class, 'update'])->name('brand.update');
  Route::delete('/brands/{id}', [BrandController::class, 'destroy'])->name('brand.destroy');

  // Bank Account
  Route::get('/accounts', [BankAccountController::class, 'index'])->name('account');
  Route::get('/accounts/datatable/ssd', [BankAccountController::class, 'serverSide']);
  Route::get('/accounts/create', [BankAccountController::class, 'create'])->name('account.create');
  Route::post('/accounts', [BankAccountController::class, 'store'])->name('account.store');
  Route::get('/accounts/{id}/edit', [BankAccountController::class, 'edit'])->name('account.edit');
  Route::put('/accounts/{id}/update', [BankAccountController::class, 'update'])->name('account.update');
  Route::delete('/accounts/{id}', [BankAccountController::class, 'destroy'])->name('account.destroy');

  Route::get('/delivery_regions', [DeliveryRegionController::class, 'index'])->name('region');
  Route::get('/delivery_regions/datatable/ssd', [DeliveryRegionController::class, 'serverSide']);
  Route::get('/delivery_regions/create', [DeliveryRegionController::class, 'create'])->name('region.create');
  Route::post('/delivery_regions', [DeliveryRegionController::class, 'store'])->name('region.store');
  Route::get('/delivery_regions/{id}/edit', [DeliveryRegionController::class, 'edit'])->name('region.edit');
  Route::put('/delivery_regions/{id}/update', [DeliveryRegionController::class, 'update'])->name('region.update');
  Route::delete('/delivery_regions/{id}', [DeliveryRegionController::class, 'destroy'])->name('region.destroy');

  // Delivery Address
  Route::get('/delivery_fees', [DeliveryFeeController::class, 'index'])->name('fee');
  Route::get('/delivery_fees/datatable/ssd', [DeliveryFeeController::class, 'serverSide']);
  Route::get('/delivery_fees/create', [DeliveryFeeController::class, 'create'])->name('fee.create');
  Route::post('/delivery_fees', [DeliveryFeeController::class, 'store'])->name('fee.store');
  Route::get('/delivery_fees/{id}/edit', [DeliveryFeeController::class, 'edit'])->name('fee.edit');
  Route::put('/delivery_fees/{id}/update', [DeliveryFeeController::class, 'update'])->name('fee.update');
  Route::delete('/delivery_fees/{id}', [DeliveryFeeController::class, 'destroy'])->name('fee.destroy');

  // Customers
  Route::get('/customers', [CustomerController::class, 'index'])->name('customer');
  Route::get('/customers/datatable/ssd', [CustomerController::class, 'serverSide']);
  Route::get('/customers/{id}/products', [CustomerController::class, 'getCustomerProducts'])->name('customer.view');
  Route::get('/customers/{id}/datatable/ssd', [CustomerController::class, 'customerProductServerSide']);

  //New Orders
  Route::get('/all-orders', [OrderController::class, 'allOrders'])->name('all.order');
  Route::get('/all-orders/datatable/ssd', [OrderController::class, 'allOrderServerSide']);

  Route::get('/orders', [OrderController::class, 'index'])->name('order');
  Route::get('/orders/datatable/ssd', [OrderController::class, 'serverSide']);

  Route::get('/orders/{id}', [OrderController::class, 'detail'])->name('order.detail');

  Route::get('/orders/{id}/processing', [OrderController::class, 'processingOrder'])->name('processing.order');
  Route::get('/orders/{id}/reject', [OrderController::class, 'rejectOrder'])->name('reject.order');
  Route::get('/orders/{id}/confirm', [OrderController::class, 'confirmOrder'])->name('confirm.order');
  Route::get('/orders/{id}/finished', [OrderController::class, 'finishedOrder'])->name('finished.order');

  // Cancel Orders
  Route::get('/cancel_orders', [OrderController::class, 'cancelOrders'])->name('cancel_order');
  Route::get('/cancel_orders/datatable/ssd', [OrderController::class, 'cancelOrderServerSide']);

  Route::get('/confirm_orders', [OrderController::class, 'confirmOrders'])->name('confirm_order');
  Route::get('/confirm_orders/datatable/ssd', [OrderController::class, 'confirmOrderServerSide']);

  Route::get('/finished_orders', [OrderController::class, 'finishedOrders'])->name('finished_order');
  Route::get('/finished_orders/datatable/ssd', [OrderController::class, 'finishedOrderServerSide']);

  Route::get('/live_photo', [LivePhotoController::class, 'index'])->name('live');
  Route::get('/live_photo/datatable/ssd', [LivePhotoController::class, 'serverSide']);
  Route::get('/live_photo/create', [LivePhotoController::class, 'create'])->name('live.create');
  Route::post('/live_photo', [LivePhotoController::class, 'store'])->name('live.store');
  Route::get('/live_photo/{id}/edit', [LivePhotoController::class, 'edit'])->name('live.edit');
  Route::put('/live_photo/{id}/update', [LivePhotoController::class, 'update'])->name('live.update');
  Route::delete('/live_photo/{id}', [LivePhotoController::class, 'destroy'])->name('live.destroy');
});

Route::get('image/{filename}', [ApplicationController::class, 'image'])->where('filename', '.*');
