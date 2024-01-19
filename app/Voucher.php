<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'start_date',
        'end_date',
        'code',
        'limit_per_user',

        'quota',
        'discount',
        'min_amount',
        'type',
        'unit',
    ];
    public static $typeShippingOnly = 'Shipping Only';
    public static $typeTotalOnly    = 'Total Only';
    public static $unitAmount       = 'Amount';
    public static $unitPercentage   = 'Percentage';

    public function carts()
    {
        return $this->hasMany(Cart::class, 'voucher_id');
    }

    public function deleteSession()
    {
        session()->forget('voucher');
    }
}
