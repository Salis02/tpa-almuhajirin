<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SantriController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('santri', SantriController::class);