<?php

namespace App\Http\Controllers;

use App\User;
use CRUDBooster;

class AdminMemberManagementController extends \crocodicstudio\crudbooster\controllers\CBController
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
        $this->button_detail       = true;
        $this->button_show         = false;
        $this->button_filter       = true;
        $this->button_import       = false;
        $this->button_export       = true;
        $this->table               = 'users';
        // END CONFIGURATION DO NOT REMOVE THIS LINE

        // START COLUMNS DO NOT REMOVE THIS LINE
        $this->col   = [];
        $this->col[] = ['label' => 'Name', 'name' => 'name'];
        $this->col[] = ['label' => 'Phone', 'name' => 'phone'];
        $this->col[] = ['label' => 'Email', 'name' => 'email'];

        $this->col[] = ['label' => 'Birthday', 'name' => 'dob', 'visible' => false];
        $this->col[] = ['label' => 'Age', 'name' => 'age', 'visible' => false, 'callback' => function ($row) {
            if ($row->age) {
                return $row->age;
            }
            if ($row->dob) {
                return \Carbon\Carbon::parse($row->dob)->age;
            }
        }];
        $this->col[] = ['label' => 'Phone', 'name' => 'phone', 'visible' => false];
        $this->col[] = ['label' => 'Gender', 'name' => 'gender', 'visible' => false];

        $this->col[] = ['label' => 'Verification Status', 'name' => 'verification_status', 'callback' => function ($row) {
            if ($row->verification_status == 1) {
                return '<span class="label label-success">Confirmed</span>';
            } else {
                return '<span class="label label-danger">Unconfirmed</span>';
            }
        }];
        $this->col[] = ['label' => 'Subscribe', 'name' => 'is_subscribe', 'callback' => function ($row) {
            if ($row->is_subscribe == 1) {
                return '<span class="label label-success">Yes</span>';
            } else {
                return '<span class="label label-danger">No</span>';
            }
        }];
        $this->col[] = ['label' => 'Reseller', 'name' => 'is_reseller', 'callback' => function ($row) {
            if ($row->is_reseller == 1) {
                return '<span class="label label-success">Yes</span>';
            } else {
                return '<span class="label label-danger">No</span>';
            }
        }];
        // END COLUMNS DO NOT REMOVE THIS LINE

        // START FORM DO NOT REMOVE THIS LINE
        $this->form   = [];
        // $this->form[] = ['label'=>'Provider', 'name'=>'provider', 'type'=>'text', 'validation'=>'required|min:1|max:255', 'width'=>'col-sm-10'];
        // $this->form[] = ['label'=>'Register Id', 'name'=>'register_id', 'type'=>'select2', 'validation'=>'required|min:1|max:255', 'width'=>'col-sm-10'];
        // $this->form[] = ['label'=>'Title', 'name'=>'title', 'type'=>'text', 'validation'=>'required|string|min:3|max:70', 'width'=>'col-sm-10', 'placeholder'=>'You can only enter the letter only'];
        $this->form[] = ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'validation' => 'required|string|min:3|max:70', 'width' => 'col-sm-10', 'placeholder' => 'You can only enter the letter only'];
        // $this->form[] = ['label'=>'Nickname', 'name'=>'nickname', 'type'=>'text', 'validation'=>'required|string|min:3|max:70', 'width'=>'col-sm-10', 'placeholder'=>'You can only enter the letter only'];
        $this->form[] = ['label' => 'Birthday', 'name' => 'dob', 'type' => 'date', 'validation' => 'date', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Gender', 'name' => 'gender', 'type' => 'select', 'validation' => '', 'width' => 'col-sm-9', 'dataenum' => 'male|Male;female|Female'];
        // $this->form[] = ['label'=>'Type Of Business', 'name'=>'type_of_business', 'type'=>'text', 'validation'=>'required|min:1|max:255', 'width'=>'col-sm-10'];
        $this->form[] = ['label' => 'Phone', 'name' => 'phone', 'type' => 'number', 'width' => 'col-sm-10', 'placeholder' => 'You can only enter the number only'];
        $this->form[] = ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'validation' => 'required|min:1|max:255|email|unique:users', 'width' => 'col-sm-10', 'placeholder' => 'Please enter a valid email address'];
        $this->form[] = ['label' => 'Password', 'name' => 'password', 'type' => 'password', 'validation' => 'min:8|max:32', 'width' => 'col-sm-10', 'help' => 'Minimum 8 characters. Please leave empty if you did not change the password.'];
        // $this->form[] = ['label'=>'Verification Code', 'name'=>'verification_code', 'type'=>'text', 'validation'=>'required|min:1|max:255', 'width'=>'col-sm-10'];
        // $this->form[] = ['label'=>'Ticket', 'name'=>'ticket', 'type'=>'text', 'validation'=>'required|min:1|max:255', 'width'=>'col-sm-10'];

        $this->form[] = ['label' => 'Verification Status', 'name' => 'verification_status', 'type' => 'radio', 'validation' => 'required', 'width' => 'col-sm-9', 'dataenum' => '1|Active;0|Inactive', 'value' => '1'];

        $this->form[] = ['label' => 'Reseller', 'name' => 'is_reseller', 'type' => 'radio', 'validation' => 'required', 'width' => 'col-sm-9', 'dataenum' => '1|Yes;0|No', 'value' => '0'];
        // $this->form[] = ['label'=>'Socialite Token','name'=>'socialite_token','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        // $this->form[] = ['label'=>'Socialite Refresh Token','name'=>'socialite_refresh_token','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        // $this->form[] = ['label'=>'Socialite Expires In','name'=>'socialite_expires_in','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        // $this->form[] = ['label'=>'Socialite Avatar','name'=>'socialite_avatar','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        // $this->form[] = ['label'=>'Is Subscribe', 'name'=>'is_subscribe', 'type'=>'radio', 'validation'=>'required|integer', 'width'=>'col-sm-10', 'dataenum'=>'Array'];
        // $this->form[] = ['label'=>'Remember Token', 'name'=>'remember_token', 'type'=>'text', 'validation'=>'required|min:1|max:255', 'width'=>'col-sm-10'];
        // END FORM DO NOT REMOVE THIS LINE

        // OLD START FORM
        //$this->form = [];
        //$this->form[] = ['label'=>'Provider','name'=>'provider','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Register Id','name'=>'register_id','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'register,id'];
        //$this->form[] = ['label'=>'Title','name'=>'title','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
        //$this->form[] = ['label'=>'Name','name'=>'name','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
        //$this->form[] = ['label'=>'Nickname','name'=>'nickname','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
        //$this->form[] = ['label'=>'Dob','name'=>'dob','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Type Of Business','name'=>'type_of_business','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Phone','name'=>'phone','type'=>'number','validation'=>'required|numeric','width'=>'col-sm-10','placeholder'=>'You can only enter the number only'];
        //$this->form[] = ['label'=>'Email','name'=>'email','type'=>'email','validation'=>'required|min:1|max:255|email|unique:users','width'=>'col-sm-10','placeholder'=>'Please enter a valid email address'];
        //$this->form[] = ['label'=>'Password','name'=>'password','type'=>'password','validation'=>'min:3|max:32','width'=>'col-sm-10','help'=>'Minimum 5 characters. Please leave empty if you did not change the password.'];
        //$this->form[] = ['label'=>'Verification Code','name'=>'verification_code','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Ticket','name'=>'ticket','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Verification Status','name'=>'verification_status','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Socialite Token','name'=>'socialite_token','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Socialite Refresh Token','name'=>'socialite_refresh_token','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Socialite Expires In','name'=>'socialite_expires_in','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Socialite Avatar','name'=>'socialite_avatar','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Is Subscribe','name'=>'is_subscribe','type'=>'radio','validation'=>'required|integer','width'=>'col-sm-10','dataenum'=>'Array'];
        //$this->form[] = ['label'=>'Remember Token','name'=>'remember_token','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Is Provider','name'=>'is_provider','type'=>'radio','validation'=>'required|integer','width'=>'col-sm-10','dataenum'=>'Array'];
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
        $hash                 = bcrypt($postdata['password']);
        $postdata['password'] = $hash;
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
        $user          = User::findOrFail($id);
        $logDesc       = 'Add new user ' . ucwords($user->email);
        insertRhapsodieLog($logDesc, 'user', CRUDBooster::myId(), $user->toJson());
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
        $user             = User::findOrFail($id);
        $logDesc          = 'Edit user ' . $user->email;
        insertRhapsodieLog($logDesc, 'user', CRUDBooster::myId(), json_encode(array_diff($postdata, $user->toArray())));
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
        // $user             = User::findOrFail($id);
        // $logDesc          = 'Delete user ' . $user->email;
        // insertRhapsodieLog($logDesc, 'user', CRUDBooster::myId(), $user->toJson());
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
