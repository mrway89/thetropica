<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Reward
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reward;

    public function __construct($reward)
    {
        $this->reward = $reward;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
