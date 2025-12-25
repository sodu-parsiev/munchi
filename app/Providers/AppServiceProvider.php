<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_ENV') != 'local') {
            URL::forceScheme('https');
        }

        if (! app()->environment(['local', 'staging', 'development'])) {
            return;
        }

        Event::listen(Registered::class, function (Registered $event): void {
            $user = $event->user;

            if (! $user instanceof User) {
                return;
            }

            User::query()
                ->whereKey($user->getKey())
                ->update([
                    'points_balance' => DB::raw('coalesce(points_balance, 0) + 500'),
                ]);
        });

        Event::listen(Login::class, function (Login $event): void {
            $user = $event->user;

            if (! $user instanceof User) {
                return;
            }

            if ($user->points_balance !== null && $user->points_balance > 0) {
                return;
            }

            User::query()
                ->whereKey($user->getKey())
                ->where(function ($query) {
                    $query->whereNull('points_balance')
                        ->orWhere('points_balance', 0);
                })
                ->update([
                    'points_balance' => DB::raw('coalesce(points_balance, 0) + 100'),
                ]);
        });
    }
}
