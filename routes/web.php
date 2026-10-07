<?php

use App\Livewire\MessagePage;
use App\Livewire\ResetPassword as UserResetPassword;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/login');
Route::get('/reset-password/{token}', UserResetPassword::class)->name('reset-password');
Route::get('/success/{status}/{message}', MessagePage::class)
    ->name('success.message');

Route::get('/queue', function () {
    Artisan::call('queue:work', [
        '--stop-when-empty' => true,
    ]);

    Log::info('Queue worker executed');

    return 'Queue worker executed';
});

Route::get('/test', function () {
    dd(Hash::make('user'));
});
