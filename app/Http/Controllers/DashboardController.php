<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Analytics;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Récupérer toutes les données analytiques
        $analyticsData = Analytics::with('user')->latest()->paginate(10);

        // Statistiques générales
        $totalVisits = Analytics::count();
        $activeUsers = User::whereHas('analytics')->count();
        $mostUsedDevice = Analytics::groupBy('DeviceType')
            ->selectRaw('DeviceType, count(*) as total')
            ->orderBy('total', 'desc')
            ->first()
            ->DeviceType ?? 'N/A';

        // Données pour les graphiques
        $pageVisits = Analytics::groupBy('PageVisited')
            ->selectRaw('PageVisited, count(*) as total')
            ->get();
        $pageVisitsLabels = $pageVisits->pluck('PageVisited');
        $pageVisitsData = $pageVisits->pluck('total');

        $userActions = Analytics::groupBy('Action')
            ->selectRaw('Action, count(*) as total')
            ->get();
        $userActionsLabels = $userActions->pluck('Action');
        $userActionsData = $userActions->pluck('total');

        // Passer les données à la vue
        return view('admin.dashboard', compact(
            'totalVisits',
            'activeUsers',
            'mostUsedDevice',
            'pageVisitsLabels',
            'pageVisitsData',
            'userActionsLabels',
            'userActionsData',
            'analyticsData'
        ));
    }
}