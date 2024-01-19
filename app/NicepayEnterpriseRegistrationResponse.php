<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NicepayEnterpriseRegistrationResponse extends Model
{
    protected $fillable = [
        'resultCd',
        'resultMsg',
        'tXid',
        'referenceNo',

        'payMethod',
        'amt',
        'currency',
        'goodsNm',
        'billingNm',

        'transDt',
        'transTm',
        'description',
        'callbackUrl',
        'authNo',

        'issuBankCd',
        'issuBankNm',
        'cardNo',
        'instmntMon;',
        'istmntType',

        'recurringToken',
        'preauthToken',
        'ccTransType',
        'vat',
        'free',

        'notaxAmt',
        'bankCd',
        'vacctNo',
        'vacctValidDt',
        'vacctValidTm',

        'mitraCd',
        'payNo',
        'payValidTm',
        'payValidDt',
        'receiptCode',

        'mRefNo',
        'data',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $table = 'nicepay_enterprise_registration_response';
}
