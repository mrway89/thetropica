<?php

namespace App\Http\Controllers;

use App\Post;
use crocodicstudio\crudbooster\helpers\CRUDBooster;

class AdminPromotionsListController extends \crocodicstudio\crudbooster\controllers\CBController
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
        $this->button_add          = true;
        $this->button_edit         = true;
        $this->button_delete       = true;
        $this->button_detail       = true;
        $this->button_show         = false;
        $this->button_filter       = true;
        $this->button_import       = false;
        $this->button_export       = true;
        $this->table               = 'posts';
        // END CONFIGURATION DO NOT REMOVE THIS LINE

        // START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        // $this->col[] = array("label"=>"Category Id","name"=>"category_id","join"=>"category,id");
        $this->col[] = ['label'=>'Type', 'name'=>'type'];
        $this->col[] = ['label'=>'Title', 'name'=>'title'];

        // END COLUMNS DO NOT REMOVE THIS LINE
        // START FORM DO NOT REMOVE THIS LINE
        $this->form   = [];
        $this->form[] = ['label'=>'Other', 'name'=>'other_content', 'type'=>'hidden'];
        $this->form[] = ['label'=>'Cover', 'name'=>'cover', 'type'=>'upload', 'validation'=>'required|image|max:1000', 'upload_encrypt' => 'true', 'help' => 'Recommended: 1000 x 523px, Max Size: 1MB'];
        $this->form[] = ['label'=>'Start Date', 'name'=>'start_date', 'type'=>'date', 'validation'=>'required|date', 'width'=>'col-sm-5'];
        $this->form[] = ['label'=>'End Date', 'name'=>'end_date', 'type'=>'date', 'validation'=>'required|date', 'width'=>'col-sm-5'];
        $this->form[] = ['label'=>'Category', 'name'=>'category_id', 'type'=>'select2', 'required'=>true, 'validation'=>'required', 'datatable'=>'categories,title', 'datatable_where'=>'type = "promotion"'];
        $this->form[] = ['label'=>'Type', 'name'=>'type', 'type'=>'hidden', 'required'=>true, 'validation'=>'required', 'value' => 'promotion'];
        $this->form[] = ['label'=>'Title', 'name'=>'title', 'type'=>'text', 'required'=>true, 'validation'=>'required|string'];
        $this->form[] = ['label'=>'Small Title', 'name'=>'small_title', 'type'=>'text', 'required'=>true, 'validation'=>''];
        $this->form[] = ['label'=>'Content', 'name'=>'content', 'type'=>'wysiwyg', 'validation'=>'required|string'];

        // END FORM DO NOT REMOVE THIS LINE

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
        $mybasepath      = env('APP_URL');
        $this->script_js = '
			$(function() {
				$("#textarea_content").on("summernote.paste",function(e,ne) {
					var bufferText = ((ne.originalEvent || ne).clipboardData || window.clipboardData).getData("Text");
					ne.preventDefault();
					document.execCommand("insertText", false, bufferText);
				});

                var myPath = "' . $mybasepath . '";
                var json = $("input[name=\'other_content\']").val();
                if(json){
                    if (json !== "") {
                        var jsonArr = JSON.parse(json);
                        $("#start_date").val(jsonArr["start_date"]);
                        $("#end_date").val(jsonArr["end_date"]);
                        $("#small_title").val(jsonArr["small_title"]);
                    }
                }
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
        $query->where('type', 'promotion');
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
        $postdata['title']      = ucwords($postdata['title']);
        $slug                   = str_slug($postdata['title']);
        $checkSlug              = Post::where('type', 'promotion')->where('slug', str_slug($postdata['title']))->get()->count();

        if ($checkSlug > 1) {
            $slug = str_slug($postdata['title'] . '-' . str_random(5));
        }

        $postdata['slug']       = $slug;

        $banner['start_date']       = $postdata['start_date'];
        $banner['end_date']         = $postdata['end_date'];
        $banner['small_title']      = $postdata['small_title'];
        $postdata['other_content']  = json_encode($banner);
        unset($postdata['start_date'], $postdata['end_date'], $postdata['small_title']);
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
        $how          = Post::findOrFail($id);
        $logDesc      = 'Add new promotion ' . $how->title;
        insertRhapsodieLog($logDesc, 'promotion', CRUDBooster::myId(), $how->toJson());
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
        $postdata['title']      = ucwords($postdata['title']);
        $slug                   = str_slug($postdata['title']);
        $checkSlug              = Post::where('type', 'promotion')->where('id', '!=', $id)->where('slug', str_slug($postdata['title']))->get()->count();

        if ($checkSlug > 1) {
            $slug = str_slug($postdata['title'] . '-' . str_random(5));
        }

        $postdata['slug']           = $slug;

        $banner['start_date']       = $postdata['start_date'];
        $banner['end_date']         = $postdata['end_date'];
        $banner['small_title']      = $postdata['small_title'];
        $postdata['other_content']  = json_encode($banner);
        unset($postdata['start_date'], $postdata['end_date'], $postdata['small_title']);

        $content                = Post::findOrFail($id);
        $logDesc                = 'Edit promotion ' . $content->title;
        insertRhapsodieLog($logDesc, 'promotion', CRUDBooster::myId(), json_encode(array_diff($postdata, $content->toArray())));
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
        if (is_array($id)) {
            $faq          = Post::findOrFail($id[0]);
        } else {
            $faq          = Post::findOrFail($id);
        }
        $logDesc      = 'Delete promotion ' . $faq->title;
        insertRhapsodieLog($logDesc, 'promotion', CRUDBooster::myId(), $faq->toJson());
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
