<?php

namespace App\Observers;

use App\Models\Project;
use App\Services\NotificationService;

class ProjectObserver
{
    public function created(Project $project)
    {
        NotificationService::notifyProjectCreated($project);
    }

    public function updated(Project $project)
    {
        NotificationService::notifyProjectUpdated($project);
    }
} 