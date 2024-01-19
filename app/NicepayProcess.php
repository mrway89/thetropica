<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NicepayProcess extends Model
{
    protected $fillable = [
        'tXid',
        'merchantToken',
        'referenceNo',
        'payMethod',

        'amt',
        'transDt',
        'transTm',
        'currency',
        'goodsNm',

        'billingNm',
        'matchCI',
        'status',
        'authNo',
        'IssueBankCd',

        'IssueBankNm',
        'acquBankCd',
        'acquBankNm',
        'cardNo',
        'caadExpYymm',

        'InstmntMon',
        'instmntType',
        'preauthToken',
        'recurringToken',
        'ccTransType',

        'vat',
        'fee',
        'notaxAmt',
        'mitraCd',
        'payNo',

        'payValidDt',
        'payValidTm',
        'receiptCode',
        'mRefNo',
        'depositDt',

        'depositTm',
        'bankCd',
        'vacctNo',
        'vacctValidDt',
        'vacctValidTm',

        'data',
        'request_log',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $table = 'nicepay_process';
}
