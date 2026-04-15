<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->role !== 'admin') {
                   auth()->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();
            abort(403, 'Current user does not have admin privileges.');


        }
        return $next($request);
    }
}
