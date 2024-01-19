<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NicepayProfessionalRegistration extends Model
{
    protected $attributes = [
        'currency' => 'IDR',
        'goodsNm' => 'Merchant Goods 1',
        'description' => 'this is test order',
        'optDisplayCB' => '0',
        'optDisplayBL' => '0',
        'isCheckPaymentExptDt' => '1',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $table = 'nicepay_professional_registration';

    public function callBackUrl()
    {
        return $this->hasOne(NicepayCallback::class, 'tXid', 'tXid');
    }

    public function dbProcessUrl()
    {
        return $this->hasOne(NicepayProcess::class, 'tXid', 'tXid');
    }
}
