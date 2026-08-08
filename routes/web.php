<?php


use App\Livewire\Admin\Auth\ForgotPassword as AdminForgotPassword;
use App\Livewire\Admin\Auth\ResetPassword as AdminResetPassword;
use App\Livewire\Admin\Home as AdminHome;
use App\Livewire\Admin\Profile as AdminProfile;
use App\Livewire\Admin\User\UList as Users;
use App\Livewire\Admin\User\Detail as UserDetail;

use App\Livewire\Admin\Agent\AList;
use App\Livewire\Admin\Agent\Create as AgentCreate;
use App\Livewire\Admin\Agent\Edit as AgentEdit;
use App\Livewire\Admin\Auth\Login as AdminLogin;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    echo Hash::make('admin');
});
Route::redirect('/', '/admin/login');

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::middleware(['checkauth'])->group(function () {
            Route::get('/login', AdminLogin::class)->name('login');
            Route::get('/forget-password', AdminForgotPassword::class)->name('forget-password');
            Route::get('/reset-password/{token}', AdminResetPassword::class)->name('reset-password');
        });
        Route::middleware(['admin', 'redirectifauth'])->group(function () {
            Route::post('/logout', function () {
                Auth::guard('admin')->logout();

                session()->invalidate();
                session()->regenerateToken();

                return redirect()->route('admin.login');
            })->name('logout');

            Route::get('/dashboard', AdminHome::class)->name('dashboard');
            Route::get('/profile', AdminProfile::class)->name('profile');

            // user management routes
            Route::prefix('user')->name('user.')->group(function () {
                Route::get('/', Users::class)->name('list');
                Route::get('/detail/{id}', UserDetail::class)->name('detail');
            });

            // user management routes
            Route::prefix('agent')->name('agent.')->group(function () {
                Route::get('/', AList::class)->name('list');
                Route::get('/create', AgentCreate::class)->name('create');
                Route::get('/edit/{id}', AgentEdit::class)->name('edit');
            });

        });
    });

Route::prefix('agent')
    ->name('agent.')
    ->group(function () {
        Route::middleware(['checkauth'])->group(function () {
            Route::get('/login', AdminLogin::class)->name('login');
            Route::get('/forget-password', AdminForgotPassword::class)->name('forget-password');
            Route::get('/reset-password/{token}', AdminResetPassword::class)->name('reset-password');
        });
        Route::middleware(['agent', 'redirectifauth'])->group(function () {
            Route::get('/dashboard', function () {
                return 'Agent dashboard';
            })->name('dashboard');
        });
    });
