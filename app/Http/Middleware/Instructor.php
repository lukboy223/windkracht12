<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Instructor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        // Check if the user has an active Instructor role
        if (
            !$user ||
            !$user->roles()->where('name', 'Instructor')->where('isactive', true)->exists()
        ) {
            return redirect('/')->with('error', 'You do not have access to this page.');
        }
        return $next($request);
    }
}
