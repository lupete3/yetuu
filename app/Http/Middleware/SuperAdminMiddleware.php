<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est authentifié
        if (Auth::check()) {
            // Vérifie si l'utilisateur est super admin
            if (Auth::user()->role == 'super-admin') {
                return $next($request);
            }

            // Redirige vers une page d'accès refusé ou une page d'erreur personnalisée
            abort(403, 'Access denided : You don\'t have the permission to access for this application.');
        }

        // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
        return redirect('/');
    }

}
