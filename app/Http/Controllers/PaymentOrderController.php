<?php

namespace App\Http\Controllers;

use App\Order;
use App\Post;
use DateTime;
use Illuminate\Support\Carbon;
use App\Events\Order\Payment\Pending;
use App\Pickpoint;
use App\UserAddress;
use App\Cart;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentOrderController extends Controller{
    /**
    * Show the profile for the given user.
    *
    * @param  int  $id
    * @return View
    */

    public function index(){

    }

    public function payment_notification(){
		require_once dirname(__FILE__) . '/Frontend/midtrans/midtrans-php/Midtrans.php'; 
		
		\Midtrans\Config::$isProduction = true;
		\Midtrans\Config::$serverKey = 'Mid-server-smsTIr4vHsCziMDKurq7p4Qp';
       // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
		
	$notif = new \Midtrans\Notification();

	$transaction = $notif->transaction_status;
        $fraud = $notif->fraud_status;

        error_log("Order ID $notif->order_id: "."transaction status = $transaction, fraud staus = $fraud");
        $orderid = $notif->order_id;

        //if (strpos($order_id, "TA-") !== false) {
            $order_id = str_replace("TA-", "", $orderid);
        //}

        $order = Order::where('id', $order_id)->first();
        if(isset($order->id)){
            if ($transaction == 'capture'|| $transaction == 'settlement') {
                if ($fraud == 'challenge') {
                    // TODO Set payment status in merchant's database to 'challenge'
                    $update['status'] = "Payment Challenge";
                }
                else if ($fraud == 'accept') {
                    // TODO Set payment status in merchant's database to 'success'
                    $update['status'] = "Processing";
                }
            }
            else if ($transaction == 'cancel') {
                if ($fraud == 'challenge') {
                    // TODO Set payment status in merchant's database to 'failure'
                    $update['status'] = "Payment Failed";
                }
                else if ($fraud == 'accept') {
                    // TODO Set payment status in merchant's database to 'failure'
                    $update['status'] = "Payment Failed";
                }
            }
            else if ($transaction == 'deny') {
                // TODO Set payment status in merchant's database to 'failure'
                $update['status'] = "Payment Failed";
            }
            else if ($transaction == 'pending') {
                // TODO Set payment status in merchant's database to 'failure'
                $update['status'] = "Pending";
            }
            else if ($transaction == 'settlement') {
                // TODO Set payment status in merchant's database to 'failure'
                $update['status'] = "Completed";
            }


            // Do Update if any
            if (isset($update)) {
                $update['updated_at'] = date("Y-m-d H:i:s");
                $update['payment_data'] = json_encode($notif);

                Order::where('id', $order_id)->update($update);
            }
        }
	}


}
