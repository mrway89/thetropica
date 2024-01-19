<?php

namespace App\Http\Controllers;

use App\Config;
use App\Events\Order\Payment\Pending;
use App\Events\Reward;
use App\GosendTrack;
use App\Libraries\GosendLib;
use App\Libraries\NicepayLib;
use App\Order;
use App\OrderLog;
use App\User;
use App\UserReward;
use Carbon\Carbon;
use CRUDBooster;
use function GuzzleHttp\json_decode;
use Illuminate\Http\Request;
use Session;
use App\Veritrans\Veritrans;

class AdminOrdersController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {
        // START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field         = 'id';
        $this->limit               = '20';
        $this->orderby             = 'id,desc';
        $this->global_privilege    = false;
        $this->button_table_action = true;
        $this->button_bulk_action  = true;
        $this->button_action_style = 'button_icon';
        $this->button_add          = false;
        $this->button_edit         = true;
        $this->button_delete       = false;
        $this->button_detail       = false;
        $this->button_show         = false;
        $this->button_filter       = true;
        $this->button_import       = false;
        $this->button_export       = true;
        $this->table               = 'orders';
        // END CONFIGURATION DO NOT REMOVE THIS LINE

        // START COLUMNS DO NOT REMOVE THIS LINE
        $this->col   = [];
        $this->col[] = ['label' => 'Order Code', 'name' => 'order_code'];
        $this->col[] = ['label' => 'User', 'name' => 'user_id', 'join' => 'users,name'];
        $this->col[] = ['label' => 'Status', 'name' => 'status'];

        $this->col[] = ['label' => 'Payment Method', 'name' => 'payment_method', 'visible' => false];
        $this->col[] = ['label' => 'Payment Date', 'name' => 'payment_date', 'visible' => false];
        $this->col[] = ['label' => 'Subtotal', 'name' => 'subtotal', 'visible' => false, 'callback' => function ($row) {
            return currency_format($row->subtotal);
        }];
        $this->col[] = ['label' => 'Weight', 'name' => 'total_weight', 'visible' => false];
        $this->col[] = ['label' => 'Courier Cost', 'name' => 'total_shipping_cost', 'visible' => false, 'callback' => function ($row) {
            return currency_format($row->total_shipping_cost);
        }];
        $this->col[] = ['label' => 'Notes', 'name' => 'notes', 'visible' => false];
        $this->col[] = ['label' => 'Voucher Code', 'name' => 'voucher_code', 'visible' => false];
        $this->col[] = ['label' => 'Voucher Value', 'name' => 'voucher_value', 'visible' => false, 'callback' => function ($row) {
            return currency_format($row->voucher_value);
        }];
        $this->col[] = ['label' => 'Airway Bill', 'name' => 'no_resi', 'visible' => false];
        $this->col[] = ['label' => 'Delivery Date', 'name' => 'delivery_date', 'visible' => false];

        $this->col[] = ['label' => 'Grand Total', 'name' => 'grand_total', 'callback' => function ($row) {
            return currency_format($row->grand_total);
        }];

        $this->col[] = ['label' => 'Created', 'name' => 'created_at'];
        $this->col[] = ['label'=>'Products', 'name'=>'id', 'callback_php'=>'\App\Http\Controllers\AdminOrdersController::getProducts($row)', 'visible' => false];
        // END COLUMNS DO NOT REMOVE THIS LINE

