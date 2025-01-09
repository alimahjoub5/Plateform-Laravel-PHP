<?php

namespace App\Http\Controllers;

use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    protected $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    public function index(Request $request)
    {
        // Récupérer les données analytiques avec des filtres optionnels
        $query = Analytics::query();

        // Filtrer par date de début
        if ($request->has('start_date')) {
            $query->where('created_at', '>=', $request->input('start_date'));
        }

        // Filtrer par date de fin
        if ($request->has('end_date')) {
            $query->where('created_at', '<=', $request->input('end_date'));
        }

        // Récupérer les données paginées
        $analyticsData = $query->with('user')->latest()->paginate(10);

        // Statistiques générales
        $totalVisits = $query->count();
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



    /**
     * Enregistre une nouvelle entrée analytique.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logAnalytics(Request $request)
    {
        $data = $request->validate([
            'page_visited' => 'required|string',
            'user_id' => 'required|integer',
            'action' => 'required|string',
            'device_type' => 'required|string',
        ]);

        $analytics = $this->analyticsService->logAnalytics(
            $data['page_visited'],
            $data['user_id'],
            $data['action'],
            $data['device_type']
        );

        return response()->json($analytics, 201);
    }

    /**
     * Récupère les données analytiques par ID utilisateur.
     *
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAnalyticsByUser($userId)
    {
        $analytics = $this->analyticsService->getAnalyticsByUser($userId);
        return response()->json($analytics);
    }

    /**
     * Récupère les données analytiques par type d'appareil.
     *
     * @param string $deviceType
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAnalyticsByDeviceType($deviceType)
    {
        $analytics = $this->analyticsService->getAnalyticsByDeviceType($deviceType);
        return response()->json($analytics);
    }

    /**
     * Récupère les données analytiques avec les informations de l'utilisateur associé.
     *
     * @param int $analyticsId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAnalyticsWithUser($analyticsId)
    {
        $analytics = $this->analyticsService->getAnalyticsWithUser($analyticsId);
        return response()->json($analytics);
    }

    /**
     * Supprime une entrée analytique par ID.
     *
     * @param int $analyticsId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAnalytics($analyticsId)
    {
        $this->analyticsService->deleteAnalytics($analyticsId);
        return response()->json(null, 204);
    }
}