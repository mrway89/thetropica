<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReferral extends Model
{
    public function upline()
    {
        return $this->belongsTo(User::class, 'upline_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
