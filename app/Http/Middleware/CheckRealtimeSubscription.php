<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRealtimeSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only check for pasien role accessing dashboard
        if (!$request->expectsJson() && $request->user()?->role === 'pasien') {
            // Store flag in session for JS to set
            session(['realtime_check_required' => true]);
        }

        return $next($request);
    }
}
