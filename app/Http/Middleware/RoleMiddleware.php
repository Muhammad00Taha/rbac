<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RoleMiddleware
 *
 * Simple role gatekeeper for Admin / Manager / User rules.
 */
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user === null) {
            abort(403, 'Unauthorized.');
        }

        // Admin has full access.
        if ($user->hasRole('Admin')) {
            return $next($request);
        }

        $path = ltrim($request->path(), '/');
        $routeName = optional($request->route())->getName() ?? '';

        // Manager: CRUD on users but cannot modify roles or permissions.
        if ($user->hasRole('Manager')) {
            // Disallow any routes that mention roles or permissions.
            if (str_contains($path, 'role') || str_contains($path, 'permission') || str_contains($routeName, 'role') || str_contains($routeName, 'permission')) {
                abort(403, 'Managers may not modify roles or permissions.');
            }

            // Allow managers to access user management routes (paths that start with "users").
            if (str_starts_with($path, 'users') || str_starts_with($routeName, 'users.')) {
                return $next($request);
            }

            // Managers can also access dashboard and their own profile pages.
            if ($path === 'dashboard' || str_starts_with($path, 'profile')) {
                return $next($request);
            }

            abort(403, 'Managers do not have access to this resource.');
        }

        // Regular User: can only view and edit their own profile.
        if ($user->hasRole('User')) {
            if (str_starts_with($path, 'profile') || $path === '' || $path === 'dashboard') {
                return $next($request);
            }

            abort(403, 'Users may only view or edit their own profile.');
        }

        // Default deny.
        abort(403, 'Access denied.');
    }
}
