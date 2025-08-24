<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckUserRole;
use App\Http\Middleware\RedirectIfAuthenticated;

/**
 * Application bootstrap.
 *
 * Configures routing, middleware aliases, and exception handling, then returns
 * the fully initialized Application instance.
 */
return Application::configure(basePath: dirname(__DIR__))
    // Register route files and a simple health-check endpoint.
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    // Register framework-level middleware aliases used in routes/controllers.
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => CheckUserRole::class,
            'guest' => RedirectIfAuthenticated::class,
        ]);
    })
    // Global exception handling hooks.
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
