<?php

use App\Http\Controllers\PostbackController;
use Illuminate\Support\Facades\Route;

Route::post('/postback', [PostbackController::class, 'handle'])->name('postback.handle');