        // START FORM DO NOT REMOVE THIS LINE
        $this->form   = [];
        $this->form[] = ['label' => 'Order Code', 'name' => 'order_code', 'type' => 'text', 'validation' => '', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'validation' => 'required', 'width' => 'col-sm-9', 'dataenum' => 'paid|Paid;sent|Sent;received|Received;completed|Completed;canceled|Canceled', 'value' => '1'];
        $this->form[] = ['label' => 'Subtotal', 'name' => 'subtotal', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10', 'disabled' => true];

        /*
        | ----------------------------------------------------------------------
        | Sub Module
        | ----------------------------------------------------------------------
        | @label          = Label of action
        | @path           = Path of sub module
        | @foreign_key 	  = foreign key of sub table/module
        | @button_color   = Bootstrap Class (primary,success,warning,danger)
        | @button_icon    = Font Awesome Class
        | @parent_columns = Sparate with comma, e.g : name,created_at
        |
        */
        $this->sub_module = [];

        /*
        | ----------------------------------------------------------------------
        | Add More Action Button / Menu
        | ----------------------------------------------------------------------
        | @label       = Label of action
        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
        | @icon        = Font awesome class icon. e.g : fa fa-bars
        | @color 	   = Default is primary. (primary, warning, succecss, info)
        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
        |
        */
        $this->addaction = [];

        /*
        | ----------------------------------------------------------------------
        | Add More Button Selected
        | ----------------------------------------------------------------------
        | @label       = Label of action
        | @icon 	   = Icon from fontawesome
        | @name 	   = Name of button
        | Then about the action, you should code at actionButtonSelected method
        |
        */
        $this->button_selected = [];

        /*
        | ----------------------------------------------------------------------
        | Add alert message to this module at overheader
        | ----------------------------------------------------------------------
        | @message = Text of message
        | @type    = warning,success,danger,info
        |
        */
        $this->alert        = [];

        /*
        | ----------------------------------------------------------------------
        | Add more button to header button
        | ----------------------------------------------------------------------
        | @label = Name of button
        | @url   = URL Target
        | @icon  = Icon from Awesome.
        |
        */
        $this->index_button = [];

        /*
        | ----------------------------------------------------------------------
        | Customize Table Row Color
        | ----------------------------------------------------------------------
        | @condition = If condition. You may use field alias. E.g : [id] == 1
        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.
        |
        */
        $this->table_row_color = [];

        /*
        | ----------------------------------------------------------------------
        | You may use this bellow array to add statistic at dashboard
        | ----------------------------------------------------------------------
        | @label, @count, @icon, @color
        |
        */
        $this->index_statistic = [];

        /*
        | ----------------------------------------------------------------------
        | Add javascript at body
        | ----------------------------------------------------------------------
        | javascript code in the variable
        | $this->script_js = "function() { ... }";
        |
        */
        $this->script_js = null;

        /*
        | ----------------------------------------------------------------------
        | Include HTML Code before index table
        | ----------------------------------------------------------------------
        | html code to display it before index table
        | $this->pre_index_html = "<p>test</p>";
        |
        */
        $this->pre_index_html = null;

        /*
        | ----------------------------------------------------------------------
        | Include HTML Code after index table
        | ----------------------------------------------------------------------
        | html code to display it after index table
        | $this->post_index_html = "<p>test</p>";
        |
        */
        $this->post_index_html = null;

        /*
        | ----------------------------------------------------------------------
        | Include Javascript File
        | ----------------------------------------------------------------------
        | URL of your javascript each array
        | $this->load_js[] = asset("myfile.js");
        |
        */
        $this->load_js = [];

        /*
        | ----------------------------------------------------------------------
        | Add css style at body
        | ----------------------------------------------------------------------
        | css code in the variable
        | $this->style_css = ".style{....}";
        |
        */
        $this->style_css = null;

        /*
        | ----------------------------------------------------------------------
        | Include css File
        | ----------------------------------------------------------------------
        | URL of your css each array
        | $this->load_css[] = asset("myfile.css");
        |
        */
        $this->load_css = [];
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for button selected
    | ----------------------------------------------------------------------
    | @id_selected = the id selected
    | @button_name = the name of button
    |
    */
    public function actionButtonSelected($id_selected, $button_name)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate query of index result
    | ----------------------------------------------------------------------
    | @query = current sql query
    |
    */
    public function hook_query_index(&$query)
    {
        $query->where('status', 'pending');
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate row of index table html
    | ----------------------------------------------------------------------
    |
    */
    public function hook_row_index($column_index, &$column_value)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate data input before add data is execute
    | ----------------------------------------------------------------------
    | @arr
    |
    */
    public function hook_before_add(&$postdata)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after add public static function called
    | ----------------------------------------------------------------------
    | @id = last insert id
    |
    */
    public function hook_after_add($id)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate data input before update data is execute
    | ----------------------------------------------------------------------
    | @postdata = input post data
    | @id       = current id
    |
    */
    public function hook_before_edit(&$postdata, $id)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after edit public static function called
    | ----------------------------------------------------------------------
    | @id       = current id
    |
    */
    public function hook_after_edit($id)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command before delete public static function called
    | ----------------------------------------------------------------------
    | @id       = current id
    |
    */
    public function hook_before_delete($id)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after delete public static function called
    | ----------------------------------------------------------------------
    | @id       = current id
    |
    */
    public function hook_after_delete($id)
    {
        //Your code here
    }

    //By the way, you can still create your own method in here... :)
    public function getEdit($id)
    {
        //Create an Auth
        if (!CRUDBooster::isUpdate() && $this->global_privilege == false || $this->button_edit == false) {
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        }

        $order                = Order::with('details', 'details.product', 'details.product.cover', 'logs')->where('id', $id)->first();

        $data                 = [];
        $data['page_title']   = 'Manage Order';
        $data['order']        = $order;
        if ($order->midtrans) {
            $data['midtrans']     = json_decode($order->midtrans);
        }

        //Please use cbView method instead view method from laravel
        $this->cbView('vendor/crudbooster/order_management', $data);
    }

    public function postSaveOrder(Request $request)
    {
        $orderID     = $request->order_id;
        $statusID    = $request->status_id;

        $order       = Order::with('details')->find($orderID);

        if (!$order) {
            return response()->json(['status' => false, 'message' => 'No Order Data!']);
        }

        if ($request->no_resi) {
            $noresi        = $request->no_resi;
            $orderDate     = $request->delivery_date;
            $success       = $this->updateStatus($order, $statusID, $noresi, $orderDate);
        } else {
            $success    = $this->updateStatus($order, $statusID);
        }

        $logOrder   = $this->logOrder($order, $statusID);

        $logDesc = 'Update order # ' . $order->order_code;

        insertRhapsodieLog($logDesc, 'order', CRUDBooster::myId(), json_encode($request->all()));

        event(new Pending($order));

        if ($success) {
            Session::flash('message_type', 'success');
            Session::flash('message', 'Order Progress has been updated successfully');

            return response()->json(['status' => true, 'message' => 'Order Progress has been updated successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Order Progress Failed']);
        }
    }

    public function postCheckGosend(Request $request)
    {
        $ordercode     = $request->order_code;
        $track         = GosendTrack::where('order_code', $ordercode)->first();
        $order         = Order::where('order_code', $ordercode)->first();

        $gosend             = new GosendLib;
        $gosendTrack        = $gosend->checkStatus($order);
        $goData             = json_decode($gosendTrack);

        $track->order_code    = $ordercode;
        $track->data          = $gosendTrack;
        $track->status        = $goData->status;
        $track->gojek_code    = $goData->orderNo;
        $track->booking_id    = $goData->id;
        $track->save();
    }

    public function postBookGosend(Request $request)
    {
        $ordercode                  = $request->order_code;
        $order                      = Order::where('order_code', $ordercode)->first();
        $track                      = GosendTrack::where('order_code', $ordercode)->first();

        $gosend                     = new GosendLib;

        $gosendCancel                   = $gosend->cancel($order);
        if ($track) {
            $delete                         = $track->delete();
        }
        $gosendBook                     = $gosend->book($order);
        if (!empty($gosendBook)) {
            $gosendTrack                = $gosend->checkStatus($order);
            $goData                     = json_decode($gosendTrack);
            $order->gosend              = $gosendTrack;
            $order->save();

            $track                      = new GosendTrack;
            $track->order_code          = $ordercode;
            $track->data                = $gosendTrack;
            $track->status              = $goData->status;
            $track->gojek_code          = $goData->orderNo;
            $track->booking_id          = $goData->id;
            $track->save();
        }

        // if (!$track) {
        //     $gosendBook                 = $gosend->book($order);
        //     if (!empty($gosendBook)) {
        //         $gosendTrack                    = $gosend->checkStatus($order);

        //         $gosendCancel                   = $gosend->cancel($order);
        //         $goData                         = json_decode($gosendTrack);
        //         $order->gosend                  = $gosendTrack;
        //         $order->save();

        //         $track                          = new GosendTrack;
        //         $track->order_code              = $ordercode;
        //         $track->data                    = $gosendTrack;
        //         $track->status                  = $goData->status;
        //         $track->gojek_code              = $goData->orderNo;
        //         $track->booking_id              = $goData->id;
        //         $track->save();

        //         return response()->json(['status' => true, 'message' => $gosendBook]);
        //     }
        //     return response()->json(['status' => false, 'message' => 'Error Cannot Book Gosend']);
        // } else {
        //     $gosendTrack                = $gosend->checkStatus($order);
        //     if (!empty($gosendTrack)) {
        //         $gosendCancel                   = $gosend->cancel($order);
        //         $delete                         = $track->delete();
        //         $gosendBook                     = $gosend->book($order);
        //         if (!empty($gosendBook)) {
        //             $gosendTrack                = $gosend->checkStatus($order);
        //             $goData                     = json_decode($gosendTrack);
        //             $order->gosend              = $gosendTrack;
        //             $order->save();

        //             $track                      = new GosendTrack;
        //             $track->order_code          = $ordercode;
        //             $track->data                = $gosendTrack;
        //             $track->status              = $goData->status;
        //             $track->gojek_code          = $goData->orderNo;
        //             $track->booking_id          = $goData->id;
        //             $track->save();

        //             return response()->json(['status' => true, 'message' => $gosendBook]);
        //         }
        //         return response()->json(['status' => false, 'message' => 'Error Cannot Book Gosend']);
        //     }

        //     return response()->json(['status' => false, 'message' => 'Error Cannot Check Gosend Status']);
    }

    public function postCancelGosend(Request $request)
    {
        $ordercode                  = $request->order_code;
        $order                      = Order::where('order_code', $ordercode)->first();

        $gosend                     = new GosendLib;
        $gosendTrack                = $gosend->cancel($order);

        $track                      = GosendTrack::where('order_code', $ordercode)->first();
        $gosendTrack                = $gosend->checkStatus($order);
        $goData                     = json_decode($gosendTrack);

        $track->order_code          = $ordercode;
        $track->data                = $gosendTrack;
        $track->status              = $goData->status;
        $track->gojek_code          = $goData->orderNo;
        $track->booking_id          = $goData->id;
        $track->save();

        return response()->json(['status' => true, 'message' => $gosendTrack]);
    }

    private function updateStatus($order, $statusID, $noresi = false, $orderDate = false)
    {
        if ($statusID == 1) {
            $status                = 'paid';
            $order->payment_date   = Carbon::now();
            $order->payment_status = 1;

            if ($order->cart->courier_type_id == 'instant' || $order->cart->courier_type_id == 'sameday') {
                $track                          = GosendTrack::where('order_code', $order->order_code)->first();

                $gosend                         = new GosendLib;

                $gosendCancel                   = $gosend->cancel($order);
                if ($track) {
                    $delete                         = $track->delete();
                }
                $gosendBook                     = $gosend->book($order);
                if (!empty($gosendBook)) {
                    $gosendTrack                = $gosend->checkStatus($order);
                    $goData                     = json_decode($gosendTrack);
                    $order->gosend              = $gosendTrack;
                    $order->save();

                    $track                      = new GosendTrack;
                    $track->order_code          = $order->order_code;
                    $track->data                = $gosendTrack;
                    $track->status              = $goData->status;
                    $track->gojek_code          = $goData->orderNo;
                    $track->booking_id          = $goData->id;
                    $track->save();
                }
            }
        }
        if ($statusID == 2) {
            $status = 'sent';
            if ($noresi) {
                $order->no_resi       = $noresi;
                $order->delivery_date = Carbon::parse($orderDate);
            }
        }
        if ($statusID == 3) {
            $status = 'completed';

            $user = User::find($order->user_id);

            // IF FIRSTBUY AND HAVE UPLINE PROCESS
            $order->processUplineReward();

            if ($user->rewardPercentage()) {
                $total              = (int) ceil($order->grand_total / $user->rewardPercentage());

                $reward             = new UserReward;
                $reward->user_id    = $user->id;
                $reward->order_id   = $order->id;
                $reward->points     = $total;
                $reward->type       = 'in';
                $reward->note       = 'Puchase reward dari pembelian ' . $order->order_code;
                $reward->save();

                event(new Reward($reward));
            }

            if ($user->hasReferrer()) {
                $user->processReferrer($order);
            }
        }
        if ($statusID == 4) {
            $status = 'canceled';
        }

        $order->status = $status;
        $order->save();

        return true;
    }

    private function logOrder($order, $statusID)
    {
        //save log
        if ($statusID == 1) {
            $status = 'paid';
        }
        if ($statusID == 2) {
            $status = 'sent';
        }
        if ($statusID == 3) {
            $status = 'completed';
        }
        if ($statusID == 4) {
            $status = 'canceled';
        }

        $log                  = new OrderLog;
        $log->order_id        = $order->id;
        $log->status          = $status;
        $log->notes           = 'Admin update status to ' . ucwords($status) . ' via backend';
        $log->admin_id        = CRUDBooster::myName();
        $log->save();

        if ($log->id) {
            return true;
        } else {
            return false;
        }
    }

    public function getGenerateDelivery($id)
    {
        $order = Order::find($id);
        // if (!$order) {
        //     return back();
        // }

        // $name = 'Talasi - Delivery #' . $id . '.pdf';

        // $results = Order::where('id', $id)->first();

        // $this->data['order']    = $results;
        // $this->data['no']       = 1;
        // $pdf                    = \PDF::loadView('frontend.pdf.delivery_label', $this->data)->setPaper('A4', 'portrait');
        // return $pdf->stream();

        $this->data['order']    = $order;

        return view('frontend.pdf.delivery_label', $this->data);
    }

    public function getCheckOrder($id)
    {
        $order = Order::find($id);
		
        if ($order) {
            if ($order->multi !== 1) {
                if ($order->payment_method !== 'gopay') {
                    $paymentStatus  = new NicepayLib;
                    $paymentStatus  = $paymentStatus->checkTransaction($order);

                    if (isset($paymentStatus->status) && $paymentStatus->status == '0') {
                        if ($order->status == 'pending') {
                            $order->status         = 'paid';
                            $order->payment_date   = Carbon::parse($paymentStatus->transDt . $paymentStatus->transTm);
                            $order->payment_status = 1;
                            $order->save();
                            $order->refresh();

                            $this->setSoldProduct($order);
                            insertOrderLog($order, 'paid', 'backend');

                            event(new Pending($order));
                        }
                        CRUDBooster::redirect($_SERVER['HTTP_REFERER'], 'Payment status is PAID', 'success');
                    } else {
                        CRUDBooster::redirect($_SERVER['HTTP_REFERER'], 'Payment status is UNPAID', 'success');
                    }
                } else {
                    $vt          = new Veritrans;
                    $this->info($order);
                    $this->line('');

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
                                    CRUDBooster::redirect($_SERVER['HTTP_REFERER'], 'Payment status is UNPAID', 'success');
                                } else {
                                    if ($order->status == 'pending') {
                                        $order->setPaid();
                                        insertRhapsodieOrderLog($order, 'paid', 'backend');
                                        $order->payment_date       = Carbon::parse($notif->settlement_time)->format('Y-m-d H:i:s');
                                        $order->payment_status     = 1;
                                        $order->save();

                                        $this->setSoldProduct($order);
                                        $this->saveLog($order, 'paid');

                                        if ($order->cart->courier_type_id == 'instant' || $order->cart->courier_type_id == 'sameday') {
                                            $gosendBooking = $this->goBook($order);
                                        }
                                    }
                                    CRUDBooster::redirect($_SERVER['HTTP_REFERER'], 'Payment status is PAID', 'success');
                                }
                            }
                        } elseif ($transaction == 'settlement') {
                            if ($order->status == 'pending') {
                                $order->setPaid();
                                insertRhapsodieOrderLog($order, 'paid', 'backend');
                                $order->payment_date       = Carbon::parse($notif->settlement_time)->format('Y-m-d H:i:s');
                                $order->payment_status     = 1;
                                $order->save();

                                $this->setSoldProduct($order);
                                $this->saveLog($order, 'paid');

                                if ($order->cart->courier_type_id == 'instant' || $order->cart->courier_type_id == 'sameday') {
                                    $gosendBooking = $this->goBook($order);
                                }
                            }
                            CRUDBooster::redirect($_SERVER['HTTP_REFERER'], 'Payment status is PAID', 'success');
                        } elseif ($transaction == 'pending') {
                            CRUDBooster::redirect($_SERVER['HTTP_REFERER'], 'Payment status is UNPAID', 'success');
                        } elseif ($transaction == 'deny') {
                            CRUDBooster::redirect($_SERVER['HTTP_REFERER'], 'Payment status is UNPAID', 'success');
                        } elseif ($transaction == 'expire') {
                            CRUDBooster::redirect($_SERVER['HTTP_REFERER'], 'Payment status is UNPAID', 'success');
                        } elseif ($transaction == 'cancel') {
                            CRUDBooster::redirect($_SERVER['HTTP_REFERER'], 'Payment status is UNPAID', 'success');
                        }
                    }
                }
            } else {
                // MULTI
                if ($order->payment_method !== 'gopay') {
                    $paymentStatus  = new NicepayLib;
                    $paymentStatus  = $paymentStatus->checkMultiTransaction($order);

                    if (isset($paymentStatus->status) && $paymentStatus->status == '0') {
                        if ($order->status == 'pending') {
                            $order->status         = 'paid';
                            $order->payment_date   = Carbon::parse($paymentStatus->transDt . $paymentStatus->transTm);
                            $order->payment_status = 1;
                            $order->save();
                            $order->refresh();

                            $this->setSoldProduct($order);
                            insertOrderLog($order, 'paid', 'backend');

                            event(new Pending($order));
                        }
                        CRUDBooster::redirect($_SERVER['HTTP_REFERER'], 'Payment status is PAID', 'success');
                    } else {
                        CRUDBooster::redirect($_SERVER['HTTP_REFERER'], 'Payment status is UNPAID', 'success');
                    }
                } else {
                    $vt          = new Veritrans;
                    $this->info($order);
                    $this->line('');

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
                                    CRUDBooster::redirect($_SERVER['HTTP_REFERER'], 'Payment status is UNPAID', 'success');
                                } else {
                                    if ($order->status == 'pending') {
                                        $order->setPaid();
                                        insertRhapsodieOrderLog($order, 'paid', 'backend');
                                        $order->payment_date       = Carbon::parse($notif->settlement_time)->format('Y-m-d H:i:s');
                                        $order->payment_status     = 1;
                                        $order->save();

                                        $this->setSoldProduct($order);
                                        $this->saveLog($order, 'paid');

                                        if ($order->cart->courier_type_id == 'instant' || $order->cart->courier_type_id == 'sameday') {
                                            $gosendBooking = $this->goBook($order);
                                        }
                                    }
                                    CRUDBooster::redirect($_SERVER['HTTP_REFERER'], 'Payment status is PAID', 'success');
                                }
                            }
                        } elseif ($transaction == 'settlement') {
                            if ($order->status == 'pending') {
                                $order->setPaid();
                                insertRhapsodieOrderLog($order, 'paid', 'backend');
                                $order->payment_date       = Carbon::parse($notif->settlement_time)->format('Y-m-d H:i:s');
                                $order->payment_status     = 1;
                                $order->save();

                                $this->setSoldProduct($order);
                                $this->saveLog($order, 'paid');

                                if ($order->cart->courier_type_id == 'instant' || $order->cart->courier_type_id == 'sameday') {
                                    $gosendBooking = $this->goBook($order);
                                }
                            }
                            CRUDBooster::redirect($_SERVER['HTTP_REFERER'], 'Payment status is PAID', 'success');
                        } elseif ($transaction == 'pending') {
                            CRUDBooster::redirect($_SERVER['HTTP_REFERER'], 'Payment status is UNPAID', 'success');
                        } elseif ($transaction == 'deny') {
                            CRUDBooster::redirect($_SERVER['HTTP_REFERER'], 'Payment status is UNPAID', 'success');
                        } elseif ($transaction == 'expire') {
                            CRUDBooster::redirect($_SERVER['HTTP_REFERER'], 'Payment status is UNPAID', 'success');
                        } elseif ($transaction == 'cancel') {
                            CRUDBooster::redirect($_SERVER['HTTP_REFERER'], 'Payment status is UNPAID', 'success');
                        }
                    }
                }
            }
        }
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

    public function postPrintAddress(Request $request)
    {
        $order  = Order::find($request->id);
        $logo   = Config::where('name', 'company_logo_footer')->first();
        $detail = [
            'order' => $order->id,
            'logo'  => asset($logo->value)
        ];

        $load = 'print.address';
        $name = 'Talasi - #' . $order->order_code . '.pdf';

        $results = $request->result;

        $results = explode(',', $results);

        foreach ($results as $key => $result) {
            if ($result == 0) {
                continue;
            }
            $results[$key] = Order::where('id', $order->id)->first();
        }

        // $this->data['from'] = ContactLocationConfigModel::find(1);
        $this->data['products'] = $results;
        $this->data['logo']     = asset($logo->value);
        $pdf                    = \PDF::loadView('print.address', $this->data)->setPaper('A4', 'portrait');

        return $pdf->stream();
    }

    public static function getProducts($row)
    {
        $id            = $row->id;
        $product       = \App\OrderDetail::where('order_id', $id)->get();

        $data          = '';
        foreach ($product as $i=>$prod) {
            if ($i == 0) {
                $data .= $prod->product->full_name . ' , Qty: ' . $prod->quantity . ' , Price: ' . currency_format($prod->price);
            } else {
                $data .= ' | ' . $prod->product->full_name . ' , Qty: ' . $prod->quantity . ' , Price: ' . currency_format($prod->price);
            }
        }

        return $data;
    }
}
