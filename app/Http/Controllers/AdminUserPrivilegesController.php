<?php

namespace App\Http\Controllers;

use CRUDBooster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class AdminUserPrivilegesController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {
        // START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field         = 'name';
        $this->limit               = '20';
        $this->orderby             = 'id,desc';
        $this->title_field         = 'name';
        $this->button_import       = false;
        $this->button_export       = false;
        $this->button_action_style = 'button_icon';
        $this->button_detail       = false;
        $this->button_bulk_action  = false;

        $this->table = 'cms_privileges';
        // END CONFIGURATION DO NOT REMOVE THIS LINE

        $this->col   = [];
        $this->col[] = ['label' => 'ID', 'name' => 'id'];
        $this->col[] = ['label' => 'Name', 'name' => 'name'];

        $this->form   = [];
        $this->form[] = ['label' => 'Name', 'name' => 'name', 'required' => true];

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
        $query->where('id', '>', 1);
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
    public function getAdd()
    {
        $this->cbLoader();

        if (!CRUDBooster::isCreate() && $this->global_privilege == false) {
            CRUDBooster::insertLog(trans('crudbooster.log_try_add', ['module' => CRUDBooster::getCurrentModule()->name]));
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        }

        $id                 = 0;
        $data['page_title'] = 'Add Data';
        $data['moduls']     = DB::table('cms_moduls')
                            ->where('is_protected', 0)->whereNull('deleted_at')
                            ->where('id', '<>', 4)
                            ->where('id', '<>', 22)
                            ->select('cms_moduls.*', DB::raw("(select is_visible from cms_privileges_roles where id_cms_moduls = cms_moduls.id and id_cms_privileges = '$id') as is_visible"), DB::raw("(select is_create from cms_privileges_roles where id_cms_moduls  = cms_moduls.id and id_cms_privileges = '$id') as is_create"), DB::raw("(select is_read from cms_privileges_roles where id_cms_moduls    = cms_moduls.id and id_cms_privileges = '$id') as is_read"), DB::raw("(select is_edit from cms_privileges_roles where id_cms_moduls    = cms_moduls.id and id_cms_privileges = '$id') as is_edit"), DB::raw("(select is_delete from cms_privileges_roles where id_cms_moduls  = cms_moduls.id and id_cms_privileges = '$id') as is_delete"))->orderby('name', 'asc')->get();
        $data['page_menu'] = Route::getCurrentRoute()->getActionName();

        return view('vendor/crudbooster/privileges', $data);
    }

    public function postAddSave()
    {
        $this->cbLoader();

        if (!CRUDBooster::isCreate() && $this->global_privilege == false) {
            CRUDBooster::insertLog(trans('crudbooster.log_try_add_save', [
                'name'   => Request::input($this->title_field),
                'module' => CRUDBooster::getCurrentModule()->name,
            ]));
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        }

        $this->validation($request);
        $this->input_assignment($request);

        $this->arr[$this->primary_key] = DB::table($this->table)->max($this->primary_key) + 1;

        DB::table($this->table)->insert($this->arr);
        $id = $this->arr[$this->primary_key];

        //set theme
        Session::put('theme_color', $this->arr['theme_color']);

        $priv = Request::input('privileges');
        if ($priv) {
            foreach ($priv as $id_modul => $data) {
                $arrs                      = [];
                $arrs['id']                = DB::table('cms_privileges_roles')->max('id') + 1;
                $arrs['is_visible']        = @$data['is_visible'] ?: 0;
                $arrs['is_create']         = @$data['is_create'] ?: 0;
                $arrs['is_read']           = @$data['is_read'] ?: 0;
                $arrs['is_edit']           = @$data['is_edit'] ?: 0;
                $arrs['is_delete']         = @$data['is_delete'] ?: 0;
                $arrs['id_cms_privileges'] = $id;
                $arrs['id_cms_moduls']     = $id_modul;
                DB::table('cms_privileges_roles')->insert($arrs);

                $module = DB::table('cms_moduls')->where('id', $id_modul)->first();
            }
        }

        //Refresh Session Roles
        $roles = DB::table('cms_privileges_roles')->where('id_cms_privileges', CRUDBooster::myPrivilegeId())->join('cms_moduls', 'cms_moduls.id', '=', 'id_cms_moduls')->select('cms_moduls.name', 'cms_moduls.path', 'is_visible', 'is_create', 'is_read', 'is_edit', 'is_delete')->get();
        Session::put('admin_privileges_roles', $roles);

        CRUDBooster::redirect(CRUDBooster::mainpath(''), trans('crudbooster.alert_add_data_success'), 'success');
    }

    public function getEdit($id)
    {
        $this->cbLoader();

        $row = DB::table($this->table)->where('id', $id)->first();

        if (!CRUDBooster::isRead() && $this->global_privilege == false) {
            CRUDBooster::insertLog(trans('crudbooster.log_try_edit', [
                'name'   => $row->{$this->title_field},
                'module' => CRUDBooster::getCurrentModule()->name,
            ]));
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        }

        $page_title = trans('crudbooster.edit_data_page_title', ['module' => 'Privilege', 'name' => $row->name]);

        $moduls    = DB::table('cms_moduls')->where('is_protected', 0)->where('deleted_at', null)->select('cms_moduls.*')->orderby('name', 'asc')->get();
        $page_menu = Route::getCurrentRoute()->getActionName();

        return view('vendor/crudbooster/privileges', compact('row', 'page_title', 'moduls', 'page_menu'));
    }

    public function postEditSave($id)
    {
        $this->cbLoader();

        $row = CRUDBooster::first($this->table, $id);

        if (!CRUDBooster::isUpdate() && $this->global_privilege == false) {
            CRUDBooster::insertLog(trans('crudbooster.log_try_add', ['name' => $row->{$this->title_field}, 'module' => CRUDBooster::getCurrentModule()->name]));
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        }

        $this->validation($id);
        $this->input_assignment($id);

        DB::table($this->table)->where($this->primary_key, $id)->update($this->arr);

        $priv = Request::input('privileges');

        // This solves issue #1074
        DB::table('cms_privileges_roles')->where('id_cms_privileges', $id)->delete();

        if ($priv) {
            foreach ($priv as $id_modul => $data) {
                //Check Menu
                $module            = DB::table('cms_moduls')->where('id', $id_modul)->first();
                $currentPermission = DB::table('cms_privileges_roles')->where('id_cms_moduls', $id_modul)->where('id_cms_privileges', $id)->first();

                if ($currentPermission) {
                    $arrs               = [];
                    $arrs['is_visible'] = @$data['is_visible'] ?: 0;
                    $arrs['is_create']  = @$data['is_create'] ?: 0;
                    $arrs['is_read']    = @$data['is_read'] ?: 0;
                    $arrs['is_edit']    = @$data['is_edit'] ?: 0;
                    $arrs['is_delete']  = @$data['is_delete'] ?: 0;
                    DB::table('cms_privileges_roles')->where('id', $currentPermission->id)->update($arrs);
                } else {
                    $arrs                      = [];
                    $arrs['id']                = DB::table('cms_privileges_roles')->max('id') + 1;
                    $arrs['is_visible']        = @$data['is_visible'] ?: 0;
                    $arrs['is_create']         = @$data['is_create'] ?: 0;
                    $arrs['is_read']           = @$data['is_read'] ?: 0;
                    $arrs['is_edit']           = @$data['is_edit'] ?: 0;
                    $arrs['is_delete']         = @$data['is_delete'] ?: 0;
                    $arrs['id_cms_privileges'] = $id;
                    $arrs['id_cms_moduls']     = $id_modul;
                    DB::table('cms_privileges_roles')->insert($arrs);
                }
            }
        }

        //Refresh Session Roles
        if ($id == CRUDBooster::myPrivilegeId()) {
            $roles = DB::table('cms_privileges_roles')->where('id_cms_privileges', CRUDBooster::myPrivilegeId())->join('cms_moduls', 'cms_moduls.id', '=', 'id_cms_moduls')->select('cms_moduls.name', 'cms_moduls.path', 'is_visible', 'is_create', 'is_read', 'is_edit', 'is_delete')->get();
            Session::put('admin_privileges_roles', $roles);

            Session::put('theme_color', $this->arr['theme_color']);
        }

        CRUDBooster::redirect(CRUDBooster::mainpath(), trans('crudbooster.alert_update_data_success', [
            'module' => 'Privilege',
            'title'  => $row->name,
        ]), 'success');
    }

    public function getDelete($id)
    {
        $this->cbLoader();

        $row = DB::table($this->table)->where($this->primary_key, $id)->first();

        if (!CRUDBooster::isDelete() && $this->global_privilege == false) {
            CRUDBooster::insertLog(trans('crudbooster.log_try_delete', [
                'name'   => $row->{$this->title_field},
                'module' => CRUDBooster::getCurrentModule()->name,
            ]));
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        }

        DB::table($this->table)->where($this->primary_key, $id)->delete();
        DB::table('cms_privileges_roles')->where('id_cms_privileges', $row->id)->delete();

        CRUDBooster::redirect(CRUDBooster::mainpath(), trans('crudbooster.alert_delete_data_success'), 'success');
    }
}
