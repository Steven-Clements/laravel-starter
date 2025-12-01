<?php

/**
 * Clementine Solutions
 * —————————————————————————————————————————————————————————————————————————————
 * Clementine Technology Solutions LLC. (dba. Clementine Solutions).
 * @author      Steven "Chris" Clements <clements.steven07@outlook.com>
 * @version     1.0.0
 * @since       1.0.0
 * @copyright   © 2025-2026 Clementine Solutions. All Rights Reserved.
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Login Throttle
 * —————————————————————————————————————————————————————————————————————————————
 * Throttles requests to the `/auth/login` route.
 */
class LoginThrottle
{
    /**
     * Handle an incoming request.
     * @param  \Closure\Illuminate\Http\Request()  $request
     * @param  \Closure $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = Str::lower($request->input('emailOrUsername')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            return back()->withErrors([
                'password' => 'Invalid identifier or password.'
            ]);
        }

        RateLimiter::hit($key, 60);

        return $next($request);
    }
}
