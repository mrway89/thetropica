<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRewardNotification extends Model
{
    public function downline()
    {
        return $this->belongsTo(User::class, 'downline_id');
    }
}
