<?php

namespace App\Http\Controllers\Frontend;

use App\Events\Order\Payment\Pending;
use App\GosendTrack;
use App\Libraries\GosendLib;
use App\Libraries\NicepayLib;
use App\NicepayCheckTransaction;
use App\NicepayProcess;
use App\Order;
use Carbon\Carbon;
use function GuzzleHttp\json_encode;
use Illuminate\Http\Request;

class NicepayController extends CoreController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function callback(Request $request)
    {
        // dd($request->all());
        $ip           = request()->ip();
        $dbProcessUrl = new NicepayProcess;

        $dbProcessUrl->fill($request->input());

        $dbProcessUrl->data = json_encode($request->input());
        $dbProcessUrl->save();

        $order = Order::where('order_code', $dbProcessUrl->referenceNo)->first();

        if ($order) {
            $check         = new NicepayLib;
            $paymentStatus = $check->checkTransaction($order);

            $checkTransactionStatus = new NicepayCheckTransaction;
            $checkTransactionStatus->fill((array) $paymentStatus);
            $checkTransactionStatus->data = json_encode($paymentStatus);
            $checkTransactionStatus->save();
            $checkTransactionStatus->refresh();

            if (isset($paymentStatus->status) && $paymentStatus->status == '0') {
                if ($order->status == 'pending') {
                    $order->status         = 'paid';
                    $order->payment_date   = Carbon::parse($paymentStatus->transDt . $paymentStatus->transTm);
                    $order->payment_status = 1;
                    $order->save();
                    $order->refresh();

                    $this->setSoldProduct($order);

                    if ($order->cart->courier_type_id == 'instant' || $order->cart->courier_type_id == 'sameday') {
                        $gosendBooking = $this->goBook($order);
                    }

                    event(new Pending($order));
                    insertOrderLog($order, 'paid', 'callback');
                }
            }
        }

        return redirect(route('frontend.user.transaction'));
    }

    public function process(Request $request)
    {
        $ip           = request()->ip();
        // if($ip == '103.20.51.34') {
        // }
        $dbProcessUrl = new NicepayProcess;

        $dbProcessUrl->fill($request->input());

        $dbProcessUrl->data = json_encode($request->input());
        $dbProcessUrl->save();

        $order = Order::where('order_code', $dbProcessUrl->referenceNo)->first();

        if ($order) {
            $check         = new NicepayLib;
            $paymentStatus = $check->checkTransaction($order);

            $checkTransactionStatus = new NicepayCheckTransaction;
            $checkTransactionStatus->fill((array) $paymentStatus);
            $checkTransactionStatus->data = json_encode($paymentStatus);
            $checkTransactionStatus->save();
            $checkTransactionStatus->refresh();

            if (isset($paymentStatus->status) && $paymentStatus->status == '0') {
                if ($order->status == 'pending') {
                    $order->status         = 'paid';
                    $order->payment_date   = Carbon::parse($paymentStatus->transDt . $paymentStatus->transTm);
                    $order->payment_status = 1;
                    $order->save();
                    $order->refresh();

                    $this->setSoldProduct($order);

                    if ($order->cart->courier_type_id == 'instant' || $order->cart->courier_type_id == 'sameday') {
                        $gosendBooking = $this->goBook($order);
                    }

                    event(new Pending($order));
                    insertOrderLog($order, 'paid', 'callback');
                }
            }
        } else {
            // MULTI
            $orders = Order::where('multi_code', $dbProcessUrl->referenceNo)->get();
            if ($orders) {
                foreach ($orders as $order) {
                    // $check         = new NicepayLib;
                    // $paymentStatus = $check->checkTransaction($order);

                    // $checkTransactionStatus = new NicepayCheckTransaction;
                    // $checkTransactionStatus->fill((array)$paymentStatus);
                    // $checkTransactionStatus->data = json_encode($paymentStatus);
                    // $checkTransactionStatus->save();
                    // $checkTransactionStatus->refresh();

                    // if (isset($paymentStatus->status) && $paymentStatus->status == '0') {
                    //     if($order->status == 'pending'){
                    //         $order->status         = 'paid';
                    //         $order->payment_date   = Carbon::parse($checkTransactionStatus->transDt . $checkTransactionStatus->transTm);
                    //         $order->payment_status = 1;
                    //         $order->save();
                    //         $order->refresh();

                    //         $this->setSoldProduct($order);

                    //         if ($order->cart->courier_type_id == 'instant' || $order->cart->courier_type_id == 'sameday') {
                    //             $gosendBooking = $this->goBook($order);
                    //         }

                    //         event(new Pending($order));
                    //         insertOrderLog($order, 'paid', 'callback');
                    //     }
                    // }
                }
            }
        }

        return;
    }

    protected function setSoldProduct($order)
    {
        foreach ($order->details() as $detail) {
            $detail->product->sold += $detail->quantity;
            $detail->product->save();
        }

        return;
    }

    protected function goBook($order)
    {
        if ($order->gosend_requested == 0) {
            $gosend                     = new GosendLib;
            $bookGosend                 = $gosend->book($order);
            $order->gosend              = $bookGosend;

            $gosendTrack                = $gosend->checkStatus($order);
            $goData                     = json_decode($gosendTrack);

            $updateTrack               = GosendTrack::where('order_code', $order->order_code)->first();

            if (!$updateTrack) {
                $updateTrack                = new GosendTrack;
            }

            $updateTrack->order_code    = $order->order_code;
            $updateTrack->data          = $gosendTrack;
            $updateTrack->status        = $goData->status;
            $updateTrack->gojek_code    = $goData->orderNo;
            $updateTrack->booking_id    = $goData->id;
            $updateTrack->save();
        }
    }
}
