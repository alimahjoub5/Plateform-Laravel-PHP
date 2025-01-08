<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Notification;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
{
    $this->middleware(function ($request, $next) {
        if (auth()->check()) {
            try {
                // Récupérer les notifications non lues de l'utilisateur connecté
                $unreadNotifications = Notification::where('UserID', auth()->id())
                    ->where('IsRead', false)
                    ->orderBy('created_at', 'desc')
                    ->get();

                // Compter les notifications non lues
                $unreadNotificationsCount = $unreadNotifications->count();

                // Partager les variables avec toutes les vues
                view()->share('unreadNotifications', $unreadNotifications);
                view()->share('unreadNotificationsCount', $unreadNotificationsCount);
            } catch (\Exception $e) {
                // En cas d'erreur, partager des valeurs par défaut ou vides
                view()->share('unreadNotifications', collect()); // Une collection vide
                view()->share('unreadNotificationsCount', 0); // Un compteur à 0
                
                // Optionnel : logger l'erreur pour le débogage
                \Log::error('Erreur lors de la récupération des notifications : ' . $e->getMessage());
            }
        } else {
            // Si l'utilisateur n'est pas connecté, partager des valeurs par défaut
            view()->share('unreadNotifications', collect()); // Une collection vide
            view()->share('unreadNotificationsCount', 0); // Un compteur à 0
        }

        return $next($request);
    });
}
}