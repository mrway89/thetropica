<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReward extends Model
{
    public function cuopon()
    {
        return $this->belongsTo(Cuopon::class, 'order_id');
    }
}
