<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminStaffMiddleware
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
            // Vérifie si l'utilisateur n'a pas de site_id et n'est pas super admin
            if (Auth::user()->role !== 'super-admin' || Auth::user()->role !== 'field_staff') {
                Auth::logout(); // Déconnecte l'utilisateur
                abort(403, 'Access denided : Yous don\'t have permission to access for this application.');
                //return redirect('/')->with('error', 'Accès limité : Vous n\'êtes pas autorisé à accéder à cette application.');
            }

            // Autoriser les super-admins ou les utilisateurs 
            if (Auth::user()->role == 'super-admin' || Auth::user()->role == 'field_staff') {
                return $next($request);
            }
        }

        // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
        return redirect('/');
    }
}
