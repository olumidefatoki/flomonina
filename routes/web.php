<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AggregatorController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\TradeController;
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
Route::get('/aggregator-list', [AggregatorController::class, 'getAggregatorList'])->name('aggregator.list');
Route::get('/aggregator/edit/{id}', [AggregatorController::class, 'edit'])->name('aggregator.edit');
Route::post('/aggregator/update', [AggregatorController::class, 'update'])->name('aggregator-update');
Route::resource('aggregator', AggregatorController::class);

Route::get('/partner-list', [PartnerController::class, 'getPartnerList'])->name('partner.list');
Route::post('/partner/update', [PartnerController::class, 'update'])->name('partner-update');
Route::get('/partner/edit/{id}', [PartnerController::class, 'edit'])->name('partner.edit');
Route::resource('partner', PartnerController::class);

Route::resource('trade', TradeController::class);
Route::get('/trade-list', [TradeController::class, 'getTradeList'])->name('trade.list');
Route::post('/trade/update', [TradeController::class, 'update'])->name('trade-update');
Route::get('/trade/edit/{id}', [TradeController::class, 'edit'])->name('trade.edit');

Route::resource('dispatch', DispatchController::class);
Route::get('/dispatch-list', [DispatchController::class, 'getDispatchList'])->name('dispatch.list');
Route::get('/dispatch/edit/{id}', [DispatchController::class, 'edit'])->name('dispatch.edit');
Route::get('/dispatch/details/{id}', [DispatchController::class, 'getDispatchDetail'])->name('dispatch.details');
Route::post('/dispatch/update', [DispatchController::class, 'update'])->name('dispatch-update');

Route::resource('delivery', DeliveryController::class);
Route::get('/delivery-list', [DeliveryController::class, 'getDeliveryList'])->name('delivery.list');
Route::get('/delivery/details/{id}', [DeliveryController::class, 'getDeliveryDetails'])->name('delivery.details');
Route::get('/delivery/edit/{id}', [DeliveryController::class, 'edit'])->name('delivery.edit');
Route::post('/delivery/update', [DeliveryController::class, 'update'])->name('delivery-update');




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
