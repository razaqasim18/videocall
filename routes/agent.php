<?php

use App\Livewire\Agent\Auth\ForgotPassword as AgentForgotPassword;
use App\Livewire\Agent\Auth\Login as AgentLogin;
use App\Livewire\Agent\Auth\ResetPassword as AgentResetPassword;
use App\Livewire\Agent\Home as AgentHome;
use App\Livewire\Agent\Package\PList as PackageList;
use App\Livewire\Agent\Package\Purchase as PackagePurchase;
use App\Livewire\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Agent Routes
|--------------------------------------------------------------------------
*/

// Guest Agent Routes
Route::middleware(['checkauth'])->group(function () {

    Route::get('/login', AgentLogin::class)
        ->name('login');

    Route::get('/forget-password', AgentForgotPassword::class)
        ->name('forget-password');

    Route::get('/reset-password/{token}', AgentResetPassword::class)
        ->name('reset-password');

});

// Authenticated Agent Routes
Route::middleware(['agent', 'redirectifauth'])->group(function () {

    Route::post('/logout', function () {

        Auth::guard('agent')->logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('agent.login');

    })->name('logout');

    Route::get('/dashboard', AgentHome::class)
        ->name('dashboard');

    Route::get('/profile', Profile::class)
        ->name('profile');

    Route::prefix('packages')
        ->name('packages.')
        ->group(function () {
            Route::get('/purchase/{id?}', PackagePurchase::class)
                ->name('purchase');
            Route::get('/report', PackageList::class)
                ->name('report');
        });

});
