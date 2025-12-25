<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/privacy', 'privacy');
Route::view('/terms', 'terms');
Route::view('/contact', 'contact');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/earn-points', function (Request $request) {
        if (! app()->environment(['local', 'staging', 'development'])) {
            abort(404);
        }

        $user = $request->user();

        $user->newQuery()
            ->whereKey($user->getKey())
            ->update([
                'points_balance' => DB::raw('coalesce(points_balance, 0) + 10'),
            ]);

        return redirect('/dashboard')->with('status', 'Added 10 test points.');
    })->name('earn-points');
});
