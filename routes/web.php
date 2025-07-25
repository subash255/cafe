<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FooditemsController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('about',[HomepageController::class, 'about'])->name ('about');
Route::get('contact',[HomepageController::class, 'contact'])->name('contact');
Route::get('menu',[HomepageController::class, 'menu'])->name('menu');

//reservation
Route::post('reservation',[ReservationController::class, 'store'])->name('reservation.store');

// User dashboard route (for authenticated regular users)
Route::middleware('auth')->group(function(){
    Route::get('dashboard', [HomepageController::class, 'dashboard'])->name('user.dashboard');
 
    // Cart routes
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart/store/{id}', [CartController::class, 'store'])->name('cart.store');
    Route::put('cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.remove');
    
    // Checkout and Payment routes
    Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('process-payment', [CartController::class, 'processPayment'])->name('process.payment');
    
    // eSewa payment routes
    Route::get('esewa/success', [CartController::class, 'esewaSuccess'])->name('esewa.success');
    Route::get('esewa/failure', [CartController::class, 'esewaFailure'])->name('esewa.failure');
    
    // Order success route
    Route::get('order/success/{orderId}', [CartController::class, 'orderSuccess'])->name('order.success');
});


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/dashboard',[AdminController::class, 'index'])->name('admin.dashboard'); 

    //category routes
    Route::get('admin/category',[CategoryController::class, 'index'])->name('admin.category.index');
    Route::post('admin/category',[CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('admin/category/{id}/edit',[CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::put('admin/category/{id}',[CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('admin/category/{id}',[CategoryController::class, 'delete'])->name('admin.category.delete');
    Route::post('admin/category/update-toggle/{categoryId}', [CategoryController::class, 'updateToggle']);

    //fooditem routes
    Route::get('admin/fooditem',[FooditemsController::class, 'index'])->name('admin.fooditem.index');
    Route::post('admin/fooditem',[FooditemsController::class, 'store'])->name('admin.fooditem.store');
    Route::get('admin/fooditem/{id}/edit',[FooditemsController::class, 'edit'])->name('admin.fooditem.edit');
    Route::patch('admin/fooditem/{id}',[FooditemsController::class, 'update'])->name('admin.fooditem.update');
    Route::delete('admin/fooditem/{id}',[FooditemsController::class, 'delete'])->name('admin.fooditem.delete');
    Route::post('admin/fooditem/update-toggle/{fooditemId}', [FooditemsController::class, 'updateToggle'])->name('admin.fooditem.updatetoggle');

    //Reservation routes
    Route::get('admin/reservation',[ReservationController::class, 'index'])->name('admin.reservation.index');
    Route::delete('admin/reservation/{id}',[ReservationController::class, 'destroy'])->name('admin.reservation.delete');
    Route::post('admin/reservation/{id}/accept',[ReservationController::class, 'accept'])->name('admin.reservation.accept');
    Route::post('admin/reservation/{id}/reject',[ReservationController::class, 'reject'])->name('admin.reservation.reject');

    //Order routes
    Route::get('admin/order',[OrderController::class, 'index'])->name('admin.order.index');
    Route::get('admin/order/{id}',[OrderController::class, 'show'])->name('admin.order.show');
    Route::post('admin/order/{id}/update-status',[OrderController::class, 'updateStatus'])->name('admin.order.updateStatus');
    Route::post('admin/order/{id}/update-payment-status',[OrderController::class, 'updatePaymentStatus'])->name('admin.order.updatePaymentStatus');
    Route::delete('admin/order/{id}',[OrderController::class, 'destroy'])->name('admin.order.delete');
    Route::get('admin/order/{id}/print',[OrderController::class, 'print'])->name('admin.order.print');
    Route::get('admin/order-stats',[OrderController::class, 'getOrderStats'])->name('admin.order.stats');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
