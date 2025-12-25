<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/privacy', 'privacy');
Route::view('/terms', 'terms');
Route::view('/contact', 'contact');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    return back()
        ->withErrors(['email' => 'The provided credentials do not match our records.'])
        ->onlyInput('email');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'confirmed', Password::defaults()],
    ]);

    $name = Str::of($validated['email'])
        ->before('@')
        ->replace(['.', '_', '-'], ' ')
        ->title()
        ->limit(50, '');

    $user = User::create([
        'name' => $name->toString(),
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    Auth::login($user);
    $request->session()->regenerate();

    return redirect('/dashboard');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    })->name('logout');

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
