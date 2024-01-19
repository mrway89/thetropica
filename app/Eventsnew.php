<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eventsnew extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'photo_path',
    ];
    protected $table = 'events';
}
