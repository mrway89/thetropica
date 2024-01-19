<?php

namespace App\Http\Controllers;

use App\Category;
use App\UserServiceProvider;
use CRUDBooster;

class AdminServiceProviderListController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {
        // START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field         = 'id';
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
        $this->button_export       = true;
        $this->table               = 'user_service_providers';
        // END CONFIGURATION DO NOT REMOVE THIS LINE

        // START COLUMNS DO NOT REMOVE THIS LINE
        $this->col   = [];
        $this->col[] = ['label'=>'Logo', 'name'=>'logo', 'image'=>true];
        $this->col[] = ['label'=>'Cover', 'name'=>'cover', 'image'=>true];
        $this->col[] = ['label'=>'User Id', 'name'=>'user_id', 'join'=>'users,name'];
        $this->col[] = ['label'=>'Name', 'name'=>'name'];
        $this->col[] = ['label'=>'Category Id', 'name'=>'category_id', 'join'=>'categories,title'];
        $this->col[] = ['label'=>'Email', 'name'=>'email'];
        $this->col[] = ['label'=>'Phone', 'name'=>'phone'];
        // $this->col[] = ['label'=>'Website', 'name'=>'website'];
        // $this->col[] = ['label'=>'Instagram', 'name'=>'instagram'];
        // $this->col[] = ['label'=>'Facebook', 'name'=>'facebook'];
        // END COLUMNS DO NOT REMOVE THIS LINE

        // START FORM DO NOT REMOVE THIS LINE
        $this->form   = [];
        $this->form[] = ['label'=>'Logo Image', 'name'=>'logo', 'type'=>'upload', 'validation'=>'image|max:1000', 'upload_encrypt' => 'true', 'width'=>'col-sm-10', 'help'=>'Best resolution: 500 x 500px, Max file Size: 1 Mb'];
        $this->form[] = ['label'=>'Cover Image', 'name'=>'cover', 'type'=>'upload', 'validation'=>'image|max:1000', 'upload_encrypt' => 'true', 'width'=>'col-sm-10', 'help'=>'Best resolution: 666 x 250px, Max file Size: 1 Mb'];
        $this->form[] = ['label'=>'Name', 'name'=>'name', 'type'=>'text', 'validation'=>'required', 'width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Type', 'name'=>'category_id', 'type'=>'select2', 'datatable'=>'categories,title', 'datatable_where'=>'type = "service_provider_type"', 'width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Email', 'name'=>'email', 'type'=>'email', 'validation'=>'required|min:1|max:255|email|unique:user_service_providers', 'width'=>'col-sm-10', 'datatable'=>'category,id'];
        $this->form[] = ['label'=>'Phone', 'name'=>'phone', 'type'=>'text', 'validation'=>'', 'width'=>'col-sm-10', 'placeholder'=>'Please enter a valid email address'];
        $this->form[] = ['label'=>'Website', 'name'=>'website', 'type'=>'text', 'validation'=>'', 'width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Instagram', 'name'=>'instagram', 'type'=>'text', 'validation'=>'', 'width'=>'col-sm-10', 'placeholder' => 'https://www.instagram.com/dotcomsolution', 'help' => 'Please input full url. example:https://www.instagram.com/dotcomsolution'];
        $this->form[] = ['label'=>'Facebook', 'name'=>'facebook', 'type'=>'text', 'validation'=>'', 'width'=>'col-sm-10', 'placeholder' => 'https://www.facebook.com/dotcomsolution', 'help' => 'Please input full url. example:https://www.facebook.com/dotcomsolution'];
        $this->form[] = ['label'=>'Twitter', 'name'=>'twitter', 'type'=>'text', 'validation'=>'', 'width'=>'col-sm-10', 'placeholder' => 'https://www.twitter.com/dotcomsolution', 'help' => 'Please input full url. example:https://www.twitter.com/dotcomsolution'];
        // $this->form[] = ['label'=>'Province', 'name'=>'province', 'type'=>'select2', 'validation'=>'required|min:1|max:255', 'width'=>'col-sm-10', 'dataenum' => 'Bali|Bali;Bangka Belitung|Bangka Belitung;Banten|Banten;Bengkulu|Bengkulu;DI Yogyakarta|DI Yogyakarta;DKI Jakarta|DKI Jakarta;Gorontalo|Gorontalo;Jambi|Jambi;Jawa Barat|Jawa Barat;Jawa Tengah|Jawa Tengah;Jawa Timur|Jawa Timur;Kalimantan Barat|Kalimantan Barat;Kalimantan Selatan|Kalimantan Selatan;Kalimantan Tengah|Kalimantan Tengah;Kalimantan Timur|Kalimantan Timur;Kalimantan Utara|Kalimantan Utara;Kepulauan Riau|Kepulauan Riau;Lampung|Lampung;Maluku|Maluku;Maluku Utara|Maluku Utara;Nanggroe Aceh Darussalam (NAD)|Nanggroe Aceh Darussalam (NAD);Nusa Tenggara Barat (NTB)|Nusa Tenggara Barat (NTB);Nusa Tenggara Timur (NTT)|Nusa Tenggara Timur (NTT);Papua|Papua;Papua Barat|Papua Barat;Riau|Riau;Sulawesi Barat|Sulawesi Barat;Sulawesi Selatan|Sulawesi Selatan;Sulawesi Tengah|Sulawesi Tengah;Sulawesi Tenggara|Sulawesi Tenggara;Sulawesi Utara|Sulawesi Utara;Sumatera Barat|Sumatera Barat;Sumatera Selatan|Sumatera Selatan;Sumatera Utara|Sumatera Utara'];
        $this->form[] = ['label'=>'Short Description', 'name'=>'short_description', 'type'=>'textarea', 'validation'=>'required|string|min:5|max:5000', 'width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Description', 'name'=>'description', 'type'=>'wysiwyg', 'validation'=>'required|string|min:5|max:5000', 'width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Information', 'name'=>'information', 'type'=>'wysiwyg', 'validation'=>'required|string|min:5|max:5000', 'width'=>'col-sm-10'];
        $this->form[] = [
            'label' => 'Service Provided',
            'name'  => 'services',
            'type'  => 'text',
            'width' => 'col-sm-10',
            'help'  => 'Separate with comma ( , )'
        ];
        // $this->form[] = ['label'=>'Parent Id', 'name'=>'user_service_provider_id', 'type'=>'hidden', 'validation'=>'required', 'width'=>'col-sm-9', 'value'=> request('parent_id')];
        // END FORM DO NOT REMOVE THIS LINE

        // OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"User Id","name"=>"user_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"user,id"];
        //$this->form[] = ["label"=>"Category Id","name"=>"category_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"category,id"];
        //$this->form[] = ["label"=>"Email","name"=>"email","type"=>"email","required"=>TRUE,"validation"=>"required|min:1|max:255|email|unique:user_service_providers","placeholder"=>"Please enter a valid email address"];
        //$this->form[] = ["label"=>"Phone","name"=>"phone","type"=>"number","required"=>TRUE,"validation"=>"required|numeric","placeholder"=>"You can only enter the number only"];
        //$this->form[] = ["label"=>"Website","name"=>"website","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Instagram","name"=>"instagram","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Facebook","name"=>"facebook","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Twitter","name"=>"twitter","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Province","name"=>"province","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Description","name"=>"description","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
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
        // $this->sub_module[] = ['label'=>'Projects', 'path'=>'service_provider_project', 'foreign_key'=>'user_service_provider_id', 'button_color'=>'info', 'button_icon'=>'fa fa-image'];
        $this->sub_module[] = ['label'=>'Projects', 'path'=>'service_provider_project', 'parent_columns'=>'name,short_description', 'foreign_key'=>'user_service_provider_id', 'button_color'=>'info', 'button_icon'=>'fa fa-image'];

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
        $slug                   = str_slug($postdata['name']);
        $checkSlug              = UserServiceProvider::where('slug', str_slug($postdata['name']))->get()->count();
        if ($checkSlug > 1) {
            $slug = str_slug($postdata['name'] . '-' . str_random(5));
        }
        $postdata['slug']       = $slug;

        $serv         = UserServiceProvider::findOrFail($id);
        $logDesc      = 'Edit service provider ' . $serv->name;
        insertRhapsodieLog($logDesc, 'service_provider', CRUDBooster::myId(), json_encode(array_diff($postdata, $serv->toArray())));
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
        $serv         = UserServiceProvider::findOrFail($id);
        $logDesc      = 'Delete service provider ' . $serv->name;
        insertRhapsodieLog($logDesc, 'service_provider', CRUDBooster::myId(), $serv->toJson());
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

    // public function getEdit($id)
    // {
    //     if (!CRUDBooster::isUpdate() && $this->global_privilege == false || $this->button_edit == false) {
    //         CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
    //     }

    //     $types                 = Category::where('type', 'service_provider_type')->orderBy('title', 'ASC')->get();
    //     $provider              = UserServiceProvider::where('id', $id)->first();
    //     $data                  = [];
    //     $data['page_title']    = 'Manage Provider';
    //     $data['form_type']     = 'Edit';
    //     $data['edit']          = true;
    //     $data['provider']      = $provider;
    //     $data['types']         = $types;
    //     // $data['midtrans']     = json_decode($order->midtrans);

    //     $this->cbView('vendor/crudbooster/provider_management', $data);
    // }
}
