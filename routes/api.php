<?php

use App\Http\Controllers\PostbackController;
use App\Http\Controllers\RedemptionController;
use Illuminate\Support\Facades\Route;

Route::post('/postback', [PostbackController::class, 'handle'])->name('postback.handle');
Route::post('/redemptions', [RedemptionController::class, 'store'])->name('redemptions.store');
