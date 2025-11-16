<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = strtolower(Auth::user()->role);
        $requiredRole = strtolower($role);

        if ($userRole !== $requiredRole) {
            if ($userRole === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($userRole === 'user') {
                return redirect()->route('user.dashboard');
            } else {
                abort(403, 'Akses ditolak.');
            }
        }

        return $next($request);
    }
}