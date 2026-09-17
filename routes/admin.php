<?php

use App\Livewire\Admin\Agent\AList;
use App\Livewire\Admin\Agent\Create as AgentCreate;
use App\Livewire\Admin\Agent\Edit as AgentEdit;
use App\Livewire\Admin\Auth\ForgotPassword as AdminForgotPassword;
use App\Livewire\Admin\Auth\Login as AdminLogin;
use App\Livewire\Admin\Auth\ResetPassword as AdminResetPassword;
use App\Livewire\Admin\Coin\CList;
use App\Livewire\Admin\Coin\CoinForm;
use App\Livewire\Admin\Gift\GiftForm;
use App\Livewire\Admin\Gift\GList as GiftList;
use App\Livewire\Admin\Home as AdminHome;
use App\Livewire\Profile;
use App\Livewire\Admin\Reward\RewardForm;
use App\Livewire\Admin\Reward\RewardList;
use App\Livewire\Admin\Setting\AboutApplicationSetting;
use App\Livewire\Admin\Setting\GeneralSetting;
use App\Livewire\Admin\Setting\PrivacyPolicySetting;
use App\Livewire\Admin\Setting\TermConditionSetting;
use App\Livewire\Admin\Subscription\SubscriptionCreate;
use App\Livewire\Admin\Subscription\SubscriptionEdit;
use App\Livewire\Admin\Subscription\SubscriptionList;
use App\Livewire\Admin\AgentPackage\Create as AgentPackageCreate;
use App\Livewire\Admin\AgentPackage\Edit as AgentPackageEdit;
use App\Livewire\Admin\AgentPackage\PList as AgentPackageList;

use App\Livewire\Admin\SubscriptionCategory\SubscriptionCategory;
use App\Livewire\Admin\Ticket\Chat;
use App\Livewire\Admin\Ticket\TList;
use App\Livewire\Admin\User\Detail as UserDetail;
use App\Livewire\Admin\User\UList as Users;


// admin routes

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
            Route::get('/profile', Profile::class)->name('profile');
            Route::get('/subscription/category', SubscriptionCategory::class)->name('subscription.category');

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

            // reward
            Route::prefix('gift')
                ->name('gift.')
                ->group(function () {
                    Route::get('/list', GiftList::class)->name('list');
                    Route::get('/create', GiftForm::class)->name('create');
                    Route::get('/edit/{id}', GiftForm::class)->name('edit');
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

            //agent packages
            Route::prefix('agent/packages')
                ->name('agent.packages.')
                ->group(function () {
                    Route::get('/list', AgentPackageList::class)->name('list');
                    Route::get('/create', AgentPackageCreate::class)->name('create');
                    Route::get('/edit/{id}', AgentPackageEdit::class)->name('edit');
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
 
