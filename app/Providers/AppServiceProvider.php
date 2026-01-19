<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
    public function boot(): void {
        Inertia::share('auth_user',function () {
    return Auth::check() ? [
        'id' => Auth::id(),
        'name' => Auth::user()->name,
        'email' => Auth::user()->email,
        'role' => Auth::user()->role,
        'created_at' => Auth::user()->created_at,
    ] : false;
});    
// Inertia::share(['auth_user' => function () {
//     return Auth::check() ? [
//         'id' => Auth::id(),
//         'name' => Auth::user()->name,
//         'email' => Auth::user()->email,
//         'role' => Auth::user()->role,
//         'created_at' => Auth::user()->created_at,
//     ] : false;
}

}
