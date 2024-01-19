<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ideas extends Model
{
    protected $fillable = ['title', 'description'];
    protected $table = 'ideas';
}
