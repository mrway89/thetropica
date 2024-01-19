<?php

namespace App\Http\Controllers;

use App\Voucher;
use CRUDBooster;
use Excel;
use Illuminate\Http\Request;
use Validator;

class AdminMassVoucherGeneratorController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {
        // START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field         = 'id';
        $this->limit               = '20';
        $this->orderby             = 'id,desc';
        $this->global_privilege    = false;
        $this->button_table_action = false;
        $this->button_bulk_action  = false;
        $this->button_action_style = 'button_icon';
        $this->button_add          = false;
        $this->button_edit         = false;
        $this->button_delete       = false;
        $this->button_detail       = false;
        $this->button_show         = false;
        $this->button_filter       = false;
        $this->button_import       = false;
        $this->button_export       = false;
        $this->table               = 'vouchers';
        // END CONFIGURATION DO NOT REMOVE THIS LINE

        // START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];

        // END COLUMNS DO NOT REMOVE THIS LINE

        // START FORM DO NOT REMOVE THIS LINE
        $this->form = [];

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
        $this->alert = [];

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

    public function getIndex()
    {
        if (!CRUDBooster::isCreate() && $this->global_privilege == false) {
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        }
        $data               = [];
        $data['page_title'] = 'Mass Voucher Generator';

        //Please use cbView method instead view method from laravel
        $this->cbView('vendor/crudbooster/mass_voucher_generator', $data);
    }

    public function postSave(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'voucher_num'       => 'required',
                'type'              => 'required',
                'start_date'        => 'required',
                'end_date'          => 'required',
                'limit_per_user'    => 'required',
                'quota'             => 'required',
                'unit'              => 'required',
                'discount'          => 'required',
                'min_amount'        => 'required',
            ]
        );
        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $res     = redirect()->back()->with(['message' => implode('<br/>', $message), 'message_type' => 'warning'])->withInput();
            \Session::driver()->save();
            $res->send();
            exit;
        }

        $tempData = [];

        $limitUser      = preg_replace('/[^\d-]+/', '', $request->limit_per_user);
        $quota          = preg_replace('/[^\d-]+/', '', $request->quota);
        $discount       = preg_replace('/[^\d-]+/', '', $request->discount);
        $minAmount      = preg_replace('/[^\d-]+/', '', $request->min_amount);
        $voucherNum     = preg_replace('/[^\d-]+/', '', $request->voucher_num);

        if ($request->unit == 'percentage') {
            if ($discount > 100) {
                $res = redirect()->back()->with(['message' => 'Discount amount have to be between 1-100 if unit is percentage', 'message_type' => 'warning'])->withInput();
                \Session::driver()->save();
                $res->send();
                exit;
            }
        }

        $start = \Carbon\Carbon::parse($request->start_date);
        $end   = \Carbon\Carbon::parse($request->end_date);

        if ($start > $end) {
            $res = redirect()->back()->with(['message' => 'Start date have to be lower than End Date', 'message_type' => 'warning'])->withInput();
            \Session::driver()->save();
            $res->send();
            exit;
        }

        for ($i = 0; $i < $voucherNum; $i++) {
            $voucher                    = new Voucher;
            $voucher->type              = $request->type;
            $voucher->start_date        = $request->start_date;
            $voucher->end_date          = $request->end_date;
            $voucher->limit_per_user    = $limitUser;
            $voucher->quota             = $quota;
            $voucher->unit              = $request->unit;
            $voucher->discount          = $discount;
            $voucher->min_amount        = $minAmount;
            $voucher->code              = $this->generateUniqueVoucher(8);
            $voucher->save();

            array_push($tempData, $voucher->id);
        }

        $exportData = Voucher::whereIn('id', $tempData)->get();

        $logDesc      = 'Generate mass voucher of ' . $request->voucher_num . ' Vouchers';
        insertRhapsodieLog($logDesc, 'voucher', CRUDBooster::myId(), json_encode($exportData));

        CRUDBooster::redirect(CRUDBooster::adminPath() . '/vouchers', 'Voucher Has been generated', 'success');
        return back();
    }

    private function generateUniqueVoucher($length = 20)
    {
        $characters       = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // private function downloadExcel($data)
    // {
    //     $this->data['datas'] = $data;
    //     $this->data['no']    = 1;

    //     $excel = Excel::create('voucher_list_' . date('Y-m-d-his'), function ($excel) {
    //         $excel->sheet('sheet1', function ($sheet) {
    //             $sheet->loadView('export.mass_voucher', $this->data);
    //         });
    //     })->store('xlsx', false, true);

    //     return $excel['file'];
    // }
}
