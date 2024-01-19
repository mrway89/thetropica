<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NicepayEnterpriseRegistration extends Model
{
    protected $attributes = [
        'currency' => 'IDR',
        'goodsNm' => 'Goods Name',
        'billingCountry' => 'Indonesia',
        'description' => 'order again',
        'deliveryCountry' => 'Indonesia',
    ];

    protected $fillable = [
        'iMid',
        'merchantKey',
        'payMethod',
        'currency',

        'amt',
        'referenceNo',
        'goodsNm',
        'billingNm',
        'billingPhone',

        'billingEmail',
        'billingCity',
        'billingState',
        'billingPostCd',
        'billingCountry',

        'callBackUrl',
        'dbProcessUrl',
        'description',
        'merchantToken',
        'userIP',

        'cartData',
        'instmntMon',
        'instmntMon',
        'cardCvv',
        'onePassToken',

        'recurrOpt',
        'bankCd',
        'vacctValidDt',
        'vacctValidTm',
        'mitraCd',

        'clickPayNo',
        'dataField3',
        'clickPayToken',
        'payValidDt',
        'payValidTm',

        'billingAddr',
        'deliveryNm',
        'deliveryPhone',
        'deliveryAddr',
        'deliveryEmail',

        'deliveryCity',
        'deliveryState',
        'deliveryPostCd',
        'deliveryCountry',
        'vat',

        'fee',
        'notaxAmt',
        'reqDt',
        'reqTm',
        'reqDomain',

        'reqServerIP',
        'reqClientVer',
        'userSessionID',
        'userAgent',
        'userLanguage',

        'tXid',
    ];

    protected $table = 'nicepay_enterprise_registration';

    public function registrationResponse()
    {
        return $this->belongsTo(NicepayEnterpriseRegistrationResponse::class, 'tXid', 'tXid');
    }
}
