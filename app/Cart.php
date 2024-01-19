<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = [];

    public function details()
    {
        return $this->hasMany(CartDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->first();
    }

    public function getTotalPrice()
    {
        $total = 0;

        foreach ($this->details as $detail) {
            if ($detail->product) {
                if ($detail->product->stock >= $detail->qty) {
                    $total += $detail->qty * $detail->product_price;
                } else {
                    $total += $detail->product->stock * $detail->product_price;
                }
            }
        }

        return $total;
    }

    public function getTotalQtyAttribute($value)
    {
        $total = 0;

        foreach ($this->details as $detail) {
            $total += $detail->qty;
        }

        return $total;
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'user_address_id');
    }
    public function getGrandTotalAttribute()
    {
        return $this->total_price + $this->courier_cost + $this->insurance;
    }
}
