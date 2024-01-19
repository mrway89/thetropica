<?php

namespace App\Http\Controllers\Frontend;

use App\Cart;
use App\Events\Order\Payment\Pending;
use App\GosendTrack;
use App\Libraries\GosendLib;
use App\Libraries\NicepayLib;
use App\Newsletter;
use App\NicepayCheckTransaction;
use App\Order;
use App\User;
use App\UserReward;
use App\Veritrans\Midtrans;
use App\Veritrans\Veritrans;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TemporaryController extends CoreController
{
    public function __construct()
    {
        parent::__construct();
        Veritrans::$serverKey    = env('MIDTRANS_SERVER_KEY');
        Midtrans::$serverKey     = env('MIDTRANS_SERVER_KEY');
        Veritrans::$isProduction = env('MIDTRANS_PRODUCTION');
        Midtrans::$isProduction  = env('MIDTRANS_PRODUCTION');
    }

    public function cronTemp()
    {
        $orders = Order::with('details', 'response')->where('status', ['pending', 'sent'])->where('payment_method', '!=', 'gopay')->where('multi', 0)->get();

        foreach ($orders as $order) {
            // 2 failed (jika pembayaran gagal; untuk virtual account/bank transfer dan convenience store -> jika tidak dibayar dalam 1x24 jam) vv
            if ($order->status == 'pending') {
                //

                $paymentStatus  = new NicepayLib;
                $paymentStatus  = $paymentStatus->checkTransaction($order);

                $checkTransactionStatus = new NicepayCheckTransaction;
                $checkTransactionStatus->fill((array) $paymentStatus);
                $checkTransactionStatus->data = json_encode($paymentStatus);
                $checkTransactionStatus->save();
                $checkTransactionStatus->refresh();

                if (isset($paymentStatus->status) && $paymentStatus->status == '0') {
                    $order->status         = 'paid';
                    $order->payment_date   = Carbon::parse($checkTransactionStatus->transDt . $checkTransactionStatus->transTm);
                    $order->payment_status = 1;
                    $order->save();
                    $order->refresh();

                    insertOrderLog($order, 'paid', 'cron');
                }

                if (Carbon::now() >= Carbon::parse($order->created_at)->addDays(1)) {
                    $paymentStatus  = new NicepayLib;
                    $paymentStatus  = $paymentStatus->checkTransaction($order);

                    $checkTransactionStatus = new NicepayCheckTransaction;
                    $checkTransactionStatus->fill((array) $paymentStatus);
                    $checkTransactionStatus->data = json_encode($paymentStatus);
                    $checkTransactionStatus->save();
                    $checkTransactionStatus->refresh();

                    if (isset($paymentStatus->status) && $paymentStatus->status == '0') {
                        $order->status         = 'paid';
                        $order->payment_date   = Carbon::parse($checkTransactionStatus->transDt . $checkTransactionStatus->transTm);
                        $order->payment_status = 1;
                        $order->save();
                        $order->refresh();

                        insertOrderLog($order, 'paid', 'cron');
                    } else {
                        $order->setFailed();
                        $this->stockSync($order);
                        insertOrderLog($order, 'failed', 'cron');
                    }
                    event(new Pending($order));
                }
            }

            // 5 completed setelah barang dikirim  h+2
            if ($order->status == 'sent') {
                $track      = json_decode($this->rajaongkirTrack($order->no_resi, explode('-', $order->cart->courier_type_id)[0]));
                if ($track->rajaongkir->result->delivered) {
                    $newOrder   = $this->saveOrder($order, 'completed');
                    event(new Pending($newOrder));

                    $checkReward = UserReward::where('order_code', $order->order_code)->first();
                    if (!$checkReward) {
                        $user = User::find($order->user_id);

                        if ($user->rewardPercentage()) {
                            $total              = (int) ceil($order->grand_total / $user->rewardPercentage());

                            $reward             = new UserReward;
                            $reward->user_id    = $user->id;
                            $reward->order_id   = $order->id;
                            $reward->points     = $total;
                            $reward->type       = 'in';
                            $reward->save();
                        }

                        // IF FIRSTBUY AND HAVE UPLINE PROCESS
                        $order->processUplineReward();

                        if ($user->hasReferrer()) {
                            $user->processReferrer($order);
                        }
                    }
                }
            }
        }

        $gopayOrders = Order::with('details', 'response')->where('status', 'pending')->where('payment_method', 'gopay')->get();

        foreach ($gopayOrders as $order) {
            if ($order->multi == 0) {
                $vt          = new Veritrans;

                $notif       = $vt->status($order->order_code);
                $transaction = $notif->transaction_status;
                $type        = $notif->payment_type;
                $order_id    = $notif->order_id;
                $fraud       = $notif->fraud_status;
                $cart        = Cart::find($order->cart_id);

                if ($transaction == 'capture') {
                    if ($type == 'credit_card') {
                        if ($fraud == 'challenge') {
                        } else {
                            $order->setPaid();
                            insertRhapsodieOrderLog($order, 'paid', 'cron');
                            $order->payment_date       = Carbon::parse($notif->settlement_time)->format('Y-m-d H:i:s');
                            $order->payment_status     = 1;
                            $order->save();

                            $this->setSoldProduct($order);
                            $this->saveLog($order, 'paid');

                            if ($order->cart->courier_type_id == 'instant' || $order->cart->courier_type_id == 'sameday') {
                                $gosendBooking = $this->goBook($order);
                            }
                        }
                    }
                } elseif ($transaction == 'settlement') {
                    $order->setPaid();
                    insertRhapsodieOrderLog($order, 'paid', 'cron');
                    $order->payment_date       = Carbon::parse($notif->settlement_time)->format('Y-m-d H:i:s');
                    $order->payment_status     = 1;
                    $order->save();
                    $this->saveLog($order, 'paid');
                    $this->setSoldProduct($order);

                    if ($order->cart->courier_type_id == 'instant' || $order->cart->courier_type_id == 'sameday') {
                        $gosendBooking = $this->goBook($order);
                    }
                } elseif ($transaction == 'pending') {
                } elseif ($transaction == 'deny') {
                    $order->setFailed();
                    $this->stockSync($order);
                    insertRhapsodieOrderLog($order, 'failed', 'cron');
                } elseif ($transaction == 'expire') {
                    $order->setFailed();
                    $this->stockSync($order);
                    insertRhapsodieOrderLog($order, 'failed', 'cron');
                } elseif ($transaction == 'cancel') {
                    $order->setFailed();
                    $this->stockSync($order);
                    insertRhapsodieOrderLog($order, 'failed', 'cron');
                }

                if (Carbon::now() >= Carbon::parse($order->created_at)->addMinutes(15)) {
                    $vt          = new Veritrans;

                    if (!empty($order->midtrans)) {
                        $notif       = $vt->status($order->order_code);
                        $transaction = $notif->transaction_status;
                        $type        = $notif->payment_type;
                        $order_id    = $notif->order_id;
                        $fraud       = $notif->fraud_status;
                        $cart        = Cart::find($order->cart_id);

                        if ($transaction == 'capture') {
                            if ($type == 'credit_card') {
                                if ($fraud == 'challenge') {
                                    $order->setFailed();
                                    $this->stockSync($order);
                                } else {
                                    $order->setPaid();
                                    insertRhapsodieOrderLog($order, 'paid', 'cron');
                                    $order->payment_date       = Carbon::parse($notif->settlement_time)->format('Y-m-d H:i:s');
                                    $order->payment_status     = 1;
                                    $order->save();

                                    $this->setSoldProduct($order);
                                    $this->saveLog($order, 'paid');

                                    if ($order->cart->courier_type_id == 'instant' || $order->cart->courier_type_id == 'sameday') {
                                        $gosendBooking = $this->goBook($order);
                                    }
                                }
                            }
                        } elseif ($transaction == 'settlement') {
                            $order->setPaid();
                            insertRhapsodieOrderLog($order, 'paid', 'cron');
                            $order->payment_date       = Carbon::parse($notif->settlement_time)->format('Y-m-d H:i:s');
                            $order->payment_status     = 1;
                            $order->save();
                            $this->saveLog($order, 'paid');
                            $this->setSoldProduct($order);

                            if ($order->cart->courier_type_id == 'instant' || $order->cart->courier_type_id == 'sameday') {
                                $gosendBooking = $this->goBook($order);
                            }
                        } elseif ($transaction == 'pending') {
                            $order->setFailed();
                            $this->stockSync($order);
                            insertRhapsodieOrderLog($order, 'failed', 'cron');
                        } elseif ($transaction == 'deny') {
                            $order->setFailed();
                            $this->stockSync($order);
                            insertRhapsodieOrderLog($order, 'failed', 'cron');
                        } elseif ($transaction == 'expire') {
                            $order->setFailed();
                            $this->stockSync($order);
                            insertRhapsodieOrderLog($order, 'failed', 'cron');
                        } elseif ($transaction == 'cancel') {
                            $order->setFailed();
                            $this->stockSync($order);
                            insertRhapsodieOrderLog($order, 'failed', 'cron');
                        }
                    }
                }
            } else {
                // TODO MULTI
            }
        }

        $gosendOrders =  Order::whereIn('status', ['paid', 'sent'])->whereHas('cart', function ($q) {
            $q->whereIn('courier_type_id', ['sameday', 'instant']);
        })->get();

        if ($gosendOrders) {
            foreach ($gosendOrders as $order) {
                $track              = GosendTrack::where('order_code', $order->order_code)->first();

                $gosend             = new GosendLib;
                $gosendTrack        = $gosend->checkStatus($order);

                $goData             = json_decode($gosendTrack);

                $track->order_code    = $order->order_code;
                $track->status        = $goData->status;
                $track->gojek_code    = $goData->orderNo;
                $track->booking_id    = $goData->id;
                $track->data          = $gosendTrack;
                $track->save();

                if ($goData->status == 'Completed') {
                    $checkReward = UserReward::where('order_code', $order->order_code)->first();
                    if (!$checkReward) {
                        $user = User::find($order->user_id);

                        if ($user->rewardPercentage()) {
                            $total              = (int) ceil($order->grand_total / $user->rewardPercentage());

                            $reward             = new UserReward;
                            $reward->user_id    = $user->id;
                            $reward->order_id   = $order->id;
                            $reward->points     = $total;
                            $reward->type       = 'in';
                            $reward->save();
                        }

                        // IF FIRSTBUY AND HAVE UPLINE PROCESS
                        $order->processUplineReward();

                        if ($user->hasReferrer()) {
                            $user->processReferrer($order);
                        }
                    }
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

    public function upcomingPage()
    {
        return view('errors/maintenance');
    }

    public function upcomingSubscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $checkEmail = Newsletter::where('email', $request->email)->first();

        if ($checkEmail) {
            return redirect()->back()->with('error', 'Your email already subscribed to our newsletter');
        } else {
            $subscribe        = new Newsletter;
            $subscribe->email = $request->email;
            $subscribe->save();

            return redirect()->back()->with('success', 'For subscribing to our newsletter');
        }
    }
}
