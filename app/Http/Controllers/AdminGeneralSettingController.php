<?php

namespace App\Http\Controllers;

use App\Config;
use CRUDBooster;
use DB;
use Illuminate\Http\Request;
use Image;
use Storage;

class AdminGeneralSettingController extends \crocodicstudio\crudbooster\controllers\CBController
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
        $this->button_add          = false;
        $this->button_edit         = true;
        $this->button_delete       = true;
        $this->button_detail       = true;
        $this->button_show         = false;
        $this->button_filter       = true;
        $this->button_import       = false;
        $this->button_export       = false;
        $this->table               = 'configs';
        // END CONFIGURATION DO NOT REMOVE THIS LINE

        // START COLUMNS DO NOT REMOVE THIS LINE
        $this->col   = [];
        $this->col[] = ['label' => 'Name', 'name' => 'name'];
        $this->col[] = ['label' => 'Value', 'name' => 'value'];
        // END COLUMNS DO NOT REMOVE THIS LINE

        // START FORM DO NOT REMOVE THIS LINE
        $this->form   = [];
        $this->form[] = ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'validation' => 'required|string|min:3|max:70', 'width' => 'col-sm-10', 'placeholder' => 'You can only enter the letter only'];
        $this->form[] = ['label' => 'Value', 'name' => 'value', 'type' => 'textarea', 'validation' => 'required|string|min:5|max:5000', 'width' => 'col-sm-10'];
        // END FORM DO NOT REMOVE THIS LINE

        // OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"Name","name"=>"name","type"=>"text","required"=>TRUE,"validation"=>"required|string|min:3|max:70","placeholder"=>"You can only enter the letter only"];
        //$this->form[] = ["label"=>"Value","name"=>"value","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
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

    //By the way, you can still create your own method in here... :)
    public function getIndex()
    {
        if (!CRUDBooster::isUpdate() && $this->global_privilege == false || $this->button_edit == false) {
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        }

        $config     = Config::all();
        $setting    = [];

        foreach ($config as $key => $conf) {
            $setting[$conf->name] = $conf->value;
        }

        $data               = [];
        $data['setting']    = $setting;
        $data['page_title'] = 'General Setting';
        // $data['row'] = DB::table('products')->where('id',$id)->first();

        //Please use cbView method instead view method from laravel
        $this->cbView('vendor/crudbooster/general_setting', $data);
    }

    public function postSave(Request $request)
    {
        $input  = $request->except(['_token', '_tab']);

        if ($request->hasFile('company_logo_header')) {
            $file       = $request->company_logo_header;
            $allowedExt = ['jpg', 'jpeg', 'png'];

            $name               = $file->getClientOriginalName();
            $ext                = strtolower($file->getClientOriginalExtension());
            $size               = $file->getSize();

            $name               = 'logo_' . str_random(20) . '.' . $ext;
            $path               = 'uploads/' . date('Y-m');

            $headerLogo    = $path . '/' . $name;

            Storage::makeDirectory($path);
            if (Storage::putFileAs($path, $file, $name)) {
                $topLogo = Image::make(storage_path('app/' . $path . '/' . $name))->save(storage_path('app/' . $path . '/' . $name));
            }
        }
        if ($request->hasFile('company_logo_footer')) {
            $file       = $request->company_logo_footer;
            $allowedExt = ['jpg', 'jpeg', 'png'];

            $name               = $file->getClientOriginalName();
            $ext                = strtolower($file->getClientOriginalExtension());
            $size               = $file->getSize();

            $name               = 'logo_' . str_random(20) . '.' . $ext;
            $path               = 'uploads/' . date('Y-m');

            $footerLogo    = $path . '/' . $name;

            Storage::makeDirectory($path);
            if (Storage::putFileAs($path, $file, $name)) {
                $belowLogo = Image::make(storage_path('app/' . $path . '/' . $name))->save(storage_path('app/' . $path . '/' . $name));
            }
        }

        if ($request->hasFile('favicon')) {
            $file               = $request->favicon;
            $allowedExt         = ['jpg', 'jpeg', 'png'];

            $name               = $file->getClientOriginalName();
            $ext                = strtolower($file->getClientOriginalExtension());
            $size               = $file->getSize();

            $name               = 'favicon_' . str_random(4) . '.' . $ext;
            $path               = 'uploads/' . date('Y-m');
            $faviconImage       = $path . '/' . $name;

            Storage::makeDirectory($path);

            if (Storage::putFileAs($path, $file, $name)) {
                $favicon = Image::make(storage_path('app/' . $path . '/' . $name))->save(storage_path('app/' . $path . '/' . $name));
            }
        }

        $tab    = $request->_tab;
        foreach ($input as $name => $value) {
            if ($request->hasFile('company_logo_header')) {
                if ($name == 'company_logo_header') {
                    Config::where('name', $name)->update(['value' => $headerLogo]);
                }
            } elseif ($request->hasFile('company_logo_footer')) {
                if ($name == 'company_logo_footer') {
                    Config::where('name', $name)->update(['value' => $footerLogo]);
                }
            } elseif ($request->hasFile('favicon')) {
                if ($name == 'favicon') {
                    Config::where('name', $name)->update(['value' => $faviconImage]);
                }
            } else {
                Config::where('name', $name)->update(['value' => $value]);
            }
        }

        $logDesc          = 'Edit general settings';
        insertRhapsodieLog($logDesc, 'general_setting', CRUDBooster::myId(), json_encode($request->except(['_token'])));
        \Cache::forget('configs');

        \Session::flash('success', 'Your changes have been saved successfully');

        return back()->with(['message' => 'General Setting Has been saved', 'message_type' => 'success']);
        exit;
    }

    public function getResetCache()
    {
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        \Artisan::call('view:clear');

        return back()->with(['message' => 'Cache Has Been Clear', 'message_type' => 'success']);
        exit;
    }
}
