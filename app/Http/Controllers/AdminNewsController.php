<?php

namespace App\Http\Controllers;

use App\Post;
use crocodicstudio\crudbooster\helpers\CRUDBooster;

class AdminNewsController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {
        // START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table               = 'posts';
        $this->title_field         = 'title';
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
        $this->button_filter       = false;
        $this->button_export       = false;
        $this->button_import       = false;
        $this->button_bulk_action  = true;
        $this->sidebar_mode           = 'normal'; //normal,mini,collapse,collapse-mini
        // END CONFIGURATION DO NOT REMOVE THIS LINE

        // START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        // $this->col[] = array("label"=>"Category Id","name"=>"category_id","join"=>"category,id");
        // $this->col[] = ['label'=>'Cover', 'name'=>'cover', 'image'=>true];
        $this->col[] = ['label' => 'Title ID', 'name' => 'title_id'];
        $this->col[] = ['label' => 'Title EN', 'name' => 'title_en'];

        // END COLUMNS DO NOT REMOVE THIS LINE
        // START FORM DO NOT REMOVE THIS LINE
        $this->form   = [];
        // $this->form[] = ['label'=>'Cover', 'name'=>'cover', 'type'=>'upload', 'validation'=>'required|image|max:1000', 'upload_encrypt' => 'true', 'help' => 'Recommended: 1000 x 523px, Max Size: 1MB'];
        $this->form[] = ['label' => 'Category', 'name' => 'category_id', 'type' => 'select2', 'required' => true, 'validation' => 'required', 'datatable' => 'categories,title_en', 'datatable_where' => 'type = "news"', 'datatable_format' => "'EN : ',title_en,' | ID :',title_id"];
        $this->form[] = ['label' => 'Start Date', 'name' => 'start_date', 'type' => 'date', 'validation' => 'date', 'width' => 'col-sm-5'];
        $this->form[] = ['label' => 'End Date', 'name' => 'end_date', 'type' => 'date', 'validation' => 'date', 'width' => 'col-sm-5'];
        $this->form[] = ['label' => 'Type', 'name' => 'type', 'type' => 'hidden', 'required' => true, 'validation' => 'required', 'value' => 'news'];
        $this->form[] = ['label' => 'Title ID', 'name' => 'title_id', 'type' => 'text', 'required' => true, 'validation' => 'required|string'];
        $this->form[] = ['label' => 'Title EN', 'name' => 'title_en', 'type' => 'text', 'required' => true, 'validation' => 'required|string'];
        $this->form[] = ['label' => 'Content ID', 'name' => 'content_id', 'type' => 'wysiwyg', 'validation' => 'required|string'];
        $this->form[] = ['label' => 'Content EN', 'name' => 'content_en', 'type' => 'wysiwyg', 'validation' => 'required|string'];
        $this->form[] = ['label' => 'Other', 'name' => 'cover', 'type' => 'hidden'];

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
        $this->sub_module[] = ['label' => 'Images', 'path' => 'news_images', 'foreign_key' => 'item_id', 'button_color' => 'info', 'button_icon' => 'fa fa-image', 'showIf' => "[type] != 'URL'"];

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
				$("#textarea_content_en").on("summernote.paste",function(e,ne) {
					var bufferText = ((ne.originalEvent || ne).clipboardData || window.clipboardData).getData("Text");
					ne.preventDefault();
					document.execCommand("insertText", false, bufferText);
                });

				$("#textarea_content_id").on("summernote.paste",function(e,ne) {
					var bufferText = ((ne.originalEvent || ne).clipboardData || window.clipboardData).getData("Text");
					ne.preventDefault();
					document.execCommand("insertText", false, bufferText);
				});

                var myPath = "' . $mybasepath . '";
                var json = $("input[name=\'cover\']").val();
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
        $query->where('type', 'news');
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
        $postdata['title_en']      = ucwords($postdata['title_en']);
        $slug                      = str_slug($postdata['title_en']);
        $checkSlug                 = Post::where('type', 'news')->where('slug', str_slug($postdata['title_en']))->get()->count();

        if ($checkSlug > 0) {
            $slug = str_slug($postdata['title_en'] . '-' . str_random(5));
        }

        $postdata['slug']       = $slug;

        $banner['start_date']       = $postdata['start_date'];
        $banner['end_date']         = $postdata['end_date'];
        $postdata['cover']          = json_encode($banner);
        unset($postdata['start_date'], $postdata['end_date']);
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
        $news         = Post::findOrFail($id);
        $logDesc      = 'Add new news ' . $how->title_en;
        insertRhapsodieLog($logDesc, 'news', CRUDBooster::myId(), $news->toJson());

        \Cache::forget('about_news');

        return redirect('admin/news_images?parent_table=products&parent_columns=&parent_columns_alias=&parent_id=' . $news->id)->with(['message' => 'News Has been saved', 'message_type' => 'success'])->send();
        exit;
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
        $postdata['title_en']      = ucwords($postdata['title_en']);
        $slug                      = str_slug($postdata['title_en']);
        $checkSlug                 = Post::where('type', 'news')->where('id', '!=', $id)->where('slug', str_slug($postdata['title_en']))->get()->count();

        if ($checkSlug > 0) {
            $slug = str_slug($postdata['title_en'] . '-' . str_random(5));
        }

        $postdata['slug']       = $slug;

        $content                = Post::findOrFail($id);
        $logDesc                = 'Edit news ' . $content->title_en;
        insertRhapsodieLog($logDesc, 'news', CRUDBooster::myId(), json_encode(array_diff($postdata, $content->toArray())));

        $banner['start_date']       = $postdata['start_date'];
        $banner['end_date']         = $postdata['end_date'];
        $postdata['cover']          = json_encode($banner);
        unset($postdata['start_date'], $postdata['end_date']);
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
        \Cache::forget('about_news');
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
            $faq   = Post::findOrFail($id[0]);
        } else {
            $faq          = Post::findOrFail($id);
        }
        $logDesc      = 'Delete news ' . $faq->title_en;
        insertRhapsodieLog($logDesc, 'news', CRUDBooster::myId(), $faq->toJson());
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
        \Cache::forget('about_news');
    }

    //By the way, you can still create your own method in here... :)
}
