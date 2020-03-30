<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $phone, $password, $driver;
    
    public function __construct($phone,$password,$driver)
    {
        $this->phone = $phone;
        $this->password = $password;
        $this->driver = $driver;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
