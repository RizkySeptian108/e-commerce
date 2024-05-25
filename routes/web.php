<?php

use App\Models\Access;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KioskController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShipmentMethodController;
use App\Models\Kiosk;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home/{product}', [HomeController::class, 'product'])->name('home-product');


// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Admin
Route::middleware('auth', 'verified', 'isAdmin')->group(function() {
    Route::resource('/category', CategoryController::class);
    Route::resource('/payment-method', PaymentMethodController::class);
    Route::resource('/shipment-method', ShipmentMethodController::class);
    Route::resource('/access', AccessController::class);
    Route::post('/access/account-access/{user:id}', [AccessController::class, 'accountAccess'])->name('account-access');
});

// Buyer
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::middleware('verified')->group(function() {
        // create a kiosk
        Route::resource('/kiosk', KioskController::class)->only('create','store');
        
        // Order route
        Route::resource('/order', OrderController::class)->only('create', 'store');

        // Address
        Route::resource('/address', AddressController::class);
    });

    // create data in cart
    Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/cart-delete/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/cart', [CartController::class, 'shows'])->name('cart.shows');
    Route::get('/carts', [CartController::class, 'index'])->name('cart.index');

    // Orders
    Route::get('/list/order', [OrderController::class, 'list'])->name('order.list');

});

// Kiosk
Route::middleware('auth', 'verified', 'isKiosk')->group(function() {
    Route::resource('/kiosk', KioskController::class)->except('create', 'store');
    Route::resource('/product', ProductController::class);

    Route::resource('/order', OrderController::class)->only('index', 'update');
    Route::get('/kiosk-list/order', [OrderController::class, 'listKiosk'])->name('order.kiosk');

    Route::get('/carts/counts', [CartController::class, 'listCarts'])->name('cart.count');
});

require __DIR__.'/auth.php';
