<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; // Added this for custom routing

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        // Correct way to add custom route files in Laravel 11
        then: function () {
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->prefix('agent')
                ->name('agent.')
                ->group(base_path('routes/agent.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            // Added leading backslashes to properly reference the App namespace
            'admin' => \App\Http\Middleware\EnsureAdmin::class,
            'agent' => \App\Http\Middleware\EnsureAgent::class,
            'redirectifauth' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'checkauth' => \App\Http\Middleware\Authentication::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
