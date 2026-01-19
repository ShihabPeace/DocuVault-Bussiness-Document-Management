<?php

use App\Http\Controllers\WidgetController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
Route::middleware(['auth', 'verified'])->group(function () 
{
Route::get('/dashboard', [WidgetController::class, 'dashboardIndex'])->name('dashboard');

Route::post('/checked', [WidgetController::class, 'checked'])->name('checked');

Route::post('/remove', [WidgetController::class, 'remove'])->name('remove');

Route::post('/approve', [WidgetController::class, 'approve'])->name('approve');

Route::post('/cancel', [WidgetController::class, 'cancel'])->name('cancel');

Route::get('/test/{id}', [WidgetController::class, 'test'])->name('test');
});

Route::get('/', function(){
    return Inertia::render('LandingPage');
})->name('landing-page');

Route::get('/login', function(){
    return Inertia::render('login');
})->name('login');

Route::get('/signup', function(){
    return Inertia::render('signup');
})->name('signup');

Route::post('/auth_login', [WidgetController::class, 'auth_login'])->name('auth_login');

Route::post('/auth_register', [WidgetController::class, 'auth_register'])->name('auth_register');