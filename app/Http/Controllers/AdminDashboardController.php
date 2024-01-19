<?php

namespace App\Http\Controllers;

use Analytics;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Analytics\Period;

class AdminDashboardController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {
        // START CONFIGURATION DO NOT REMOVE THIS LINE
        $title_field         = 'id';
        $limit               = '20';
        $orderby             = 'id,desc';
        $global_privilege    = false;
        $button_table_action = false;
        $button_bulk_action  = false;
        $button_action_style = 'button_icon';
        $button_add          = false;
        $button_edit         = false;
        $button_delete       = false;
        $button_detail       = false;
        $button_show         = false;
        $button_filter       = false;
        $button_import       = false;
        $button_export       = false;
        $table               = 'orders';
        // END CONFIGURATION DO NOT REMOVE THIS LINE

        // START COLUMNS DO NOT REMOVE THIS LINE
        $col   = [];
        $col[] = ['label'=>'Order Code', 'name'=>'order_code'];
        $col[] = ['label'=>'User Id', 'name'=>'user_id', 'join'=>'users,name'];
        $col[] = ['label'=>'Status', 'name'=>'status'];
        $col[] = ['label'=>'Payment Method', 'name'=>'payment_method'];
        $col[] = ['label'=>'Payment Date', 'name'=>'payment_date'];
        $col[] = ['label'=>'Payment Status', 'name'=>'payment_status'];
        // END COLUMNS DO NOT REMOVE THIS LINE

        // START FORM DO NOT REMOVE THIS LINE
        $form   = [];
        $form[] = ['label'=>'Order Code', 'name'=>'order_code', 'type'=>'text', 'validation'=>'required|min:1|max:255', 'width'=>'col-sm-10'];
        $form[] = ['label'=>'User Id', 'name'=>'user_id', 'type'=>'select2', 'validation'=>'required|integer|min:0', 'width'=>'col-sm-10', 'datatable'=>'user,id'];
        $form[] = ['label'=>'Cart Id', 'name'=>'cart_id', 'type'=>'select2', 'validation'=>'required|integer|min:0', 'width'=>'col-sm-10', 'datatable'=>'cart,id'];
        $form[] = ['label'=>'Status', 'name'=>'status', 'type'=>'text', 'validation'=>'required|min:1|max:255', 'width'=>'col-sm-10'];
        $form[] = ['label'=>'Payment Method', 'name'=>'payment_method', 'type'=>'text', 'validation'=>'required|min:1|max:255', 'width'=>'col-sm-10'];
        $form[] = ['label'=>'Payment Date', 'name'=>'payment_date', 'type'=>'datetime', 'validation'=>'required|date_format:Y-m-d H:i:s', 'width'=>'col-sm-10'];
        $form[] = ['label'=>'Payment Status', 'name'=>'payment_status', 'type'=>'number', 'validation'=>'required|integer|min:0', 'width'=>'col-sm-10'];
        $form[] = ['label'=>'Subtotal', 'name'=>'subtotal', 'type'=>'text', 'validation'=>'required|min:1|max:255', 'width'=>'col-sm-10'];
        $form[] = ['label'=>'Total Weight', 'name'=>'total_weight', 'type'=>'number', 'validation'=>'required|integer|min:0', 'width'=>'col-sm-10'];
        $form[] = ['label'=>'Total Shipping Cost', 'name'=>'total_shipping_cost', 'type'=>'number', 'validation'=>'required|integer|min:0', 'width'=>'col-sm-10'];
        $form[] = ['label'=>'Grand Total', 'name'=>'grand_total', 'type'=>'number', 'validation'=>'required|integer|min:0', 'width'=>'col-sm-10'];
        $form[] = ['label'=>'Notes', 'name'=>'notes', 'type'=>'textarea', 'validation'=>'required|string|min:5|max:5000', 'width'=>'col-sm-10'];
        $form[] = ['label'=>'Voucher Id', 'name'=>'voucher_id', 'type'=>'select2', 'validation'=>'required|integer|min:0', 'width'=>'col-sm-10', 'datatable'=>'voucher,id'];
        $form[] = ['label'=>'Voucher Code', 'name'=>'voucher_code', 'type'=>'text', 'validation'=>'required|min:1|max:255', 'width'=>'col-sm-10'];
        $form[] = ['label'=>'Voucher Value', 'name'=>'voucher_value', 'type'=>'number', 'validation'=>'required|integer|min:0', 'width'=>'col-sm-10'];
        $form[] = ['label'=>'Voucher Unit', 'name'=>'voucher_unit', 'type'=>'text', 'validation'=>'required|min:1|max:255', 'width'=>'col-sm-10'];
        $form[] = ['label'=>'Voucher Type', 'name'=>'voucher_type', 'type'=>'text', 'validation'=>'required|min:1|max:255', 'width'=>'col-sm-10'];
        $form[] = ['label'=>'Midtrans', 'name'=>'midtrans', 'type'=>'textarea', 'validation'=>'required|string|min:5|max:5000', 'width'=>'col-sm-10'];
        $form[] = ['label'=>'No Resi', 'name'=>'no_resi', 'type'=>'text', 'validation'=>'required|min:1|max:255', 'width'=>'col-sm-10'];
        $form[] = ['label'=>'Delivery Date', 'name'=>'delivery_date', 'type'=>'datetime', 'validation'=>'required|date_format:Y-m-d H:i:s', 'width'=>'col-sm-10'];
        // END FORM DO NOT REMOVE THIS LINE

