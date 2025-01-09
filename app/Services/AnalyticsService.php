<?php

namespace App\Services;

use App\Models\Analytics;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AnalyticsService
{
    /**
     * Enregistre une nouvelle entrée analytique.
     *
     * @param string $pageVisited
     * @param int $userId
     * @param string $action
     * @param string $deviceType
     * @return Analytics
     */
    public function logAnalytics($pageVisited, $userId, $action, $deviceType)
    {
        try {
            $analytics = Analytics::create([
                'PageVisited' => $pageVisited,
                'UserID' => $userId,
                'Action' => $action,
                'DeviceType' => $deviceType,
            ]);

            return $analytics;
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'enregistrement des données analytiques: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Récupère les données analytiques par ID utilisateur.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAnalyticsByUser($userId)
    {
        return Analytics::where('UserID', $userId)->get();
    }

    /**
     * Récupère les données analytiques par type d'appareil.
     *
     * @param string $deviceType
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAnalyticsByDeviceType($deviceType)
    {
        return Analytics::where('DeviceType', $deviceType)->get();
    }

    /**
     * Récupère les données analytiques avec les informations de l'utilisateur associé.
     *
     * @param int $analyticsId
     * @return Analytics
     */
    public function getAnalyticsWithUser($analyticsId)
    {
        return Analytics::with('user')->findOrFail($analyticsId);
    }

    /**
     * Supprime une entrée analytique par ID.
     *
     * @param int $analyticsId
     * @return bool
     */
    public function deleteAnalytics($analyticsId)
    {
        $analytics = Analytics::findOrFail($analyticsId);
        return $analytics->delete();
    }
}