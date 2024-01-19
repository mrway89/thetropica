<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'product_name',
        'product_price',
        'product_weight',
        'qty',
        'loketcom_token',
        'token_expired',
        'order_result',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
