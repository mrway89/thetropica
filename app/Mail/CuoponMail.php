<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CuoponMail extends Mailable
{
    use Queueable, SerializesModels;

    public $coupon;
    public $user;
    public $type;

    public function __construct($coupon, $user, $type)
    {
        $this->coupon   = $coupon;
        $this->user     = $user;
        $this->type     = $type;
    }

    public function build()
    {
        $data['type']       = $this->type;
        $data['coupon']     = $this->coupon;
        $data['user']       = $this->user;
        $data['title']      = 'Coupon ' . $this->coupon->name;

        return $this->subject('Talasi: Coupon ' . $this->coupon->name . ' Redeemed')->view('email/rewards/voucher', $data);
    }
}
