<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // role_id: 1 = Admin, 2 = Kasir
        if (Auth::user()->role_id != $role) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
