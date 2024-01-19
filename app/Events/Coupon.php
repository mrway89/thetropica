<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Coupon
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $coupon;
    public $user;

    public function __construct($coupon, $user)
    {
        $this->coupon   = $coupon;
        $this->user     = $user;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
