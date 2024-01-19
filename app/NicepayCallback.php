<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NicepayCallback extends Model
{
    protected $fillable = [
        'resultCd',
        'resultMsg',
        'tXid',
        'referenceNo',

        'amount',
        'transDt',
        'transTm',
        'description',
        'receiptCode',

        'payNo',
        'mitraCd',
        'authNo',
        'bankVacctNo',
        'bankCd',

        'data',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $table = 'nicepay_callback';

    public function transactionRegistration()
    {
        return $this->belongsTo(NicepayProfessionalRegistration::class, 'tXid', 'tXid');
    }
}
