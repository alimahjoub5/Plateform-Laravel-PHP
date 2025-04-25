<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    public static function createNotification($userId, $message, $type = 'info')
    {
        return Notification::create([
            'UserID' => $userId,
            'Message' => $message,
            'Type' => $type,
            'IsRead' => false
        ]);
    }

    public static function notifyProjectCreated($project)
    {
        // Notifier l'administrateur
        $admin = User::where('Role', 'Admin')->first();
        if ($admin) {
            self::createNotification(
                $admin->UserID, 
                "Nouvelle demande de projet : {$project->Title}", 
                'project'
            );
        }

        // Notifier le client concerné
        self::createNotification(
            $project->ClientID, 
            "Votre demande de projet '{$project->Title}' a été enregistrée", 
            'project'
        );
    }

    public static function notifyProjectUpdated($project)
    {
        // Notifier le client
        self::createNotification(
            $project->ClientID, 
            "Mise à jour du projet '{$project->Title}'", 
            'project'
        );

        // Notifier les membres de l'équipe assignés au projet
        if ($project->team) {
            foreach ($project->team as $member) {
                self::createNotification(
                    $member->UserID, 
                    "Le projet '{$project->Title}' a été mis à jour", 
                    'project'
                );
            }
        }
    }

    public static function notifyInvoiceGenerated($invoice)
    {
        // Notifier le client concerné
        self::createNotification($invoice->project->ClientID, 
            "Une nouvelle facture a été générée pour le montant de {$invoice->Amount} €", 
            'invoice'
        );
    }

    public static function notifyDevisStatusChanged($devis)
    {
        // Si le devis est accepté, notifier l'administrateur
        if ($devis->Status === 'Accepted') {
            $admin = User::where('Role', 'Admin')->first();
            if ($admin) {
                self::createNotification($admin->UserID, 
                    "Le devis #{$devis->Reference} a été accepté", 
                    'devis'
                );
            }
        }

        // Notifier le client concerné
        self::createNotification($devis->ClientID, 
            "Le statut de votre devis #{$devis->Reference} a été mis à jour : {$devis->Status}", 
            'devis'
        );
    }

    public static function notifyPaymentReceived($payment)
    {
        // Notifier l'administrateur
        $admin = User::where('Role', 'Admin')->first();
        if ($admin) {
            self::createNotification($admin->UserID, 
                "Un paiement de {$payment->amount} € a été reçu pour la facture #{$payment->invoice->InvoiceID}", 
                'payment'
            );
        }

        // Notifier le client
        self::createNotification($payment->invoice->project->ClientID, 
            "Votre paiement de {$payment->amount} € a été reçu avec succès", 
            'payment'
        );
    }

    public static function notifyMeetingScheduled($meeting)
    {
        // Notifier tous les participants
        foreach ($meeting->participants as $participant) {
            self::createNotification($participant->UserID, 
                "Une réunion a été programmée pour le {$meeting->date}", 
                'meeting'
            );
        }
    }

    public static function notifyTaskAssigned($task)
    {
        // Notifier la personne à qui la tâche est assignée
        self::createNotification($task->AssignedTo, 
            "Une nouvelle tâche vous a été assignée : {$task->Title}", 
            'task'
        );

        // Notifier le créateur de la tâche
        if ($task->CreatedBy != $task->AssignedTo) {
            self::createNotification($task->CreatedBy, 
                "La tâche {$task->Title} a été assignée à {$task->assignedUser->Username}", 
                'task'
            );
        }
    }
} 