<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\BuyerOrderController;
use App\Http\Controllers\DispatchController;
use App\Http\Controllers\DeliveryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/buyer-list',[BuyerController::class, 'getBuyerList'])->name('buyer.list');
Route::get('/buyer/edit/{id}',[BuyerController::class, 'edit'])->name('buyer.edit');
Route::post('/buyer/update',[BuyerController::class, 'update'])->name('buyer-update');
Route::resource('buyer', BuyerController::class);

Route::get('/partner-list',[PartnerController::class, 'getPartnerList'])->name('partner.list');
Route::post('/partner/update',[PartnerController::class, 'update'])->name('partner-update');
Route::get('/partner/edit/{id}',[PartnerController::class, 'edit'])->name('partner.edit');
Route::resource('partner', PartnerController::class);

Route::resource('order', BuyerOrderController::class);
Route::get('/order-list',[BuyerOrderController::class, 'getOrderList'])->name('order.list');
Route::post('/order/update',[BuyerOrderController::class, 'update'])->name('order-update');
Route::get('/order/edit/{id}',[BuyerOrderController::class, 'edit'])->name('order.edit');

Route::resource('dispatch', DispatchController::class);
Route::get('/dispatch-list',[DispatchController::class, 'getDispatchList'])->name('dispatch.list');
Route::get('/dispatch/edit/{id}',[DispatchController::class, 'edit'])->name('dispatch.edit');
Route::get('/dispatch/details/{id}',[DispatchController::class, 'getDispatchDetail'])->name('dispatch.details');
Route::post('/dispatch/update',[DispatchController::class, 'update'])->name('dispatch-update');

Route::resource('delivery', DeliveryController::class);
Route::get('/delivery-list',[DeliveryController::class, 'getDeliveryList'])->name('delivery.list');
Route::get('/delivery/details/{id}',[DeliveryController::class, 'getDeliveryDetails'])->name('delivery.details');
Route::get('/delivery/edit/{id}',[DeliveryController::class, 'edit'])->name('delivery.edit');
Route::post('/delivery/update',[DeliveryController::class, 'update'])->name('delivery-update');




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
