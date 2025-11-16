<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureFrontendUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!session()->has('api_token')) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        // Check if user has admin role
        if (session()->get('user_role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}
