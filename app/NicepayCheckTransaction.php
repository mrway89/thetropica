<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NicepayCheckTransaction extends Model
{
    protected $fillable = [
        'resultCd',
        'resultMsg',
        'tXid',
        'iMid',

        'referenceNo',
        'payMethod',
        'amt',
        'cancelAmt',
        'reqDt',

        'reqTm',
        'transDt',
        'transTm',
        'depositDt',
        'depositTm',

        'currency',
        'goodsNm',
        'billingNm',
        'status',
        'authNo',

        'IssueBankCd',
        'acquBankCd',
        'cardNo',
        'InstmntMon',
        'instmntType',

        'preauthToken',
        'recurringToken',
        'ccTransType',
        'acquStatus',
        'vat',

        'fee',
        'notaxAmt',
        'mitraCd',
        'payNo',
        'payValidDt',

        'payValidTm',
        'receiptCode',
        'mRefNo',
        'bankCd',
        'vacctNo',

        'vacctValidDt',
        'vacctValidTm',
        'data',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $table = 'nicepay_check_transaction';
}
