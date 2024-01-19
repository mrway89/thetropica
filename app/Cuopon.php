<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuopon extends Model
{
    protected $dates = [
        'start_date', 'end_date'
    ];
}
