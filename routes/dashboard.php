<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;

Route::get('/', [DashboardController::class, 'index'])->name('index');

Route::resource('users', UserController::class);
