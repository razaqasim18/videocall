<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {

            $settings = cache()->remember('app_settings', 3600, function () {
                return Setting::all()->pluck('value', 'key')->toArray();
            });

            $view->with('settings', $settings);
        });
    }
}
