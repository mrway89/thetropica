<?php

namespace App\Http\Controllers;

use App\ExperienceContent;

class AdminFactoryVisitController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {
        // START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field         = 'title_id';
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
        $this->table               = 'experience_contents';
        // END CONFIGURATION DO NOT REMOVE THIS LINE

        // START COLUMNS DO NOT REMOVE THIS LINE
        $this->col   = [];
        $this->col[] = ['label'=>'Image', 'name'=>'image', 'image'=>true];
        $this->col[] = ['label'=>'Title Id', 'name'=>'title_id'];
        $this->col[] = ['label'=>'Title En', 'name'=>'title_en'];
        // END COLUMNS DO NOT REMOVE THIS LINE

        // START FORM DO NOT REMOVE THIS LINE
        $this->form   = [];
        $this->form[] = ['label'=>'Image', 'name'=>'image', 'type'=>'upload', 'validation'=>'required|image|max:1000', 'width'=>'col-sm-10', 'help'=>'File types support : JPG, JPEG, PNG, GIF, BMP', 'upload_encrypt' => 'true'];
        $this->form[] = ['label'=>'Title ID', 'name'=>'title_id', 'type'=>'text', 'validation'=>'required', 'width'=>'col-sm-10', 'datatable'=>'title,id'];
        $this->form[] = ['label'=>'Content ID', 'name'=>'content_id', 'type'=>'textarea', 'validation'=>'required', 'width'=>'col-sm-10', 'datatable'=>'content,id'];
        $this->form[] = ['label'=>'Title EN', 'name'=>'title_en', 'type'=>'text', 'validation'=>'', 'width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Content EN', 'name'=>'content_en', 'type'=>'textarea', 'validation'=>'', 'width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Parent Id', 'name'=>'parent_id', 'type'=>'hidden', 'validation'=>'required', 'width'=>'col-sm-9', 'value'=> request('parent_id')];
        // END FORM DO NOT REMOVE THIS LINE

        // OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"Image","name"=>"image","type"=>"upload","required"=>TRUE,"validation"=>"required|image|max:3000","help"=>"File types support : JPG, JPEG, PNG, GIF, BMP"];
        //$this->form[] = ["label"=>"Title Id","name"=>"title_id","type"=>"select2","required"=>TRUE,"validation"=>"required|min:1|max:255","datatable"=>"title,id"];
        //$this->form[] = ["label"=>"Title En","name"=>"title_en","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Subtitle Id","name"=>"subtitle_id","type"=>"select2","required"=>TRUE,"validation"=>"required|min:1|max:255","datatable"=>"subtitle,id"];
        //$this->form[] = ["label"=>"Subtitle En","name"=>"subtitle_en","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Content Id","name"=>"content_id","type"=>"select2","required"=>TRUE,"validation"=>"required|string|min:5|max:5000","datatable"=>"content,id"];
        //$this->form[] = ["label"=>"Content En","name"=>"content_en","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
        //$this->form[] = ["label"=>"Link1","name"=>"link1","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Link2","name"=>"link2","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Type","name"=>"type","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Slug","name"=>"slug","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
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
        $this->sub_module   = [];

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
        $this->addaction    = [];
        $this->sub_module[] = ['label' => 'Items', 'path' => 'experience_retreat_detail', 'foreign_key' => 'subparent_id', 'button_color' => 'info', 'button_icon' => 'fa fa-list', 'parent_columns' => 'title_id', 'custom_parent_alias' => 'Title'];

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
            $(document).ready(function(){
                $('#form-group-title_en').before('<hr>');
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
        // $max_sorting            = DB::table($this->table)->where('type', 'faqs')->max('sorting');
        // $postdata['sorting']    = $max_sorting + 1;
        // $count                  = ExperienceContent::where('type', 'retreat')->count();
        $slug                   = str_slug($postdata['title_id']);
        $checkSlug              = ExperienceContent::where('type', 'retreat')->where('slug', $slug)->get()->count();
        if ($checkSlug > 0) {
            $slug = $slug . '-' . str_random(5);
        }
        $postdata['slug']       = $slug;
        $postdata['type']       = 'retreat';
        // $postdata['sorting']    = $count + 1;
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
        // $max_sorting            = DB::table($this->table)->where('type', 'faqs')->max('sorting');
        // $postdata['sorting']    = $max_sorting + 1;
        // $count                  = ExperienceContent::where('type', 'retreat')->count();
        $slug                   = str_slug($postdata['title_id']);
        $checkSlug              = ExperienceContent::where('type', 'retreat')->where('id', '!=', $id)->where('slug', $slug)->get()->count();
        if ($checkSlug > 0) {
            $slug = $slug . '-' . str_random(5);
        }
        $postdata['slug']       = $slug;
        $postdata['type']       = 'retreat';
        // $postdata['sorting']    = $count + 1;
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
}
