<?php


// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class AdminMiddleware
// {
//     public function handle(Request $request, Closure $next)
//     {
//         if (Auth::check() && Auth::user()->isAdmin()) {
//             return $next($request);
//         }

//         return redirect('/')->with('error', 'You do not have admin access.');
//     }
// }

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect('/'); // Redirect to home or another page if not an admin
        }

        return $next($request);
    }
}