<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectTimelineController extends Controller
{
    public function show($projectId)
    {
        try {
            $project = Project::with(['client', 'tasks', 'devis', 'invoices'])
                ->where('ClientID', auth()->id())
                ->findOrFail($projectId);

            $timeline = $this->generateTimeline($project);
            
            return view('projects.timeline', compact('project', 'timeline'));
        } catch (\Exception $e) {
            return view('projects.no-project');
        }
    }

    private function generateTimeline($project)
    {
        $timeline = [];

        // Date de création du projet
        $timeline[] = [
            'date' => $project->created_at,
            'title' => 'Création du projet',
            'description' => 'Le projet "' . $project->Title . '" a été créé',
            'icon' => 'fa-plus-circle',
            'color' => 'blue'
        ];

        // Statut d'approbation
        if ($project->ApprovalStatus) {
            $timeline[] = [
                'date' => $project->updated_at,
                'title' => 'Statut d\'approbation',
                'description' => 'Le projet a été ' . strtolower($project->ApprovalStatus),
                'icon' => $project->ApprovalStatus === 'Approved' ? 'fa-check-circle' : 'fa-times-circle',
                'color' => $project->ApprovalStatus === 'Approved' ? 'green' : 'red'
            ];
        }

        // Devis
        foreach ($project->devis as $devis) {
            $timeline[] = [
                'date' => $devis->created_at,
                'title' => 'Devis créé',
                'description' => 'Un devis a été créé pour le projet',
                'icon' => 'fa-file-invoice-dollar',
                'color' => 'purple'
            ];

            if ($devis->Status) {
                $timeline[] = [
                    'date' => $devis->updated_at,
                    'title' => 'Statut du devis',
                    'description' => 'Le devis a été ' . strtolower($devis->Status),
                    'icon' => $devis->Status === 'Accepted' ? 'fa-check-circle' : 'fa-times-circle',
                    'color' => $devis->Status === 'Accepted' ? 'green' : 'red'
                ];
            }
        }

        // Tâches
        foreach ($project->tasks as $task) {
            $timeline[] = [
                'date' => $task->created_at,
                'title' => 'Nouvelle tâche',
                'description' => 'Tâche créée : ' . $task->Title,
                'icon' => 'fa-tasks',
                'color' => 'yellow'
            ];

            if ($task->Status) {
                $timeline[] = [
                    'date' => $task->updated_at,
                    'title' => 'Statut de la tâche',
                    'description' => 'La tâche "' . $task->Title . '" est ' . strtolower($task->Status),
                    'icon' => $task->Status === 'Completed' ? 'fa-check-circle' : 'fa-clock',
                    'color' => $task->Status === 'Completed' ? 'green' : 'yellow'
                ];
            }
        }

        // Factures
        foreach ($project->invoices as $invoice) {
            $timeline[] = [
                'date' => $invoice->created_at,
                'title' => 'Nouvelle facture',
                'description' => 'Une facture a été créée',
                'icon' => 'fa-file-invoice',
                'color' => 'indigo'
            ];

            if ($invoice->Status) {
                $timeline[] = [
                    'date' => $invoice->updated_at,
                    'title' => 'Statut de la facture',
                    'description' => 'La facture a été ' . strtolower($invoice->Status),
                    'icon' => $invoice->Status === 'Paid' ? 'fa-check-circle' : 'fa-clock',
                    'color' => $invoice->Status === 'Paid' ? 'green' : 'yellow'
                ];
            }
        }

        // Trier la timeline par date
        usort($timeline, function($a, $b) {
            return $a['date']->timestamp - $b['date']->timestamp;
        });

        return $timeline;
    }
} 