<?php

use App\Http\Middleware\Authentication;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureAgent;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',

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
            'admin' => EnsureAdmin::class,
            'agent' => EnsureAgent::class,
            'redirectifauth' => RedirectIfAuthenticated::class,
            'checkauth' => Authentication::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (
            AuthenticationException $e,
            Request $request
        ) {

            if ($request->is('api/*')) {

                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], Response::HTTP_UNAUTHORIZED);
            }

        });

    })

    ->create();
