<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


/**
 * Redirects authenticated users away from guest-only routes.
 *
 * If a user is already logged in, redirects them to their role-specific
 * home route; otherwise allows the request to continue.
 */
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response $next
     * @param mixed ...$guards Optional auth guards (not used here; kept for compatibility)
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        if (Auth::check()) {
            return match (Auth::user()->role) {
                'admin' => redirect()->route('admin.home'),
                'agent' => redirect()->route('agent.home'),
                'user' => redirect()->route('user.home'),
                default => redirect()->route('index'),
            };
        }

        return $next($request);
    }
}