        // OLD START FORM
        //$form = [];
        //$form[] = ["label"=>"Order Code","name"=>"order_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$form[] = ["label"=>"User Id","name"=>"user_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"user,id"];
        //$form[] = ["label"=>"Cart Id","name"=>"cart_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"cart,id"];
        //$form[] = ["label"=>"Status","name"=>"status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$form[] = ["label"=>"Payment Method","name"=>"payment_method","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$form[] = ["label"=>"Payment Date","name"=>"payment_date","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
        //$form[] = ["label"=>"Payment Status","name"=>"payment_status","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$form[] = ["label"=>"Subtotal","name"=>"subtotal","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$form[] = ["label"=>"Total Weight","name"=>"total_weight","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$form[] = ["label"=>"Total Shipping Cost","name"=>"total_shipping_cost","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$form[] = ["label"=>"Grand Total","name"=>"grand_total","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$form[] = ["label"=>"Notes","name"=>"notes","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
        //$form[] = ["label"=>"Voucher Id","name"=>"voucher_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"voucher,id"];
        //$form[] = ["label"=>"Voucher Code","name"=>"voucher_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$form[] = ["label"=>"Voucher Value","name"=>"voucher_value","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$form[] = ["label"=>"Voucher Unit","name"=>"voucher_unit","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$form[] = ["label"=>"Voucher Type","name"=>"voucher_type","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$form[] = ["label"=>"Midtrans","name"=>"midtrans","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
        //$form[] = ["label"=>"No Resi","name"=>"no_resi","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$form[] = ["label"=>"Delivery Date","name"=>"delivery_date","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
        // OLD END FORM

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
        $sub_module = [];

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
        $addaction = [];

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
        $button_selected = [];

        /*
        | ----------------------------------------------------------------------
        | Add alert message to this module at overheader
        | ----------------------------------------------------------------------
        | @message = Text of message
        | @type    = warning,success,danger,info
        |
        */
        $alert        = [];

        /*
        | ----------------------------------------------------------------------
        | Add more button to header button
        | ----------------------------------------------------------------------
        | @label = Name of button
        | @url   = URL Target
        | @icon  = Icon from Awesome.
        |
        */
        $index_button = [];

        /*
        | ----------------------------------------------------------------------
        | Customize Table Row Color
        | ----------------------------------------------------------------------
        | @condition = If condition. You may use field alias. E.g : [id] == 1
        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.
        |
        */
        $table_row_color = [];

