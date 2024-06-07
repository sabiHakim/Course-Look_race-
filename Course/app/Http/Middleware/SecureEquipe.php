<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureEquipe
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = session('equipe');
        if ($user) {
            return $next($request);
        }
        else {
            return redirect('profilEquipe')->with('error', 'Vous n\'avez pas les droits d\'user pour accéder à cette page.');
        }
    }
}
