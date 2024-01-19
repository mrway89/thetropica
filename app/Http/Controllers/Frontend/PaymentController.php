<?php

namespace App\Http\Controllers\Frontend;

use App\Order;
use App\Post;
use App\Libraries\NicepayLib;
use Illuminate\Support\Carbon;
use App\Events\Order\Payment\Pending;
use App\Pickpoint;
use App\UserAddress;
use App\Cart;
use DB;
use Illuminate\Http\Request;

class PaymentController extends CoreController
{
    public function __construct()
    {
        parent::__construct();
        //$this->middleware('auth');
    }

    public function index(){

    }
    	
     public function payment_finish(){
        $order_id = $_GET['order_id'];
        $status_code = $_GET['status_code'];
        $transaction_status = $_GET['transaction_status'];

        
        $order_id = str_replace("TA-", "", $order_id);
        //echo $order_id; die();        

        $order = Order::where('id', $order_id)->first();
        //echo $order->status; die();       
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
}
