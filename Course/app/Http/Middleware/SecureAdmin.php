<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = session('admin');
        if ($user) {
            return $next($request);
        }
        else {
            return redirect('/')->with('error', 'Vous n\'avez pas les droits d\'administrateur pour accéder à cette page.');
        }
    }
}
