<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FooditemsController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;


Route::get('/',[HomepageController::class, 'index'])->name('home');
Route::get('about',[HomepageController::class, 'about'])->name('about');
Route::get('contact',[HomepageController::class, 'contact'])->name('contact');
Route::get('menu',[HomepageController::class, 'menu'])->name('menu');

//reservation
Route::post('reservation',[ReservationController::class, 'store'])->name('reservation.store');

// User dashboard route (for authenticated regular users)
Route::middleware('auth')->group(function(){
    Route::get('dashboard', [HomepageController::class, 'dashboard'])->name('user.dashboard');
 
    // Cart routes
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart/store', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'index'])->name('checkout.index');


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

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
