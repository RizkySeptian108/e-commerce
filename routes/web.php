<?php

use App\Models\Access;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ShipmentMethodController;

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
Route::get('/', function () {
    return view('welcome');
});

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

// Profile management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
