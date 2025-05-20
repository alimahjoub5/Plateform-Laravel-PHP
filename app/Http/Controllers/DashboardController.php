<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Analytics;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Devis;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Statistiques communes
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

        // Redirection selon le rôle (insensible à la casse)
        if (strtolower($user->Role) === 'admin') {
            // Statistiques pour l'admin
            $totalProjects = Project::count();
            $pendingProjects = Project::where('ApprovalStatus', 'Pending')->count();
            $totalClients = User::where('Role', 'client')->count();
            $totalFreelancers = User::where('Role', 'freelancer')->count();
            $recentProjects = Project::with('client')->latest()->take(5)->get();
            $recentDevis = Devis::with(['client', 'project'])->latest()->take(5)->get();
            
            return view('admin.dashboard', compact(
                'totalProjects',
                'pendingProjects',
                'totalClients',
                'totalFreelancers',
                'recentProjects',
                'recentDevis',
                'totalVisits',
                'activeUsers',
                'mostUsedDevice',
                'pageVisitsLabels',
                'pageVisitsData',
                'userActionsLabels',
                'userActionsData'
            ));
        } 
        elseif (strtolower($user->Role) === 'client') {
            // Statistiques pour le client
            $projects = Project::where('ClientID', $user->UserID)->get();
            $totalProjects = $projects->count();
            $pendingProjects = $projects->where('Status', 'Pending')->count();
            $completedProjects = $projects->where('Status', 'Completed')->count();
            $totalInvoices = Invoice::where('ClientID', $user->UserID)->count();
            $pendingInvoices = Invoice::where('ClientID', $user->UserID)
                                    ->where('Status', 'Pending')
                                    ->count();

            // Récupérer les 5 dernières factures du client
            $recentInvoices = Invoice::where('ClientID', $user->UserID)
                                    ->latest()
                                    ->take(5)
                                    ->get();
            
            return view('client.dashboard', compact(
                'projects',
                'totalProjects',
                'pendingProjects',
                'completedProjects',
                'totalInvoices',
                'pendingInvoices',
                'recentInvoices',
                'totalVisits',
                'activeUsers',
                'mostUsedDevice',
                'pageVisitsLabels',
                'pageVisitsData',
                'userActionsLabels',
                'userActionsData'
            ));
        }
        else {
            // Statistiques pour le freelancer
            $tasks = Task::where('AssignedTo', $user->UserID)->get();
            $totalTasks = $tasks->count();
            $completedTasks = $tasks->where('Status', 'Completed')->count();
            $inProgressTasks = $tasks->where('Status', 'In Progress')->count();
            $projects = Project::whereHas('tasks', function($query) use ($user) {
                $query->where('AssignedTo', $user->UserID);
            })->get();
            $activeProjects = $projects->where('Status', 'In Progress')->count();
            
            return view('freelancer.dashboard', compact(
                'tasks',
                'totalTasks',
                'completedTasks',
                'inProgressTasks',
                'projects',
                'activeProjects',
                'totalVisits',
                'activeUsers',
                'mostUsedDevice',
                'pageVisitsLabels',
                'pageVisitsData',
                'userActionsLabels',
                'userActionsData'
            ));
        }
    }
}