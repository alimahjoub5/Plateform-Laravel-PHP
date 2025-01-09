<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Analytics;
use Illuminate\Support\Facades\Auth;

class TrackAnalytics
{
    public function handle(Request $request, Closure $next)
    {
        // Enregistrer les données analytiques
        if (Auth::check()) {
            Analytics::create([
                'PageVisited' => $request->path(), // La page visitée
                'UserID' => Auth::id(), // L'ID de l'utilisateur connecté
                'Action' => 'view', // L'action par défaut
                'DeviceType' => $request->header('User-Agent'), // Le type d'appareil
            ]);
        } else {
            // Enregistrer les données pour les utilisateurs non connectés
            Analytics::create([
                'PageVisited' => $request->path(),
                'UserID' => null, // Utilisateur anonyme
                'Action' => 'view',
                'DeviceType' => $request->header('User-Agent'),
            ]);
        }

        return $next($request);
    }
}