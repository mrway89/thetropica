<?php
namespace App\Libraries;

class RewardLib
{
    public function paidOrder($order)
    {
        $order->status         = 'paid';
        $order->payment_date   = Carbon::parse($checkTransactionStatus->transDt . $checkTransactionStatus->transTm);
        $order->payment_status = 1;
        $order->save();
        $order->refresh();

        insertOrderLog($order, 'paid', 'cron');
    }
}
