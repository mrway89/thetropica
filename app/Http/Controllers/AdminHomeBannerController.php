<?php

namespace App\Http\Controllers;

use App\Image;
use CRUDBooster;
use DB;
use Request;

class AdminHomeBannerController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {
        // START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field         = 'title';
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
        $this->table               = 'images';
        // END CONFIGURATION DO NOT REMOVE THIS LINE

        // START COLUMNS DO NOT REMOVE THIS LINE
        $this->col   = [];
        $this->col[] = ['label'=>'Image', 'name'=>'url', 'image'=>true];
        $this->col[] = ['label'=>'Link', 'name'=>'link'];
        // END COLUMNS DO NOT REMOVE THIS LINE

        // START FORM DO NOT REMOVE THIS LINE
        $this->form   = [];
        $this->form[] = ['label'=>'Image', 'name'=>'url', 'type'=>'upload', 'validation'=>'required|image|max:1000', 'upload_encrypt' => 'true', 'width'=>'col-sm-10', 'help'=>'Best resolution: 1000 x 328px, Max file Size: 1 Mb'];
        $this->form[] = ['label'=>'Title ID', 'name'=>'title_id', 'type'=>'text', 'width'=>'col-sm-9', 'validation'=>''];
        $this->form[] = ['label'=>'Title EN', 'name'=>'title_en', 'type'=>'text', 'width'=>'col-sm-9', 'validation'=>''];
        $this->form[] = ['label'=>'Content ID', 'name'=>'content_id', 'type'=>'textarea', 'width'=>'col-sm-9', 'validation'=>'required'];
        $this->form[] = ['label'=>'Content EN', 'name'=>'content_en', 'type'=>'textarea', 'width'=>'col-sm-9', 'validation'=>'required'];
        // END FORM DO NOT REMOVE THIS LINE

        // OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"Type","name"=>"type","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Item Id","name"=>"item_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"item,id"];
        //$this->form[] = ["label"=>"Title","name"=>"title","type"=>"text","required"=>TRUE,"validation"=>"required|string|min:3|max:70","placeholder"=>"You can only enter the letter only"];
        //$this->form[] = ["label"=>"Url","name"=>"url","type"=>"text","required"=>TRUE,"validation"=>"required|url","placeholder"=>"Please enter a valid URL"];
        //$this->form[] = ["label"=>"Is Featured","name"=>"is_featured","type"=>"radio","required"=>TRUE,"validation"=>"required|integer","dataenum"=>"Array"];
        //$this->form[] = ["label"=>"Link","name"=>"link","type"=>"text","required"=>TRUE,"validation"=>"required|url","placeholder"=>"Please enter a valid URL"];
        //$this->form[] = ["label"=>"Sorting","name"=>"sorting","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
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
        $query->where('type', 'home_banner');
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
        $postdata['type']       = 'home_banner';
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
        $image                  = Image::findOrFail($id);
        $logDesc                = 'Add new home about ' . $image->url;
        insertRhapsodieLog($logDesc, 'home_about', CRUDBooster::myId(), $image->url);
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
        if (!isset($postdata['link'])) {
            $postdata['link'] = '';
        }
        if ($postdata['title_id'] == '') {
            $postdata['title_id'] = '';
        }

        if ($postdata['title_en'] == '') {
            $postdata['title_en'] = '';
        }

        $image                  = Image::findOrFail($id);
        $logDesc                = 'Edit Home about ' . $image->url;
        insertRhapsodieLog($logDesc, 'home_about', CRUDBooster::myId(), json_encode($postdata));
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
        \Cache::forget('home_about');
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
        $image = Image::findOrFail($id);
        delete_image($image->url);
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
        $this->cbLoader();

        $module = CRUDBooster::getCurrentModule();
        if (!CRUDBooster::isView() && $this->global_privilege == false) {
            CRUDBooster::insertLog(trans('crudbooster.log_try_view', ['module' => $module->name]));
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        }

        $images = DB::table('images')->where('type', 'home_banner')->orderby('sorting', 'asc')->get();

        $return_url = Request::fullUrl();

        $page_title = 'Home About Management';

        return view('vendor/crudbooster/home_banner_management', compact('images', 'return_url', 'page_title'));
    }

    public function postSaveSorting()
    {
        $post           = Request::input('images');
        $post           = json_decode($post, true);
        $item_id        = Request::input('item_id');
        // dd($post);

        foreach ($post as $p) {
            foreach ($p as $index => $image) {
                DB::table('images')->where('id', $image['id'])->update(['sorting' => $index + 1]);
            }
        }
        \Cache::forget('home_about');

        return response()->json(['success' => true]);
    }
}
