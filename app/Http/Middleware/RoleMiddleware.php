<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class RoleMiddleware
 * 
 * Verifies that the authenticated user has one of the allowed roles
 * before proceeding with the request. Returns a 403 response if unauthorized.
 * 
 * @package App\Http\Middleware
 */
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles  Varargs of allowed roles.
     * @return mixed
     * 
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        
        // Assert that the user is logged in and their role matches the whitelist
        if (!$user || !in_array($user->role, $roles)) {
            abort(403, 'Unauthorized.');
        }
        return $next($request);
    }
}
