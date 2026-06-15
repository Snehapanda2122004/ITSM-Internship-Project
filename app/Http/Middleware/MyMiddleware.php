<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MyMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Check if the user is even logged in
        if (!$request->session()->has('role')) {
            return redirect('/login')->with('error', 'Please log in to access this page.');
        }

        $userRole = $request->session()->get('role');

        // 2. Allow access if the user's role matches any of the allowed roles passed to the group
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // 3. Kick back unauthorized attempts
        abort(403, 'Unauthorized access: You do not have the permissions required for this section.');
    }
}