        /*
        | ----------------------------------------------------------------------
        | You may use this bellow array to add statistic at dashboard
        | ----------------------------------------------------------------------
        | @label, @count, @icon, @color
        |
        */
        $index_statistic = [];

        /*
        | ----------------------------------------------------------------------
        | Add javascript at body
        | ----------------------------------------------------------------------
        | javascript code in the variable
        | $script_js = "function() { ... }";
        |
        */
        $script_js = null;

        /*
        | ----------------------------------------------------------------------
        | Include HTML Code before index table
        | ----------------------------------------------------------------------
        | html code to display it before index table
        | $pre_index_html = "<p>test</p>";
        |
        */
        $pre_index_html = null;

        /*
        | ----------------------------------------------------------------------
        | Include HTML Code after index table
        | ----------------------------------------------------------------------
        | html code to display it after index table
        | $post_index_html = "<p>test</p>";
        |
        */
        $post_index_html = null;

        /*
        | ----------------------------------------------------------------------
        | Include Javascript File
        | ----------------------------------------------------------------------
        | URL of your javascript each array
        | $load_js[] = asset("myfile.js");
        |
        */
        $load_js = [];

        /*
        | ----------------------------------------------------------------------
        | Add css style at body
        | ----------------------------------------------------------------------
        | css code in the variable
        | $style_css = ".style{....}";
        |
        */
        $style_css = null;

        /*
        | ----------------------------------------------------------------------
        | Include css File
        | ----------------------------------------------------------------------
        | URL of your css each array
        | $load_css[] = asset("myfile.css");
        |
        */
        $load_css = [];
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
        //Your code here
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

    public function getIndex(Request $request)
    {
        $reqDs       = $request->ds;
        $reqDe       = $request->de;

        if ($reqDs && $reqDe) {
            $dateStart = Carbon::createFromFormat('Y-m-d', $reqDs);
            $dateEnd   = Carbon::createFromFormat('Y-m-d', $reqDe);
        } else {
            $dateStart   = new Carbon('first day of this month');
            $dateEnd     = Carbon::now();
        }

        $data['date_start']   = $dateStart;
        $data['date_end']     = $dateEnd;

        $this->getSummary($dateStart, $dateEnd);

        $data                     = [];
        $data                     = $this->getSummary($dateStart, $dateEnd);
        $data['date_start']       = $dateStart;
        $data['date_end']         = $dateEnd;
        $data['page_title']       = 'Products Data';
        $data['result']           = DB::table('products')->orderby('id', 'desc')->paginate(10);

        $this->cbView('vendor/crudbooster/dashboard', $data);
    }

