<?php

namespace App\Listeners;

use App\Mail\CuoponMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class CuoponNotification implements ShouldQueue
{
    public function __construct()
    {
    }

    public function handle($event)
    {
        $coupon = $event->coupon;
        $user   = $event->user;

        $adminEmail = bccAdminEmails();
        $firstEmail = array_splice($adminEmail, 0, 1);

        $user = $event->user;

        \Mail::to($user->email)
        ->queue(new CuoponMail($coupon->coupon, $user, 'user'));

        \Mail::to($firstEmail)
        ->bcc($adminEmail)
        ->queue(new CuoponMail($coupon->coupon, $user , 'admin'));
    }
}
