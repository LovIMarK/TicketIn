<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Role gate middleware.
 *
 * Ensures the authenticated user has the required role; otherwise aborts with 403.
 * Usage in routes/controllers: middleware('role:admin'), middleware('role:agent'), etc.
 */
class CheckUserRole
{

    /**
     * Handle an incoming request and enforce the required role.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response $next
     * @param string $role Required user role (e.g., 'admin', 'agent', 'user')
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException If user is unauthenticated or role mismatch (403).
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user() || $request->user()->role !== $role) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