    private function getSummary($dateStart, $dateEnd)
    {
        $totalUser      = User::whereDate('created_at', '>=', $dateStart)
                        ->whereDate('created_at', '<=', $dateEnd)->count();

        $totalSales     = Order::whereIn('status', ['paid', 'sent', 'completed'])
                        ->whereDate('created_at', '>=', $dateStart)
                        ->whereDate('created_at', '<=', $dateEnd)->sum('grand_total');

        $totalOrder     = Order::whereDate('created_at', '>=', $dateStart)
                        ->whereDate('created_at', '<=', $dateEnd)->count();

        $successOrder   = Order::whereIn('status', ['paid', 'sent', 'completed'])
                        ->whereDate('created_at', '>=', $dateStart)
                        ->whereDate('created_at', '<=', $dateEnd)->count();

        $waitingOrder   = Order::where('status', 'pending')
                        ->whereDate('created_at', '>=', $dateStart)
                        ->whereDate('created_at', '<=', $dateEnd)->count();

        $paymentOrder   = Order::where('status', 'paid')
                        ->whereDate('created_at', '>=', $dateStart)
                        ->whereDate('created_at', '<=', $dateEnd)->count();

        $failedOrder    = Order::where('status', 'failed')
                        ->whereDate('created_at', '>=', $dateStart)
                        ->whereDate('created_at', '<=', $dateEnd)->count();

        $shippedOrder   = Order::where('status', 'sent')
                        ->whereDate('created_at', '>=', $dateStart)
                        ->whereDate('created_at', '<=', $dateEnd)->count();

        $completedOrder = Order::where('status', 'completed')
                        ->whereDate('created_at', '>=', $dateStart)
                        ->whereDate('created_at', '<=', $dateEnd)->count();

        $topViewProduct = Product::orderBy('view', 'DESC')
                        ->take(10)->get();

        $topProducts = OrderDetail::with('product')
        ->whereHas('order', function ($query) {
            $query->whereIn('status', ['paid', 'sent', 'completed']);
        })
        ->select('product_id', DB::raw('COUNT(product_id) as count'), DB::raw('sum(price * quantity) as total_order'))
        ->whereDate('created_at', '>=', $dateStart)
        ->whereDate('created_at', '<=', $dateEnd)
        ->groupBy('product_id')
        ->orderBy('total_order', 'desc')
        ->take(10)->get();

        $topTenCust     = Order::with('user')
                        ->select('user_id', DB::raw('COUNT(user_id) as count'), DB::raw('sum(grand_total) as total_order'))
                        ->whereIn('status', ['paid', 'sent', 'completed'])
                        ->whereDate('created_at', '>=', $dateStart)
                        ->whereDate('created_at', '<=', $dateEnd)
                        ->groupBy('user_id')
                        ->orderBy('total_order', 'desc')
                        ->take(10)->get();

        // $topTenCity     = Order::with('cart', 'cart.address')
        //                 ->select('cart.address', DB::raw('COUNT(user_id) as count'), DB::raw('sum(grand_total) as total_order'))
        //                 ->whereIn('status', ['paid', 'sent', 'completed'])
        //                 ->whereDate('created_at', '>=', $dateStart)
        //                 ->whereDate('created_at', '<=', $dateEnd)
        //                 ->groupBy('user_id')
        //                 ->orderBy('total_order', 'desc')
        //                 ->take(10)->get();

        $totalDays      = $dateStart->diffInDays($dateEnd);
        $totalDays += 1;

        $salesData      = [];
        $salesValue     = [];
        $salesLabel     = [];

        $graphStart     = $dateStart->copy();
        $graphEnd       = $dateEnd->copy();

        if ($totalDays > 31) {
            $totalMonth = ceil($totalDays / 30);
            if ($totalMonth > 12) {//call group by year
                $saleDetail     = DB::table('orders')
                ->select(
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('SUM(grand_total) as total'),
                    DB::raw('COUNT(*) AS counter')
                )
                ->whereDate('created_at', '>=', $dateStart)
                ->whereDate('created_at', '<=', $dateEnd)
                ->whereIn('status', ['paid', 'sent', 'completed'])
                ->groupBy(DB::raw('YEAR(created_at)'))
                ->get();

                $graphStart     = $graphStart->startOfYear();
                $graphEnd       = $graphEnd->startOfYear();

                if (count($saleDetail)) {
                    $lastCounter         = count($saleDetail) - 1;
                    // dd($saleDetail[0]);
                    $graphYearDataStart  = Carbon::createFromFormat('Y', $saleDetail[0]->year)->startOfYear();
                    $graphYearDataEnd    = Carbon::createFromFormat('Y', $saleDetail[$lastCounter]->year)->startOfYear();

                    for (; $graphStart->diffInYears($graphYearDataStart, false) > 0; $graphStart->addYear()) {
                        array_push($salesLabel, $graphStart->format('Y'));
                        array_push($salesData, 0);
                        array_push($salesValue, 0);
                    }

                    foreach ($saleDetail as $index => $detail) {
                        $saleDateStart = Carbon::createFromFormat('Y', $detail->year);

                        array_push($salesLabel, $saleDateStart->format('Y'));
                        array_push($salesData, $detail->counter);
                        array_push($salesValue, $detail->total);

                        if ($index < (count($saleDetail) - 1)) {
                            $nextIndex   = $index + 1;
                            $saleDateEnd = Carbon::createFromFormat('Y', $saleDetail[$nextIndex]->year);

                            $saleDateStart->addMonth();
                            for (; $saleDateStart->diffInYears($saleDateEnd, false) > 0; $saleDateStart->addMonth()) {
                                array_push($salesLabel, $saleDateStart->format('M Y'));
                                array_push($salesData, 0);
                                array_push($salesValue, 0);
                            }
                        }
                    }
                    $graphYearDataEnd->addYear();
                    for (; $graphYearDataEnd->diffInYears($graphEnd, false) >= 0; $graphYearDataEnd->addYear()) {
                        array_push($salesLabel, $graphYearDataEnd->format('Y'));
                        array_push($salesData, 0);
                        array_push($salesValue, 0);
                    }
                } else {
                    for (; $graphStart->diffInYears($graphEnd, false) >= 0; $graphStart->addYear()) {
                        array_push($salesLabel, $graphStart->format('Y'));
                        array_push($salesData, 0);
                        array_push($salesValue, 0);
                    }
                }
            } else {//call group by month
                $saleDetail     = DB::table('orders')
                ->select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('SUM(grand_total) as total'),
                    DB::raw('COUNT(*) AS counter')
                )
                ->whereDate('created_at', '>=', $dateStart)
                ->whereDate('created_at', '<=', $dateEnd)
                ->whereIn('status', ['paid', 'sent', 'completed'])
                ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                ->get();
                $graphStart = $graphStart->startOfMonth();
                $graphEnd   = $graphEnd->endOfMonth();

                if (count($saleDetail)) {
                    $lastCounter            = count($saleDetail) - 1;
                    $graphMonthDataStart    = Carbon::createFromFormat('Y-m', $saleDetail[0]->year . '-' . $saleDetail[0]->month);
                    $graphMonthDataEnd      = Carbon::createFromFormat('Y-m', $saleDetail[$lastCounter]->year . '-' . $saleDetail[$lastCounter]->month);

                    for (; $graphStart->diffInMonths($graphMonthDataStart, false) > 0; $graphStart->addMonth()) {
                        array_push($salesLabel, $graphStart->format('M Y'));
                        array_push($salesData, 0);
                        array_push($salesValue, 0);
                    }

                    foreach ($saleDetail as $index => $detail) {
                        $saleDateStart = Carbon::createFromFormat('Y-m', $detail->year . '-' . $detail->month);

                        array_push($salesLabel, $saleDateStart->format('M Y'));
                        array_push($salesData, $detail->counter);
                        array_push($salesValue, $detail->total);

                        if ($index < (count($saleDetail) - 1)) {
                            $nextIndex   = $index + 1;
                            $saleDateEnd = Carbon::createFromFormat('Y-m', $saleDetail[$nextIndex]->year . '-' . $saleDetail[$nextIndex]->month);

                            $saleDateStart->addMonth();
                            for (; $saleDateStart->diffInMonths($saleDateEnd, false) > 0; $saleDateStart->addMonth()) {
                                array_push($salesLabel, $saleDateStart->format('M Y'));
                                array_push($salesData, 0);
                                array_push($salesValue, 0);
                            }
                        }
                    }
                    $graphMonthDataEnd->addMonth();
                    $graphMonthDataEnd	= $graphMonthDataEnd->endOfMonth();
                    for (; $graphMonthDataEnd->diffInMonths($graphEnd, false) >= 0; $graphMonthDataEnd->addMonth()) {
                        array_push($salesLabel, $graphMonthDataEnd->format('M Y'));
                        array_push($salesData, 0);
                        array_push($salesValue, 0);
                    }
                } else {
                    for (; $graphStart->diffInMonths($graphEnd, false) >= 0; $graphStart->addMonth()) {
                        array_push($salesLabel, $graphStart->format('M Y'));
                        array_push($salesData, 0);
                        array_push($salesValue, 0);
                    }
                }
            }
        } else {//call group by day
            $saleDetail     = DB::table('orders')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(grand_total) as total'),
                DB::raw('COUNT(*) AS counter')
            )
            ->whereDate('created_at', '>=', $dateStart)
            ->whereDate('created_at', '<=', $dateEnd)
            ->whereIn('status', ['paid', 'sent', 'completed'])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();
            // dd($saleDetail);

