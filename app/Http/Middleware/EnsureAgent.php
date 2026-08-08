<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAgent
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    { 
        if (!Auth::guard('agent')->check()) {
             return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
