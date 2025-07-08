<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user_id exists in the session
        if (! session()->has('user_id')) {
            // If not, redirect to the login page with an error message
            return redirect('/login')->with('error', 'Please log in to access this page.');
        }

        // If user_id exists, allow the request to proceed
        return $next($request);
    }
}