            $graphStart = $graphStart->startOfDay();
            $graphEnd   = $graphEnd->startOfDay();

            if (count($saleDetail)) {
                $lastCounter    = count($saleDetail) - 1;
                $graphDataStart = Carbon::parse($saleDetail[0]->date)->startOfDay();
                $graphDataEnd   = Carbon::parse($saleDetail[$lastCounter]->date)->startOfDay();

                // dd($saleDetail);

                for (; $graphStart->diffInDays($graphDataStart, false) > 0; $graphStart->addDay()) {
                    array_push($salesLabel, $graphStart->format('d/m'));
                    array_push($salesData, 0);
                    array_push($salesValue, 0);
                }

                foreach ($saleDetail as $index => $detail) {
                    $date = Carbon::parse($detail->date);
                    array_push($salesLabel, $date->format('d/m'));
                    array_push($salesData, $detail->counter);
                    array_push($salesValue, $detail->total);

                    if ($index < (count($saleDetail) - 1)) {
                        $nextIndex = $index + 1;
                        $nextData  = Carbon::parse($saleDetail[$nextIndex]->date);

                        $date->addMonth();
                        for (; $date->diffInMonths($nextData, false) > 0; $date->addDay()) {
                            array_push($salesLabel, $date->format('d/m'));
                            array_push($salesData, 0);
                            array_push($salesValue, 0);
                        }
                    }
                }

                $graphDataEnd->addDay();
                for (; $graphDataEnd->diffInDays($graphEnd, false) >= 0; $graphDataEnd->addDay()) {
                    array_push($salesLabel, $graphDataEnd->format('d/m'));
                    array_push($salesData, 0);
                    array_push($salesValue, 0);
                }
            } else {
                for (; $graphStart->diffInDays($graphEnd, false) >= 0; $graphStart->addDay()) {
                    array_push($salesLabel, $graphStart->format('d/m'));
                    array_push($salesData, 0);
                    array_push($salesValue, 0);
                }
            }
        }

        $periode = Period::create($dateStart, $dateEnd);

        $analyticsData        = Analytics::fetchVisitorsAndPageViews($periode);
        $analyticVisitor      = [];
        $analyticViews        = [];
        $analyticLabel        = [];

        foreach ($analyticsData as $analytic) {
            array_push($analyticLabel, $analytic['date']->format('d/m'));
            array_push($analyticVisitor, $analytic['visitors']);
            array_push($analyticViews, $analytic['pageViews']);
        }

        // dd($analyticsData);

        $data['total_user']           = $totalUser;
        $data['total_sales']          = $totalSales;
        $data['total_order']          = $totalOrder;

        $data['analytic_label']       = json_encode($analyticLabel);
        $data['analytic_visitors']    = json_encode($analyticVisitor);
        $data['analytic_views']       = json_encode($analyticViews);

        $data['sales_value']          = json_encode($salesValue);
        $data['sales_label']          = json_encode($salesLabel);
        $data['sales_data']           = json_encode($salesData);

        $data['total_order_failed']    = $failedOrder;
        $data['total_order_waiting']   = $waitingOrder;
        $data['total_order_confirm']   = $confirmOrder;
        $data['total_order_payment']   = $paymentOrder;
        $data['total_order_process']   = $processOrder;
        $data['total_order_shipped']   = $shippedOrder;
        $data['total_order_complete']  = $completedOrder;
        $data['total_order_success']   = $successOrder;
        $data['top_customer']          = $topTenCust;
        $data['top_products']          = $topProducts;
        $data['top_product']           = $topViewProduct;
        return $data;
    }
}
