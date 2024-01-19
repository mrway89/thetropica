<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id',
        'label',
        'name',
        'province_id',
        'province',
        'city_id',
        'city',
        'subdistrict_id',
        'subdistrict',
        'postal_code',
        'address',
        'phone_number',
        'lat',
        'long',
        'is_default'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
