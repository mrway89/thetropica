<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Notifications\TalasiPointNotification;

class RewardNotification implements ShouldQueue
{
    public function __construct()
    {
    }

    public function handle($event)
    {
        $reward = $event->reward;

        $user = User::find($reward->user_id);
        $user->notify(new TalasiPointNotification($reward));
    }
}
