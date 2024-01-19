<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReferalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user     = $user;
    }

    public function build()
    {
        $data['user']   = $this->user;
        $data['title']  = 'Talasi Family Invitation';

        return $this->subject('Talasi: You have been invited to join Talasi Family')->view('email.referral.user', $data);
    }
}
