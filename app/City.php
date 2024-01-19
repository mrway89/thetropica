<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'ajax_city';

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }
}
