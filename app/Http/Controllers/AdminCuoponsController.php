<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDetail;
use App\Product;
use DB;
use Excel;
use Illuminate\Http\Request;

class AdminCuoponsController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {
        // START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field         = 'name';
        $this->limit               = '20';
        $this->orderby             = 'id,desc';
        $this->global_privilege    = false;
        $this->button_table_action = true;
        $this->button_bulk_action  = true;
        $this->button_action_style = 'button_icon';
        $this->button_add          = true;
        $this->button_edit         = true;
        $this->button_delete       = true;
        $this->button_detail       = false;
        $this->button_show         = false;
        $this->button_filter       = true;
        $this->button_import       = false;
        $this->button_export       = false;
        $this->table               = 'cuopons';
        // END CONFIGURATION DO NOT REMOVE THIS LINE

        // START COLUMNS DO NOT REMOVE THIS LINE
        $this->col   = [];
        $this->col[] = ['label'=>'Images', 'name'=>'images', 'image'=>true];
        $this->col[] = ['label'=>'Name', 'name'=>'name'];
        $this->col[] = ['label'=>'Type', 'name'=>'type'];
        $this->col[] = ['label'=>'Amount', 'name'=>'amount', 'callback' => function($row){
            return currency_format($row->amount);
        }];
        $this->col[] = ['label'=>'Point', 'name'=>'points', 'callback' => function($row){
            return number_format($row->points);
        }];
        // END COLUMNS DO NOT REMOVE THIS LINE

        // START FORM DO NOT REMOVE THIS LINE
        $this->form   = [];
        $this->form[] = ['label'=>'Image', 'name'=>'images', 'type'=>'upload', 'validation'=>'required|image|max:1000', 'upload_encrypt' => 'true', 'width'=>'col-sm-10', 'help'=>'Best resolution: 500 x 1000px, Max file Size: 1 Mb'];
        $this->form[] = ['label'=>'Coupon Name', 'name'=>'name', 'type'=>'text', 'validation'=>'required|string|min:3|max:70', 'width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Coupon Title', 'name'=>'title', 'type'=>'text', 'validation'=>'', 'width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Description', 'name'=>'description', 'type'=>'wysiwyg', 'validation'=>'', 'width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Points Cost', 'name'=>'points', 'type'=>'number', 'validation'=>'required', 'width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Coupon Start Date', 'name'=>'start_date', 'type'=>'date', 'validation'=>'required', 'width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Coupon End Date', 'name'=>'end_date', 'type'=>'date', 'validation'=>'required', 'width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Type', 'name'=>'type', 'type'=>'select', 'validation'=>'required|min:1|max:255', 'width'=>'col-sm-10', 'dataenum'=>'manual|Manual Process;voucher|Voucher'];
        $this->form[] = ['label'=> 'Coupon Expired Duration', 'name'=>'duration', 'type'=>'number', 'validation'=>'', 'width'=>'col-sm-10',
            'help'              => 'Number of days'];
        $this->form[] = ['label'=>'Coupon Discount Amount', 'name'=>'amount', 'type'=>'number', 'validation'=>'', 'width'=>'col-sm-10', 'help' => 'Fill this field if coupon type is voucher'];
        $this->form[] = ['label' => 'Voucher Type', 'name' => 'voucher_type', 'type' => 'radio', 'validation' => '', 'width' => 'col-sm-5', 'dataenum' => 'total|Total Only;shipping|Shipping Only;payment_based|Payment Based'];
        $this->form[] =
                [
                    'label'     => 'Bank',
                    'type'      => 'select',
                    'name'      => 'bank',
                    'width'     => 'col-sm-5',
                    'dataenum'  => 'va_bca|VA BCA;cc_bca|Credit Card;va_mandiri|VA Mandiri;va_bni|VA BNI;va_permata|VA Permata;va_danamon|VA Danamon;va_cimb|VA CIMB;va_bri|VA BRI;va_maybank|VA Maybank;va_hana|VA Hanabank;gopay|GOPAY',
                    'help'      => 'Fill this field if coupon type is payment based voucher'
                ];
        $this->form[] = ['label'=>'Min. Transaction Amount', 'name'=>'min_purchase', 'type'=>'number', 'validation'=>'', 'width'=>'col-sm-10', 'help' => 'Fill this field if coupon type is voucher'];
        // END FORM DO NOT REMOVE THIS LINE

        // OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"Name","name"=>"name","type"=>"text","required"=>TRUE,"validation"=>"required|string|min:3|max:70","placeholder"=>"You can only enter the letter only"];
        //$this->form[] = ["label"=>"Type","name"=>"type","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Amount","name"=>"amount","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Images","name"=>"images","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
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
        $this->script_js = "

			function checkRadio() {
				if ($('#type').val() == 'voucher') {
					$('#form-group-amount').show();
					$('#form-group-voucher_type').show();
					$('#form-group-min_purchase').show();
					$('#form-group-unit').show();
					$('#form-group-duration').show();
				} else {
					$('#form-group-amount').hide();
					$('#form-group-voucher_type').hide();
					$('#form-group-min_purchase').hide();
					$('#form-group-unit').hide();
					$('#form-group-duration').hide();
				}
			}

			function checkPayment() {
				if ($('input[value=payment_based]:checked').length > 0) {
					$('#form-group-bank').show();
				} else {
					$('#form-group-bank').hide();
				}
			}

			$(document).ready(function(){
				checkRadio();
				checkPayment();

				$('#type').change(function(){
					if($(this).val() == 'voucher'){
						$('#form-group-amount').show();
						$('#form-group-voucher_type').show();
						$('#form-group-min_purchase').show();
						$('#form-group-unit').show();
						$('#form-group-duration').show();
					} else {
						$('#form-group-amount').hide();
						$('#form-group-voucher_type').hide();
						$('#form-group-min_purchase').hide();
						$('#form-group-unit').hide();
						$('#form-group-duration').hide();
					}
				});

				$('input[name=voucher_type]').change(function(){
					if ($('input[value=payment_based]:checked').length > 0) {
						$('#form-group-bank').show();
					} else {
						$('#form-group-bank').hide();
					}
				});
			});";

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
        //Your code here
		$query->where('is_referral', 0);
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

    public function postExportTopSelling(Request $request)
    {
        $topProducts = OrderDetail::with('product')
            ->whereHas('order', function ($query) {
                $query->whereIn('status', ['paid', 'sent', 'completed']);
            })
            ->select('product_id', DB::raw('COUNT(product_id) as count'), DB::raw('sum(price * quantity) as total_order'))
            ->whereDate('created_at', '>=', $request->start)
            ->whereDate('created_at', '<=', $request->end)
            ->groupBy('product_id')
            ->orderBy('total_order', 'desc')
            ->take(10)->get();

        $this->data['datas'] = $topProducts;
        $this->data['no']    = 1;

        $excel = Excel::create('top_selling_' . date('Y-m-d-his'), function ($excel) {
            $excel->sheet('sheet1', function ($sheet) {
                $sheet->loadView('export.top_selling', $this->data);
            });
        })->store('xlsx', public_path('excel/export'), true);

        return response()->json([
            'url' => url('excel/export/' . $excel['file'])
        ]);
    }

    public function postExportTopCustomer(Request $request)
    {
        $topTenCust     = Order::with('user')
                            ->select('user_id', DB::raw('COUNT(user_id) as count'), DB::raw('sum(grand_total) as total_order'))
                            ->whereIn('status', ['paid', 'sent', 'completed'])
                            ->whereDate('created_at', '>=', $request->start)
                            ->whereDate('created_at', '<=', $request->end)
                            ->groupBy('user_id')
                            ->orderBy('total_order', 'desc')
                            ->take(10)->get();

        $this->data['datas'] = $topTenCust;
        $this->data['no']    = 1;

        $excel = Excel::create('top_customer_' . date('Y-m-d-his'), function ($excel) {
            $excel->sheet('sheet1', function ($sheet) {
                $sheet->loadView('export.top_customer', $this->data);
            });
        })->store('xlsx', public_path('excel/export'), true);

        return response()->json([
            'url' => url('excel/export/' . $excel['file'])
        ]);
    }

    public function postExportTopView(Request $request)
    {
        $topViewProduct = Product::orderBy('view', 'DESC')
                            ->take(10)->get();

        $this->data['datas'] = $topViewProduct;
        $this->data['no']    = 1;

        $excel = Excel::create('top_product_view_' . date('Y-m-d-his'), function ($excel) {
            $excel->sheet('sheet1', function ($sheet) {
                $sheet->loadView('export.top_view', $this->data);
            });
        })->store('xlsx', public_path('excel/export'), true);

        return response()->json([
            'url' => url('excel/export/' . $excel['file'])
        ]);
    }
}
