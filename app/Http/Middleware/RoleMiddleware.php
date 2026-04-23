<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // If user doesn't have the required role, redirect to their appropriate dashboard
        if ($user->role !== $role) {
            return match ($user->role) {
                'admin' => redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
                'dokter' => redirect()->route('dokter.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
                'pasien' => redirect()->route('pasien.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
                default => redirect()->route('login'),
            };
        }

        return $next($request);
    }
}
