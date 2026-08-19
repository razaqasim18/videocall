<?php

use App\Livewire\Admin\Agent\AList;
use App\Livewire\Admin\Agent\Create as AgentCreate;
use App\Livewire\Admin\Agent\Edit as AgentEdit;
use App\Livewire\Admin\Auth\ForgotPassword as AdminForgotPassword;
use App\Livewire\Admin\Auth\Login as AdminLogin;
use App\Livewire\Admin\Auth\ResetPassword as AdminResetPassword;
use App\Livewire\Admin\Coin\CList;
use App\Livewire\Admin\Coin\CoinForm;
use App\Livewire\Admin\Home as AdminHome;
use App\Livewire\Admin\Profile as AdminProfile;
use App\Livewire\Admin\Reward\RewardForm;
use App\Livewire\Admin\Reward\RewardList;
use App\Livewire\Admin\Setting\AboutApplicationSetting;
use App\Livewire\Admin\Setting\GeneralSetting;
use App\Livewire\Admin\Setting\PrivacyPolicySetting;
use App\Livewire\Admin\Setting\TermConditionSetting;
use App\Livewire\Admin\Subscription\SubscriptionCreate;
use App\Livewire\Admin\Subscription\SubscriptionEdit;
use App\Livewire\Admin\Subscription\SubscriptionList;
use App\Livewire\Admin\Ticket\Chat;
use App\Livewire\Admin\Ticket\TList;
use App\Livewire\Admin\User\Detail as UserDetail;
use App\Livewire\Admin\User\UList as Users;
use App\Models\Agent;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

            // agent management routes
            Route::prefix('agent')->name('agent.')->group(function () {
                Route::get('/', AList::class)->name('list');
                Route::get('/create', AgentCreate::class)->name('create');
                Route::get('/edit/{id}', AgentEdit::class)->name('edit');
            });

            // Coins
            Route::prefix('coin')->name('coin.')->group(function () {
                Route::get('/', CList::class)->name('list');
                Route::get('/create', CoinForm::class)->name('create');
                Route::get('/edit/{id}', CoinForm::class)->name('edit');
            });

            // reward
            Route::prefix('reward')
                ->name('reward.')
                ->group(function () {
                    Route::get('/list', RewardList::class)->name('list');
                    Route::get('/create', RewardForm::class)->name('create');
                    Route::get('/edit/{id}', RewardForm::class)->name('edit');
                });

            // ticket
            Route::prefix('ticket')
                ->name('ticket.')
                ->group(function () {
                    Route::get('/list', TList::class)->name('list');
                    Route::get('/reply/{id}', Chat::class)->name('reply');
                });

            // subscriptions
            Route::prefix('subscriptions')
                ->name('subscriptions.')
                ->group(function () {
                    Route::get('/list', SubscriptionList::class)->name('list');
                    Route::get('/create', SubscriptionCreate::class)->name('create');
                    Route::get('/edit/{id}', SubscriptionEdit::class)->name('edit');
                });

            // settings
            Route::prefix('setting')
                ->name('setting.')
                ->group(function () {
                    Route::get('/general', GeneralSetting::class)->name('general');
                    Route::get('/privacy-policy', PrivacyPolicySetting::class)->name('privacy-policy');
                    Route::get('/term-condition', TermConditionSetting::class)->name('term-condition');
                    Route::get('/about-application', AboutApplicationSetting::class)->name('about-application');
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
