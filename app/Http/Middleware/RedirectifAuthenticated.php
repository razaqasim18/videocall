<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
      
        // Admin
        if (Auth::guard('admin')->check()) {

            if ($request->routeIs('admin.*')) {
                return $next($request);
            }

            return redirect()->route('admin.dashboard');
        }

        // Agent
        if (Auth::guard('agent')->check()) {

            if ($request->routeIs('agent.*')) {
                return $next($request);
            }

            return redirect()->route('agent.dashboard');
        }

        return $next($request);
    }
}