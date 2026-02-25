<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewNotificationForAdmins implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    // کانالی که همه admin ها گوش می‌دهند
    public function broadcastOn()
    {
        return new Channel('notifications.admins');
    }

    public function broadcastAs()
    {
        return 'new.notification';
    }
}
