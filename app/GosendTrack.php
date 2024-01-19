<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use function GuzzleHttp\json_decode;

class GosendTrack extends Model
{
    protected $guarded = [];


    public function getCodeAttribute()
    {
        $data = json_decode($this->data);

        return $data->orderNo;
    }
}
