<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // اینو تغییر بده
use Illuminate\Foundation\Events\Dispatchable;


class AdminNotificationEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets;

    public string $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    // کانالی که فقط مدیرها عضو میشن
    public function broadcastOn()
    {
        return new Channel('admins');
    }

    public function broadcastAs()
    {
        return 'admin.notification';
    }
}
