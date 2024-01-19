<?php

namespace App\Http\Controllers;

use App\Category;
use CRUDBooster;
use DB;
use Request;

class AdminProductSubcategoriesController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {
        // START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field         = 'title';
        $this->limit               = '20';
        $this->orderby             = 'id,desc';
        $this->global_privilege    = false;
        $this->button_table_action = true;
        $this->button_bulk_action  = false;
        $this->button_add          = false;
        $this->button_edit         = true;
        $this->button_delete       = true;
        $this->button_detail       = true;
        $this->button_show         = false;
        $this->button_filter       = true;
        $this->button_import       = false;
        $this->button_export       = false;

        $this->table = 'categories';
        // END CONFIGURATION DO NOT REMOVE THIS LINE

        // START COLUMNS DO NOT REMOVE THIS LINE
        $this->col   = [];
        $this->col[] = ['label' => 'Title', 'name' => 'title'];
        // END COLUMNS DO NOT REMOVE THIS LINE

        // START FORM DO NOT REMOVE THIS LINE
        $this->form   = [];
        $this->form[] = ['label' => 'Title', 'name' => 'title', 'type' => 'text', 'validation' => 'required|string|min:3|max:70', 'width' => 'col-sm-10', 'placeholder' => 'You can only enter the letter only'];
        // $this->form[] = ['label'=>'Featured?', 'name'=>'is_featured', 'type'=>'radio', 'validation'=>'required', 'width'=>'col-sm-9', 'dataenum'=>'1|Active;0|Inactive', 'value'=>'1'];
        $this->form[] = ['label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'validation' => 'required|string|min:5|max:5000', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Icon Image', 'name' => 'icon_image', 'type' => 'upload', 'validation' => 'image|max:1000', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Cover Image', 'name' => 'cover_image', 'type' => 'upload', 'validation' => 'min:1|max:1000', 'width' => 'col-sm-10', 'help' => 'Best resolution: 1000 x 567px, Max file Size: 1 Mb'];
        $this->form[] = ['label' => 'Banner Image', 'name' => 'banner_image', 'type' => 'upload', 'validation' => 'image|max:1000', 'width' => 'col-sm-10', 'help' => 'Best resolution: 1077 x 135px, Max file Size: 1 Mb'];
        $this->form[] = ['label' => 'Link to', 'name' => 'banner_link', 'type' => 'text', 'validation' => 'string', 'width' => 'col-sm-10', 'placeholder' => 'https://www.google.com'];
        $this->form[] = ['label' => 'Parent Id', 'name' => 'parent_id', 'type' => 'hidden', 'validation' => 'required', 'width' => 'col-sm-9', 'value' => request('parent_id')];
        // END FORM DO NOT REMOVE THIS LINE

        // OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"Parent Id","name"=>"parent_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"parent,id"];
        //$this->form[] = ["label"=>"Title","name"=>"title","type"=>"text","required"=>TRUE,"validation"=>"required|string|min:3|max:70","placeholder"=>"You can only enter the letter only"];
        //$this->form[] = ["label"=>"Slug","name"=>"slug","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Description","name"=>"description","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
        //$this->form[] = ["label"=>"Icon Image","name"=>"icon_image","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Cover Image","name"=>"cover_image","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Banner Image","name"=>"banner_image","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Type","name"=>"type","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Is Featured","name"=>"is_featured","type"=>"radio","required"=>TRUE,"validation"=>"required|integer","dataenum"=>"Array"];
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
        $this->script_js = '
        $(function() {

        });
        ';

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
        $count                  = Category::where('type', 'product')->where('parent_id', $postdata['parent_id'])->count();
        $postdata['slug']       = str_slug($postdata['title']);
        $postdata['type']       = 'product';
        $postdata['sorting']    = $count + 1;
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
        $category   = Category::findOrFail($id);
        $logDesc    = 'Add new product subcategory ' . $category->title;
        insertRhapsodieLog($logDesc, 'product', CRUDBooster::myId(), $category->title);
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
        $count                  = Category::where('type', 'product')->where('parent_id', $postdata['parent_id'])->count();
        $postdata['slug']       = str_slug($postdata['title']);
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
        $category   = Category::findOrFail($id);
        $logDesc    = 'Update product subcategory ' . $category->title;
        insertRhapsodieLog($logDesc, 'product', CRUDBooster::myId(), $category->title);
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
        // $category   = Category::findOrFail($id);
        // $logDesc    = 'Delete product subcategory ' . $category->title;
        // insertRhapsodieLog($logDesc, 'product', CRUDBooster::myId(), $category->title);
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after delete public static function called
    | ----------------------------------------------------------------------
    | @id       = current id
    |
    */
    public function hook_after_delete($id)
    { }

    //By the way, you can still create your own method in here... :)

    public function getIndex()
    {
        $this->cbLoader();

        $module = CRUDBooster::getCurrentModule();
        if (!CRUDBooster::isView() && $this->global_privilege == false) {
            CRUDBooster::insertLog(trans('crudbooster.log_try_view', ['module' => $module->name]));
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        }

        $categories = DB::table('categories')->where('parent_id', request('parent_id'))->orderby('sorting', 'asc')->get();

        foreach ($categories as &$category) {
            $child = DB::table('categories')->where('parent_id', $category->id)->orderby('sorting', 'asc')->get();
            if (count($child)) {
                $category->children = $child;
            }
        }
        $submenu =  CRUDBooster::first(request('parent_table'), request('parent_id'));

        $return_url = Request::fullUrl();

        $page_title = 'Category Management for ' . $submenu->title;

        return view('vendor/crudbooster/categories_management', compact('categories', 'return_url', 'page_title', 'submenu'));
    }

    public function postSaveMenu()
    {
        $post           = Request::input('categories');
        $post           = json_decode($post, true);
        $base_category  = Request::input('base_category');

        $i = 1;
        foreach ($post[0] as $ro) {
            $pid = $ro['id'];
            if ($ro['children'][0]) {
                $ci = 1;
                foreach ($ro['children'][0] as $c) {
                    $id = $c['id'];
                    DB::table('categories')->where('id', $id)->update(['sorting' => $ci, 'parent_id' => $pid]);
                    $ci++;
                }
            }
            DB::table('categories')->where('id', $pid)->update(['sorting' => $i, 'parent_id' => $base_category]);
            $i++;
        }

        return response()->json(['success' => true]);
    }
}
