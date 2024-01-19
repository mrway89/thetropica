<?php

namespace App\Http\Controllers;

use App\Post;
use crocodicstudio\crudbooster\helpers\CRUDBooster;

class AdminCheckoutPaymentInstructionController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {
        // START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table                        = 'posts';
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
        $this->button_filter       = true;
        $this->button_export       = false;
        $this->button_import       = false;
        $this->button_bulk_action  = true;
        $this->sidebar_mode              = 'normal'; //normal,mini,collapse,collapse-mini
        // END CONFIGURATION DO NOT REMOVE THIS LINE

        // START COLUMNS DO NOT REMOVE THIS LINE
        $this->col   = [];
        $this->col[] = ['label' => 'Type', 'name' => 'type', 'callback' => function ($row) {
            if ($row->type) {
                return '<b>' . strtoupper($row->type) . '</b>';
            }
        }];
        $this->col[] = ['label' => 'Title', 'name' => 'title'];

        // END COLUMNS DO NOT REMOVE THIS LINE
        // START FORM DO NOT REMOVE THIS LINE
        $this->form   = [];
        $this->form[] = ['label' => 'Type', 'name' => 'type', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-9', 'dataenum' => 'bca|Bank BCA;mandiri|Bank Mandiri;permata|Bank Permata;bni|Bank BNI;indomaret|Indomaret'];
        $this->form[] = ['label' => 'Title', 'name' => 'title', 'type' => 'text', 'required' => true, 'validation' => 'required|string|min:3|max:70', 'placeholder' => ''];
        $this->form[] = ['label' => 'Content', 'name' => 'content', 'type' => 'wysiwyg', 'required' => true, 'validation' => 'required|string|min:5|max:5000'];

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
        $this->script_js = '
				$(function() {
					$(".btn-default").hide();
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
        $query->where('category_id', null);
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
        $faq          = Post::findOrFail($id);
        $logDesc      = 'Add new payment instruction ' . strtoupper($faq->type) . '-' . $faq->title;
        insertRhapsodieLog($logDesc, 'payment_instruction', CRUDBooster::myId(), $faq->toJson());
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
        $faq          = Post::findOrFail($id);
        $logDesc      = 'Edit payment instruction ' . strtoupper($faq->type) . '-' . $faq->title;
        insertRhapsodieLog($logDesc, 'payment_instruction', CRUDBooster::myId(), json_encode(array_diff($postdata, $faq->toArray())));
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
        // $faq          = Post::findOrFail($id);
        // $logDesc      = 'Delete how to ' . strtoupper($faq->type) . '-' . $faq->title;
        // insertRhapsodieLog($logDesc, 'payment_instruction', CRUDBooster::myId(), $faq->toJson());
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
