<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class PageVisited
{
    use Dispatchable, SerializesModels;

    public $page;
    public $userId;
    public $action;
    public $deviceType;

    public function __construct($page, $userId, $action, $deviceType)
    {
        $this->page = $page;
        $this->userId = $userId;
        $this->action = $action;
        $this->deviceType = $deviceType;
    }
}