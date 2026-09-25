<?php

use App\Livewire\MessagePage;
use App\Livewire\ResetPassword as UserResetPassword;
use App\Models\Agent;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    // 1. Create Ticket for a User
    $userTicket = Ticket::create([
        'ticket_no' => (string) Str::uuid(), // Standard Laravel UUID
        'senderable_type' => User::class,
        'senderable_id' => 2,
        'subject' => 'User Payment Issue',
        'message' => 'I was charged twice for my subscription.',
        'priority' => 'high',
        'status' => 'open',
    ]);

    // 2. Create Ticket for an Agent
    $agentTicket = Ticket::create([
        'ticket_no' => (string) Str::uuid(),
        'senderable_type' => Agent::class,
        'senderable_id' => 1,
        'subject' => 'Agent Dashboard Error',
        'message' => 'I cannot see my commission report.',
        'priority' => 'medium',
        'status' => 'open',
    ]);

    // 3. ALWAYS return a response
    return response()->json([
        'message' => 'Test tickets created successfully!',
        'user_ticket' => $userTicket->ticket_no,
        'agent_ticket' => $agentTicket->ticket_no,
    ]);
});

Route::redirect('/', '/admin/login');
Route::get('/password/reset', UserResetPassword::class)->name('password.reset');
Route::get('success/{status}/{message}', MessagePage::class)->name('success.page');
Route::get('/reset-password/{token}', UserResetPassword::class)
    ->name('reset-password');
 
Route::get('/success/{status}/{message}', MessagePage::class)
    ->name('success.message');
    
Route::get('/queue', function () {
    Artisan::call('queue:work', [
        '--stop-when-empty' => true,
    ]);

    Log::info('Queue worker executed');

    return 'Queue worker executed';
});
