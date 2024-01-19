<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;

class Order extends Model
{
    use Notifiable;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function setPending()
    {
        $this->attributes['status'] = 'pending';
        self::save();
    }

    public function setPaid()
    {
        $this->attributes['status'] = 'paid';
        self::save();
    }

    public function setFailed()
    {
        $this->attributes['status'] = 'failed';
        self::save();
    }

    public function setCompleted()
    {
        $this->attributes['status'] = 'completed';
        self::save();
    }

    public function isSent()
    {
        if ($this->status == 'sent' || $this->status == 'received' || $this->status == 'completed') {
            return true;
        }

        return false;
    }

    public function logs()
    {
        return $this->hasMany(OrderLog::class);
    }

    public function address()
    {
        return $this->hasManyThrough('App\UserAddress', 'App\Cart');
    }

    public function response()
    {
        return $this->hasOne(NicepayEnterpriseRegistrationResponse::class, 'referenceNo', 'order_code')->latest();
    }

    public function registration()
    {
        return $this->hasOne(NicepayEnterpriseRegistration::class, 'referenceNo', 'order_code')->latest();
    }

    public function multiRegistration()
    {
        return $this->hasOne(NicepayEnterpriseRegistration::class, 'referenceNo', 'multi_code')->latest();
    }

    public function multiResponse()
    {
        return $this->hasOne(NicepayEnterpriseRegistrationResponse::class, 'referenceNo', 'multi_code')->latest();
    }

    public function gosendStatus()
    {
        return $this->hasOne(GosendTrack::class, 'order_code', 'order_code');
    }

    public function haveReview()
    {
        $status = false;

        $detail = \App\OrderDetail::where('order_id', $this->id)->where('is_reviewed', 0)->first();

        if ($detail) {
            $status = true;
        }

        return $status;
    }

    public function encrypted()
    {
        return Crypt::encryptString($this->id);
    }

    public function isFirstBuy()
    {
        $checkOrder = \App\Order::where('user_id', $this->user_id)->where('id', '!=', $this->id)->whereIn('status', ['paid', 'sent', 'completed'])->get();

        if ($checkOrder->count() > 0) {
            return false;
        }

        return true;
    }

    public function processUplineReward()
    {
        $checkOrder = \App\Order::where('user_id', $this->user_id)->where('id', '!=', $this->id)->whereIn('status', ['paid', 'sent', 'completed'])->get();
        if ($checkOrder->count() > 0) {
            return;
        } else {
            $checkUpline = \App\UserReferral::where('user_id', $this->user_id)->where('get_reward', 0)->first();
            if ($checkUpline) {
                $coupon = \App\Cuopon::where('is_referral', 1)->first();

                $voucher                    = new Voucher;
                $voucher->type              = $coupon->voucher_type;
                $voucher->start_date        = Carbon::now();
                $voucher->end_date          = Carbon::now()->addDays($coupon->duration);
                $voucher->limit_per_user    = 1;
                $voucher->quota             = 1;
                $voucher->unit              = 'Amount';
                $voucher->discount          = $coupon->amount;
                $voucher->min_amount        = $coupon->min_purchase;
                $voucher->bank              = $coupon->bank;
                $voucher->code              = $this->generateUniqueVoucher(9);
                $voucher->save();

                $userCuopon                 = new UserCoupon;
                $userCuopon->user_id        = $checkUpline->upline_id;
                $userCuopon->voucher_id     = $voucher->id;
                $userCuopon->coupon_id      = $coupon->id;
                $userCuopon->type           = 'voucher';
                $userCuopon->save();

                $voucherDown                    = new Voucher;
                $voucherDown->type              = $coupon->voucher_type;
                $voucherDown->start_date        = Carbon::now();
                $voucherDown->end_date          = Carbon::now()->addDays($coupon->duration);
                $voucherDown->limit_per_user    = 1;
                $voucherDown->quota             = 1;
                $voucherDown->unit              = 'Amount';
                $voucherDown->discount          = $coupon->amount;
                $voucherDown->min_amount        = $coupon->min_purchase;
                $voucherDown->bank              = $coupon->bank;
                $voucherDown->code              = $this->generateUniqueVoucher(10);
                $voucherDown->save();

                $userCuoponDown                 = new UserCoupon;
                $userCuoponDown->user_id        = $this->user_id;
                $userCuoponDown->voucher_id     = $voucherDown->id;
                $userCuoponDown->coupon_id      = $coupon->id;
                $userCuoponDown->type           = 'voucher';
                $userCuoponDown->save();

                $notification                   = new UserRewardNotification;
                $notification->user_id          = $checkUpline->upline_id;
                $notification->downline_id      = $this->user_id;
                $notification->save();

                $notificationDown               = new UserRewardNotification;
                $notificationDown->user_id      = $this->user_id;
                $notificationDown->save();

                $checkUpline->get_reward    = 1;
                $checkUpline->save();

                return;
            }
        }

        return;
    }

    private function generateUniqueVoucher($length = 20)
    {
        $characters       = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
