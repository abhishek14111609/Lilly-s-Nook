<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('*', function ($view): void {
            $user = Auth::user();

            $view->with([
                'cartCount' => $user ? (int) $user->cartItems()->sum('quantity') : 0,
                'wishlistCount' => $user ? (int) $user->wishlistItems()->count() : 0,
            ]);
        });
    }
}
