<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\StripeController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/', [ItemController::class, 'index'])->name('index');
Route::get('/item/{item_id}', [ItemController::class, 'detail'])->name('detail');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/item/like/{item_id}', [ItemController::class, 'like']);
    Route::get('/item/unlike/{item_id}', [ItemController::class, 'unlike']);
    Route::post('/item/comment/{item_id}', [ItemController::class, 'comment']);

    Route::get('/purchase/{item_id}', [PurchaseController::class, 'purchase'])->name('purchase');
    Route::post('/payment/{item_id}', [PurchaseController::class, 'payment']);
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editAddress']);
    Route::patch('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress']);
    // Route::post('/complete/{item_id}', [PurchaseController::class, 'complete']);

    Route::get('/sell', [SellController::class, 'sell']);
    Route::post('/sell', [SellController::class, 'exhibit']);

    Route::get('/mypage', [ProfileController::class, 'mypage']);
    Route::get('/mypage/profile', [ProfileController::class, 'editProfile'])->name('profile');
    Route::patch('/mypage/profile', [ProfileController::class, 'updateProfile']);

    Route::post('/checkout/{item_id}', [StripeController::class, 'checkout'])->name('checkout');
});


// Route::get('/success', fn() => view('success'))->name('success');
// Route::get('/cancel', fn() => view('cancel'))->name('cancel');
Route::post('/stripe/webhook', [StripeController::class, 'handle']);
