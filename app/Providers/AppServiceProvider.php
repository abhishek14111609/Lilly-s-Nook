<?php

namespace App\Providers;

use App\Models\WishlistItem;
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
        View::composer('layouts.app', function ($view): void {
            $user = Auth::user();

            $view->with([
                'cartCount' => $user ? (int) $user->cartItems()->sum('quantity') : 0,
                'wishlistCount' => $user ? (int) WishlistItem::query()->where('user_id', $user->id)->count() : 0,
            ]);
        });
    }
}
