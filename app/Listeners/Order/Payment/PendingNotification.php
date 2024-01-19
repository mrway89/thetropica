<?php

namespace App\Listeners\Order\Payment;

use App\Notifications\OrderNotification;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;

class PendingNotification implements ShouldQueue
{
    public function __construct()
    {
    }

    public function handle($event)
    {
        $order = $event->order;

        $adminEmail = bccAdminEmails();
        $firstEmail = array_splice($adminEmail, 0, 1);

        $user = User::find($order->user_id);
        $user->notify(new OrderNotification($order));

        \Mail::to($user->email)
        ->queue(new \App\Mail\Order\Payment\PendingMail($order, 'user'));

        \Mail::to($firstEmail)
        ->bcc($adminEmail)
        ->queue(new \App\Mail\Order\Payment\PendingMail($order, 'admin'));
    }
}
