<?php

namespace App\Http\Controllers;

use App\Content;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use DB;

class AdminHowToController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {
        // START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field         = 'title';
        $this->limit               = '20';
        $this->orderby             = 'sorting,asc';
        $this->global_privilege    = false;
        $this->button_table_action = true;
        $this->button_bulk_action  = true;
        $this->button_action_style = 'button_icon';
        $this->button_add          = true;
        $this->button_edit         = true;
        $this->button_delete       = true;
        $this->button_detail       = true;
        $this->button_show         = true;
        $this->button_filter       = true;
        $this->button_import       = false;
        $this->button_export       = false;
        $this->table               = 'contents';
        // END CONFIGURATION DO NOT REMOVE THIS LINE
        $max_sorting        = DB::table($this->table)->where('type', 'shopping_guide')->max('sorting');

        // START COLUMNS DO NOT REMOVE THIS LINE
        $this->col   = [];
        $this->col[] = ['label' => 'Title EN', 'name' => 'title_en'];
        $this->col[] = ['label' => 'Title ID', 'name' => 'title_id'];
        $this->col[] = ['label' => 'Title EN', 'name' => 'sorting', 'visible' => false];
        // $this->col[] = ['label'=>'Order', 'name'=>'sorting', ];
        // END COLUMNS DO NOT REMOVE THIS LINE

        // START FORM DO NOT REMOVE THIS LINE
        $this->form   = [];
        $this->form[] = ['label' => 'Title EN', 'name' => 'title_en', 'type' => 'text', 'validation' => 'required|string', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Title ID', 'name' => 'title_id', 'type' => 'text', 'validation' => 'required|string', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Content EN', 'name' => 'content_en', 'type' => 'wysiwyg', 'validation' => 'required', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Content ID', 'name' => 'content_id', 'type' => 'wysiwyg', 'validation' => 'required', 'width' => 'col-sm-10'];
        // END FORM DO NOT REMOVE THIS LINE

        // OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"Type","name"=>"type","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Category Id","name"=>"category_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"category,id"];
        //$this->form[] = ["label"=>"Title","name"=>"title","type"=>"text","required"=>TRUE,"validation"=>"required|string|min:3|max:70","placeholder"=>"Anda hanya dapat memasukkan huruf saja"];
        //$this->form[] = ["label"=>"Content","name"=>"content","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
        //$this->form[] = ["label"=>"Other Content","name"=>"other_content","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
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
        $this->addaction   = [];
        $this->addaction[] = ['label' => '', 'url' => CRUDBooster::mainpath('set-order/up/[id]/[sorting]'), 'icon' => 'fa fa-arrow-up', 'color' => 'danger', 'showIf' => '[sorting] > 1'];
        $this->addaction[] = ['label' => '', 'url' => CRUDBooster::mainpath('set-order/down/[id]/[sorting]'), 'icon' => 'fa fa-arrow-down', 'color' => 'danger', 'showIf' => '[sorting] < ' . $max_sorting];

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
				$("#textarea_content").on("summernote.paste",function(e,ne) {

					var bufferText = ((ne.originalEvent || ne).clipboardData || window.clipboardData).getData("Text");
					ne.preventDefault();
					document.execCommand("insertText", false, bufferText);

				});
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
        $query->where('type', 'shopping_guide');
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
        $max_sorting            = DB::table($this->table)->where('type', 'shopping_guide')->max('sorting');
        $postdata['sorting']    = $max_sorting + 1;
        $count                  = Content::where('type', 'shopping_guide')->count();
        $slug                   = str_slug($postdata['title']);
        $checkSlug              = Content::where('type', 'shopping_guide')->where('slug', str_slug($postdata['title']))->get()->count();
        if ($checkSlug > 0) {
            $slug = str_slug($postdata['title'] . '-' . str_random(5));
        }
        $postdata['slug']       = $slug;
        $postdata['type']       = 'shopping_guide';
        $postdata['sorting']    = $max_sorting + 1;
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
        $how          = Content::findOrFail($id);
        $logDesc      = 'Add new shopping guide ' . $how->title;
        insertRhapsodieLog($logDesc, 'shopping_guide', CRUDBooster::myId(), $how->toJson());
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
        $count                  = Content::where('type', 'shopping_guide')->count();
        $slug                   = str_slug($postdata['title']);
        $checkSlug              = Content::where('type', 'shopping_guide')->where('slug', str_slug($postdata['title']))->get()->count();
        if ($checkSlug > 0) {
            $slug = str_slug($postdata['title'] . '-' . str_random(5));
        }
        $postdata['slug']       = $slug;
        $postdata['type']       = 'shopping_guide';
        $postdata['sorting']    = $count + 1;

        $content      = Content::findOrFail($id);
        $logDesc      = 'Edit shopping guide ' . $content->title;
        insertRhapsodieLog($logDesc, 'shopping_guide', CRUDBooster::myId(), json_encode(array_diff($postdata, $content->toArray())));
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
        // $faq          = Content::findOrFail($id);
        // $logDesc      = 'Delete shopping guide ' . $faq->question;
        // insertRhapsodieLog($logDesc, 'shopping_guide', CRUDBooster::myId(), $faq->toJson());
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

    public function getSetOrder($status, $id, $sorting)
    {
        if ($status == 'up') {
            DB::table('contents')->where('type', 'shopping_guide')->where('sorting', $sorting - 1)->update(['sorting' => $sorting]);
            DB::table('contents')->where('type', 'shopping_guide')->where('id', $id)->update(['sorting' => ($sorting - 1)]);
        } else {
            DB::table('contents')->where('type', 'shopping_guide')->where('sorting', $sorting + 1)->update(['sorting' => $sorting]);
            DB::table('contents')->where('type', 'shopping_guide')->where('id', $id)->update(['sorting' => ($sorting + 1)]);
        }

        CRUDBooster::redirect($_SERVER['HTTP_REFERER'], '', '');
        //This will redirect back and gives a message
    }
}
