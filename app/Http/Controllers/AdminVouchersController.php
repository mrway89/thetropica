<?php

namespace App\Http\Controllers;

use App\Voucher;
use CRUDBooster;

class AdminVouchersController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {
        // START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table               = 'vouchers';
        $this->title_field         = 'id';
        $this->limit               = 20;
        $this->orderby             = 'id,desc';
        $this->show_numbering      = false;
        $this->global_privilege    = false;
        $this->button_table_action = true;
        $this->button_action_style = 'button_icon';
        $this->button_add          = true;
        $this->button_delete       = true;
        $this->button_edit         = true;
        $this->button_detail       = true;
        $this->button_show         = false;
        $this->button_filter       = true;
        $this->button_export       = true;
        $this->button_import       = false;
        $this->button_bulk_action  = true;
        $this->sidebar_mode        = 'normal'; //normal,mini,collapse,collapse-mini
        // END CONFIGURATION DO NOT REMOVE THIS LINE

        // START COLUMNS DO NOT REMOVE THIS LINE
        $this->col   = [];
        $this->col[] = ['label' => 'Start Date', 'name' => 'start_date'];
        $this->col[] = ['label' => 'End Date', 'name' => 'end_date'];
        $this->col[] = ['label' => 'Code', 'name' => 'code'];
        $this->col[] = ['label' => 'Type', 'name' => 'type'];
        $this->col[] = ['label' => 'Limit Per User', 'name' => 'limit_per_user'];
        $this->col[] = ['label' => 'Quota', 'name' => 'quota'];
        $this->col[] = ['label' => 'Discount', 'name' => 'discount'];
        $this->col[] = ['label' => 'Unit', 'name' => 'Unit'];
        $this->col[] = ['label' => 'Min Amount', 'name' => 'min_amount', 'callback' => function ($row) {
            return currency_format($row->min_amount);
        }];
        // END COLUMNS DO NOT REMOVE THIS LINE

        // START FORM DO NOT REMOVE THIS LINE
        $this->form   = [];
        $this->form[] = ['label' => 'Type', 'name' => 'type', 'type' => 'radio', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-5', 'dataenum' => 'total|Total Only;shipping|Shipping Only;payment_based|Payment Based'];
        $this->form[] =
            [
                'label'     => 'Bank',
                'type'      => 'select',
                'name'      => 'bank',
                'width'     => 'col-sm-5',
                'dataenum'  => 'va_bca|VA BCA;cc_bca|Credit Card;va_mandiri|VA Mandiri;va_bni|VA BNI;va_permata|VA Permata;va_danamon|VA Danamon;va_cimb|VA CIMB;va_bri|VA BRI;va_maybank|VA Maybank;va_hana|VA Hanabank;gopay|GOPAY'
            ];
        $this->form[] = ['label' => 'Start Date', 'name' => 'start_date', 'type' => 'date', 'validation' => 'required|date', 'width' => 'col-sm-5'];
        $this->form[] = ['label' => 'End Date', 'name' => 'end_date', 'type' => 'date', 'validation' => 'required|date', 'width' => 'col-sm-5'];
        $this->form[] = ['label' => 'Code', 'name' => 'code', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-5'];
        $this->form[] = ['label' => 'Limit Per User', 'name' => 'limit_per_user', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-5'];
        $this->form[] = ['label' => 'Quota', 'name' => 'quota', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-5'];
        $this->form[] = ['label' => 'Unit', 'name' => 'unit', 'type' => 'radio', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-5', 'dataenum' => 'percentage|Percentage;amount|Amount'];
        $this->form[] = ['label' => 'Discount', 'name' => 'discount', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-5'];
        $this->form[] = ['label' => 'Min. Transaction Amount', 'name' => 'min_amount', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-5'];
        // END FORM DO NOT REMOVE THIS LINE

        // OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"Start Date","name"=>"start_date","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
        //$this->form[] = ["label"=>"End Date","name"=>"end_date","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
        //$this->form[] = ["label"=>"Code","name"=>"code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Limit Per User","name"=>"limit_per_user","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Quota","name"=>"quota","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Discount","name"=>"discount","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Min Amount","name"=>"min_amount","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Type","name"=>"type","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Unit","name"=>"unit","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
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
        $this->index_button   = [];
        $this->index_button[] = ['label' => 'Mass Voucher Generator', 'icon' => 'fa fa-ticket', 'color' => 'danger', 'url' => CRUDBooster::adminPath() . '/mass_voucher_generator'];

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
            if ($('input[value=payment_based]:checked').length > 0) {
                $('#form-group-bank').show();
            }
        }

        $(document).ready(function(){
            checkRadio();

            $('input[name=type]').change(function(){
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
        $this->style_css = '
            #form-group-bank {
                display: none;
            }
        ';

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
        $voucher      = Voucher::findOrFail($id);
        $logDesc      = 'Add new voucher ' . $voucher->code;
        insertRhapsodieLog($logDesc, 'voucher', CRUDBooster::myId(), $voucher->code);
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
        $voucher      = Voucher::findOrFail($id);
        $logDesc      = 'Edit voucher ' . $voucher->code;
        insertRhapsodieLog($logDesc, 'voucher', CRUDBooster::myId(), json_encode($postdata));
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
        // $voucher      = Voucher::findOrFail($id);
        // $logDesc      = 'Delete voucher ' . $voucher->code;
        // insertRhapsodieLog($logDesc, 'voucher', CRUDBooster::myId(), $voucher->code);
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
}
