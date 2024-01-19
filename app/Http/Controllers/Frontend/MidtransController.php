<?php

namespace App\Http\Controllers\Frontend;

use App\Cart;
use App\Events\Order\Payment\Pending;
use App\GosendTrack;
use App\Libraries\GosendLib;
use App\MidtransNotification;
use App\Order;
use App\Veritrans\Veritrans;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MidtransController extends CoreController
{
    public function __construct()
    {
        parent::__construct();
        Veritrans::$serverKey    = env('MIDTRANS_SERVER_KEY');
        Veritrans::$isProduction = env('MIDTRANS_PRODUCTION');
    }

    public function notification()
    {
        $vt          = new Veritrans;
        $json_result = file_get_contents('php://input');
        $result      = json_decode($json_result);

        $data        = new MidtransNotification;
        $data->data  = $json_result;
        $data->type  = 'notification';
        $data->save();

        // DOUBLE CHECK SEND REQUEST TO MIDTRANS
        if ($result) {
            $notif = $vt->status($result->order_id);
        }

        $transaction = $notif->transaction_status;
        $type        = $notif->payment_type;
        $order_id    = $notif->order_id;

        $fraud       = $notif->fraud_status;
        $order       = Order::with('details')->where('order_code', $order_id)->first();

        $cart = Cart::find($order->cart_id);

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $order->setPending();
                } else {
                    $order->setPaid();
                    $order->payment_date       = Carbon::parse($notif->settlement_time)->format('Y-m-d H:i:s');
                    $order->payment_status     = 1;
                    $order->save();

                    $this->setSoldProduct($order);

                    if ($order->cart->courier_type_id == 'instant' || $order->cart->courier_type_id == 'sameday') {
                        if ($order->gosend_requested == 0) {
                            $gosend        = new GosendLib;
                            $bookGosend    = $gosend->book($order);
                            $order->gosend = $bookGosend;

                            $gosendTrack        = $gosend->checkStatus($order);
                            $goData             = json_decode($gosendTrack);

                            $updateTrack                = new GosendTrack;
                            $updateTrack->order_code    = $order->order_code;
                            $updateTrack->data          = $gosendTrack;
                            $updateTrack->status        = $goData->status;
                            $updateTrack->gojek_code    = $goData->orderNo;
                            $updateTrack->booking_id    = $goData->id;
                            $updateTrack->save();
                        }
                    }
                }
            }
        } elseif ($transaction == 'settlement') {
            $order->setPaid();

            $order->payment_date       = Carbon::parse($notif->settlement_time)->format('Y-m-d H:i:s');
            $order->payment_status     = 1;
            $order->save();

            $this->setSoldProduct($order);

            if ($order->cart->courier_type_id == 'instant' || $order->cart->courier_type_id == 'sameday') {
                if ($order->gosend_requested == 0) {
                    $gosend        = new GosendLib;
                    $bookGosend    = $gosend->book($order);
                    $order->gosend = $bookGosend;

                    $gosendTrack        = $gosend->checkStatus($order);
                    $goData             = json_decode($gosendTrack);

                    $updateTrack                = new GosendTrack;
                    $updateTrack->order_code    = $order->order_code;
                    $updateTrack->data          = $gosendTrack;
                    $updateTrack->status        = $goData->status;
                    $updateTrack->gojek_code    = $goData->orderNo;
                    $updateTrack->booking_id    = $goData->id;
                    $updateTrack->save();
                }
            }
        } elseif ($transaction == 'pending') {
            $order->setPending();
        } elseif ($transaction == 'deny') {
            $order->setFailed();
            $this->stockSync($order);
        } elseif ($transaction == 'expire') {
            $order->setFailed();
            $this->stockSync($order);
        } elseif ($transaction == 'cancel') {
            $order->setFailed();
            $this->stockSync($order);
        }

        event(new Pending($order));

        return;
    }

    protected function setSoldProduct($order)
    {
        foreach ($order->details as $detail) {
            $detail->product->sold += $detail->quantity;
            $detail->product->save();
        }

        return;
    }

    public function getPaymentStatus($id)
    {
        $vt         = new Veritrans;
        $notif      = $vt->status($id);
    }

    public function finish()
    {
        $data        = new MidtransNotification;
        $json_result = file_get_contents('php://input');
        $data->data  = $json_result;
        $data->type  = 'finish';
        $data->save();

        return;
    }

    public function unfinish()
    {
        $data        = new MidtransNotification;
        $json_result = file_get_contents('php://input');
        $data->data  = $json_result;
        $data->type  = 'unfinish';
        $data->save();

        return;
    }

    public function error()
    {
        $data        = new MidtransNotification;
        $json_result = file_get_contents('php://input');
        $data->data  = $json_result;
        $data->type  = 'error';
        $data->save();

        return;
    }

    public function snapFinish()
    {
        $data        = new MidtransNotification;
        $json_result = file_get_contents('php://input');
        $data->data  = $json_result;
        $data->type  = 'snap_finish';
        $data->save();

        return;
    }

    public function snapUnfinish()
    {
        $data        = new MidtransNotification;
        $json_result = file_get_contents('php://input');
        $data->data  = $json_result;
        $data->type  = 'snap_unfinish';
        $data->save();

        return;
    }

    public function snapError()
    {
        $data        = new MidtransNotification;
        $json_result = file_get_contents('php://input');
        $data->data  = $json_result;
        $data->type  = 'snap_error';
        $data->save();

        return;
    }
}
