<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/{id}', [ProductController::class, 'show'])->name('show');
});

Route::group(['prefix' => 'pages', 'as' => 'pages.'], function () {
    Route::get('/about-us', [PageController::class, 'about'])->name('about');
    Route::get('/contact-us', [PageController::class, 'contact'])->name('contact');
    Route::post('/contact-us', [PageController::class, 'storeContact'])->name('contact.store');
    Route::post('/subscribe', [PageController::class, 'subscribe'])->name('subscribe');
    Route::get('/cart', [PageController::class, 'cart'])->name('cart');
    Route::get('/terms', [PageController::class, 'terms'])->name('terms');
    Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
});

Route::group(['prefix' => 'checkout', 'as' => 'checkout.'], function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/success', [CheckoutController::class, 'success'])->name('success');
    Route::get('/cancel', [CheckoutController::class, 'cancel'])->name('cancel');
    Route::get('/confirmation/{orderNumber}', [CheckoutController::class, 'confirmation'])->name('confirmation');
});

