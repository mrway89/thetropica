<?php

namespace App\Http\Controllers\Frontend;

use App\Order;
use App\Post;
use App\NicepayEnterpriseRegistrationResponse;
use App\Libraries\NicepayLib;
use Illuminate\Support\Carbon;
use App\Events\Order\Payment\Pending;
use App\NicepayCheckTransaction;
use App\Libraries\GosendLib;
use function GuzzleHttp\json_decode;
use App\Pickpoint;
use App\UserAddress;
use App\Cart;
use App\Veritrans\Veritrans;
use App\Veritrans\Midtrans;
use GuzzleHttp\Client;
use function GuzzleHttp\json_encode;
use DB;

class OrderController extends CoreController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        Veritrans::$serverKey    = env('MIDTRANS_SERVER_KEY');
        Midtrans::$serverKey     = env('MIDTRANS_SERVER_KEY');
        Veritrans::$isProduction = env('MIDTRANS_PRODUCTION');
        Midtrans::$isProduction  = env('MIDTRANS_PRODUCTION');
    }

    public function detail($code)
    {
        $order = Order::with('response')->where('order_code', $code)->where('user_id', \Auth::id())->firstOrFail();

        if (\Auth::id() !== $order->user_id) {
            return redirect()->route('frontend.home');
        }

        if ($order->multi == 1) {
            if ($order->payment_method !== 'gopay') {
                $this->data['response'] = json_decode($order->multiResponse);
            } else {
                $multiCart = Cart::where('user_id', \Auth::id())->where('type', 'multi')->where('status', 'current')->get();
                foreach ($multiCart as $c) {
                    $c->status = 'checkout';
                    $c->save();
                }

                $curCart   = Cart::with('details', 'details.product', 'details.product.cover', 'details.product.brand')->where('status', 'current')->where('type', 'cart')->where('user_id', \Auth::id())->first();
                $curCart->status = 'checkout';
                $curCart->save();

                $sumTotal = Order::where('multi_code', $order->multi_code)->sum('grand_total');
                $this->data['grand_total'] = $sumTotal;
            }
        } else {
            if ($order->payment_method !== 'gopay' && $order->payment_method !== 'reward_point') {
                $this->data['response'] = json_decode($order->response);
            }

            if ($order->payment_method == 'reward_point') {
                # code...
            }
        }

        $qrurl = 'https://api.midtrans.com/v2/gopay/';

        if (env('MIDTRANS_PRODUCTION') == false) {
            $qrurl = 'https://api.sandbox.veritrans.co.id/v2/gopay/';
        }

        if ($order->payment_method == 'gopay') {
            $midtrans = json_decode($order->midtrans);
            if (!$order->midtrans || $order->midtrans == 'null') {
                $requestMidtrans = $this->requestMidtrans($order);
                $order->refresh();

                $midtrans = json_decode($order->midtrans);
                $qrcode   = $qrurl . $midtrans->transaction_id . '/qr-code';
            } else {
                $qrcode = $qrurl . $midtrans->transaction_id . '/qr-code';
            }
            $this->data['qrcode'] = $qrcode;
        }

        $this->data['order']    = $order;

        return $this->renderView('frontend.checkout.complete_payment');
    }

    private function checkMidtrans($order_code)
    {
        $vt          = new Veritrans;
        $result      = $vt->status($order->order_code);
        return json_encode($result, JSON_UNESCAPED_SLASHES);
    }


    private function requestMidtrans($order)
    {
        $vt                  = new Veritrans;
        $transaction_details = [
            'gross_amount'      => $order->grand_total,
            'order_id'          => $order->order_code
        ];

        $time          = time();
        $custom_expiry = [
            'order_time'        => date('Y-m-d H:i:s O', $time),
            'expiry_duration'   => 15,
            'unit'              => 'minutes'
        ];

        foreach ($order->details as $index => $detail) {
            $items[$index]['id']                = $detail->id;
            $items[$index]['price']             = $detail->price;
            $items[$index]['quantity']          = $detail->quantity;
            $items[$index]['name']              = $detail->product->name;
        }

        if ($order->total_shipping_cost) {
            $items[$order->details->count()]['id']       = 'SHIPPINGFEE';
            $items[$order->details->count()]['price']    = $order->total_shipping_cost;
            $items[$order->details->count()]['quantity'] = 1;
            $items[$order->details->count()]['name']     = 'Ongkos Kirim';
        }

        if ($order->voucher_id) {
            $items[$order->total_shipping_cost ? $order->details->count() + 1 : $order->details->count()]['id']       = 'VOUCHER';
            $items[$order->total_shipping_cost ? $order->details->count() + 1 : $order->details->count()]['price']    = 0 - $order->voucher_value;
            $items[$order->total_shipping_cost ? $order->details->count() + 1 : $order->details->count()]['quantity'] = 1;
            $items[$order->total_shipping_cost ? $order->details->count() + 1 : $order->details->count()]['name']     = 'Voucher Discount';
        }

        // Populate customer's billing address
        $billing_address['first_name']         = \Auth::user()->name;
        $billing_address['last_name']          = '';
        $billing_address['address']            = $order->cart->address->address;
        $billing_address['city']               = $order->cart->address->city;
        $billing_address['postal_code']        = $order->cart->address->postal_code;
        $billing_address['phone']              = $order->cart->address->phone_number;
        $billing_address['country_code']       = 'IDN';

        $shipping_address['first_name']        = \Auth::user()->name;
        $shipping_address['last_name']         = '';
        $shipping_address['address']           = $order->cart->address->address;
        $shipping_address['city']              = $order->cart->address->city;
        $shipping_address['postal_code']       = $order->cart->address->postal_code;
        $shipping_address['phone']             = $order->cart->address->phone_number;
        $shipping_address['country_code']      = 'IDN';

        // Populate customer's Info
        $customer_details = [
            'first_name'                => \Auth::user()->name,
            'last_name'                 => '',
            'email'                     => \Auth::user()->email,
            'phone'                     => \Auth::user()->phone,
        ];

        $paymentType = 'gopay';
        $gopay = [
            "enable_callback" => false,
            "callback_url" => "someapps://callback"
        ];

        $transaction_data = [
            'payment_type'                  => $paymentType,
            'transaction_details'           => $transaction_details,
            'item_details'                  => $items,
            'customer_details'              => $customer_details,
            'gopay'                         => $gopay,
        ];

        // dd($transaction_data);

        try {
            $vtweb_url       = $vt->vtdirect_charge($transaction_data);
            $data['result']  = $vtweb_url;
            $order->midtrans = json_encode($vtweb_url);
            $order->save();
            return $vtweb_url;
        } catch (Exception $e) {
            return $e->getMessage;
        }
    }

    public function payment_notification(){
        $order_id = $_GET['order_id'];
        $status_code = $_GET['status_code'];
        $transaction_status = $_GET['transaction_status'];

        
        $order_id = str_replace("TA-", "", $order_id);
        

        $order = Order::where('id', $order_id)->first();
       
		if($transaction_status == "capture"){
			$update['status'] = "Processing";
			$update['updated_at'] = date("Y-m-d H:i:s");

			Order::where('id', $order_id)->update($update);
		}
		
		$this->data['order'] = $order;	
        $this->data['order_details'] = DB::table('order_details')->where('order_id', $order_id)->get();			
		return $this->renderView('frontend.checkout.finish_payment');        
    }
	
	public function payment_finish(){
        $order_id = $_GET['order_id'];
        $status_code = $_GET['status_code'];
        $transaction_status = $_GET['transaction_status'];

        
        $order_id = str_replace("TA-", "", $order_id);
        

        $order = Order::where('id', $order_id)->first();
       
		if($transaction_status == "capture"){
			$update['status'] = "Processing";
			$update['updated_at'] = date("Y-m-d H:i:s");

			Order::where('id', $order_id)->update($update);
		}
		
		$this->data['order'] = $order;	
        $this->data['order_details'] = DB::table('order_details')->where('order_id', $order_id)->get();			
		return $this->renderView('frontend.checkout.finish_payment');        
    }
	
	public function payment_unfinish(){
        $order_id = $_GET['order_id'];
        $status_code = $_GET['status_code'];
        $transaction_status = $_GET['transaction_status'];

        
        $order_id = str_replace("TA-", "", $order_id);
        

        $order = Order::where('id', $order_id)->first();
       
		if($transaction_status == "capture"){
			$update['status'] = "Processing";
			$update['updated_at'] = date("Y-m-d H:i:s");

			Order::where('id', $order_id)->update($update);
		}
		
		$this->data['order'] = $order;	
        $this->data['order_details'] = DB::table('order_details')->where('order_id', $order_id)->get();			
		return $this->renderView('frontend.checkout.finish_payment');        
    }

    public function test()
    {
        // \Artisan::call('cache:clear');


        $gopayOrders = Order::with('details', 'response')->where('status', 'pending')->where('payment_method', 'gopay')->get();

        foreach ($gopayOrders as $order) {
            if ($order->multi !== 1) {
                $vt          = new Veritrans;

                if (!empty($order->midtrans)) {
                    $notif       = $vt->status($order->order_code);
                    $transaction = $notif->transaction_status;
                    $type        = $notif->payment_type;
                    $order_id    = $notif->order_id;
                    $fraud       = $notif->fraud_status;
                    $cart       = Cart::find($order->cart_id);

                    if ($transaction == 'capture') {
                        if ($type == 'credit_card') {
                            if ($fraud == 'challenge') { } else {
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
                    } elseif ($transaction == 'pending') { } elseif ($transaction == 'deny') {
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

                if (Carbon::now() >= Carbon::parse($order->created_at)->addMinutes(15)) {
                    $vt          = new Veritrans;

                    if (!empty($order->midtrans)) {
                        $notif       = $vt->status($order->order_code);
                        $transaction = $notif->transaction_status;
                        $type        = $notif->payment_type;
                        $order_id    = $notif->order_id;
                        $fraud       = $notif->fraud_status;
                        $cart       = Cart::find($order->cart_id);

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
            }
        }
    }
}
