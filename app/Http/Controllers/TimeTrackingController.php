<?php

namespace App\Http\Controllers;

use App\Models\TimeTracking;
use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TimeTrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        
        // Récupérer les tâches assignées à l'utilisateur
        $tasks = Task::where('AssignedTo', $userId)
            ->where('Status', '!=', 'Completed')
            ->get();

        // Récupérer le suivi du temps pour aujourd'hui
        $todayTracking = TimeTracking::where('UserID', $userId)
            ->whereDate('StartTime', Carbon::today())
            ->get();

        // Calculer le temps total pour aujourd'hui
        $totalTimeToday = $todayTracking->sum(function($tracking) {
            return Carbon::parse($tracking->EndTime)->diffInMinutes(Carbon::parse($tracking->StartTime));
        });

        // Récupérer les statistiques de la semaine
        $weekStats = TimeTracking::where('UserID', $userId)
            ->whereBetween('StartTime', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get()
            ->groupBy(function($tracking) {
                return Carbon::parse($tracking->StartTime)->format('Y-m-d');
            })
            ->map(function($dayTracking) {
                return $dayTracking->sum(function($tracking) {
                    return Carbon::parse($tracking->EndTime)->diffInMinutes(Carbon::parse($tracking->StartTime));
                });
            });

        return view('time-tracking.index', compact('tasks', 'todayTracking', 'totalTimeToday', 'weekStats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function start(Request $request)
    {
        $request->validate([
            'TaskID' => 'required|exists:tasks,TaskID',
            'Description' => 'required|string'
        ]);

        // Vérifier si l'utilisateur a déjà une session active
        $activeSession = TimeTracking::where('UserID', Auth::id())
            ->whereNull('EndTime')
            ->first();

        if ($activeSession) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà une session active'
            ]);
        }

        // Créer une nouvelle session
        $tracking = TimeTracking::create([
            'UserID' => Auth::id(),
            'TaskID' => $request->TaskID,
            'Description' => $request->Description,
            'StartTime' => Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Session démarrée avec succès',
            'tracking' => $tracking
        ]);
    }

    public function stop(Request $request)
    {
        $tracking = TimeTracking::where('UserID', Auth::id())
            ->whereNull('EndTime')
            ->first();

        if (!$tracking) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune session active trouvée'
            ]);
        }

        $tracking->update([
            'EndTime' => Carbon::now()
        ]);

        // Mettre à jour le temps réel de la tâche
        $task = Task::find($tracking->TaskID);
        $duration = Carbon::parse($tracking->EndTime)->diffInMinutes(Carbon::parse($tracking->StartTime));
        $task->ActualHours = ($task->ActualHours ?? 0) + ($duration / 60);
        $task->save();

        return response()->json([
            'success' => true,
            'message' => 'Session arrêtée avec succès',
            'duration' => $duration
        ]);
    }

    public function getActiveSession()
    {
        $tracking = TimeTracking::with('task')
            ->where('UserID', Auth::id())
            ->whereNull('EndTime')
            ->first();

        return response()->json([
            'success' => true,
            'tracking' => $tracking
        ]);
    }
}
