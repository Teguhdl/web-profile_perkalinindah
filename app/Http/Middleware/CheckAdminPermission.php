<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission, $guard = 'admin'): Response
    {
        $user = Auth::guard($guard)->user();

        if (!$user) {
            abort(403, 'Unauthorized action.');
        }

        // Super Admin bypass
        if ($user->role && $user->role->name === 'Super Admin') {
            return $next($request);
        }

        if (!$user->hasPermission($permission)) {
            abort(403, 'Anda tidak memiliki hak akses untuk fitur ini.');
        }

        return $next($request);
    }
}
