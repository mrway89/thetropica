<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCoupon extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Cuopon::class, 'coupon_id', 'id');
    }

    public function checkCoupon()
    {
        $order = \App\Order::whereIn('status', ['pending', 'paid', 'sent', 'completed'])->where('voucher_id', $this->voucher_id)->first();
        if ($order) {
            return false;
        }

        return true;
    }
}
