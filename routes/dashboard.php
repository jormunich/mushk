<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\EmailSubscriberController;
use App\Http\Controllers\Dashboard\ContactController;

Route::get('/', [DashboardController::class, 'index'])->name('index');

Route::resource('users', UserController::class);
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('subscribers', EmailSubscriberController::class)->only(['index', 'destroy']);
Route::resource('contacts', ContactController::class)->only(['index', 'show', 'destroy']);

Route::post('/upload', [DashboardController::class, 'upload'])->name('upload');
