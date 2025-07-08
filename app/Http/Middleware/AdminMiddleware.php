<?php
namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
// Import the User model

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if a user is logged in using session or a custom mechanism
        if (! session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        $user = User::find(session('user_id'));

        if (! $user || $user->role !== 'admin') {
            return redirect()->route('home')->with('error', 'You do not have admin access.');
        }

        return $next($request);
    }
}
