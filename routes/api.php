<?php

use App\Http\Controllers\PostbackController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\RedemptionController;
use App\Http\Controllers\RewardController;
use Illuminate\Support\Facades\Route;

Route::get('/me', [MeController::class, 'show'])->name('me.show');
Route::post('/postback', [PostbackController::class, 'handle'])->name('postback.handle');
Route::post('/redemptions', [RedemptionController::class, 'store'])->name('redemptions.store');
Route::get('/rewards', [RewardController::class, 'index'])->name('rewards.index');
