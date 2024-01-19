<?php

namespace App\Http\Controllers;

class AdminUserLogController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {
        $this->table              = 'rhapsodie_logs';
        $this->primary_key        = 'id';
        $this->title_field        = 'ipaddress';
        $this->button_bulk_action = true;
        $this->button_export      = true;
        $this->button_import      = false;
        $this->button_add         = false;
        $this->button_edit        = false;
        $this->button_delete      = true;
        $this->button_show        = false;

        $this->col   = [];
        $this->col[] = ['label' => 'Time Access', 'name' => 'created_at'];
        $this->col[] = ['label' => 'Type', 'name' => 'type'];
        $this->col[] = ['label' => 'IP Address', 'name' => 'ipaddress'];
        $this->col[] = ['label' => 'User', 'name' => 'id_cms_users', 'join' => config('crudbooster.USER_TABLE') . ',name'];
        $this->col[] = ['label' => 'Description', 'name' => 'description'];
        $this->col[] = ['label' => 'Details', 'name' => 'details', 'visible' => false];

        $this->form   = [];
        $this->form[] = ['label' => 'Time Access', 'name' => 'created_at', 'readonly' => true];
        $this->form[] = ['label' => 'IP Address', 'name' => 'ipaddress', 'readonly' => true];
        $this->form[] = ['label' => 'User Agent', 'name' => 'useragent', 'readonly' => true];
        $this->form[] = ['label' => 'URL', 'name' => 'url', 'readonly' => true];
        $this->form[] = [
            'label'     => 'User',
            'name'      => 'id_cms_users',
            'type'      => 'select',
            'datatable' => config('crudbooster.USER_TABLE') . ',name',
            'readonly'  => true,
        ];
        $this->form[] = ['label' => 'Description', 'name' => 'description', 'readonly' => true];
        $this->form[] = ['label' => 'Details', 'name' => 'details', 'type' => 'text'];
    }

    public function hook_query_index(&$query)
    {
        $query->where('id_cms_users', '!=', 1);
    }

    // public static function displayDiff($old_values, $new_values)
    // {
    //     $diff  = self::getDiff($old_values, $new_values);
    //     $table = '<table class="table table-striped"><thead><tr><th>Key</th><th>Old Value</th><th>New Value</th></thead><tbody>';
    //     foreach ($diff as $key => $value) {
    //         $table .= "<tr><td>$key</td><td>$old_values[$key]</td><td>$new_values[$key]</td></tr>";
    //     }
    //     $table .= '</tbody></table>';

    //     return $table;
    // }

    // private static function getDiff($old_values, $new_values)
    // {
    //     unset($old_values['id'], $old_values['created_at'], $old_values['updated_at'], $new_values['created_at'], $new_values['updated_at']);

    //     return array_diff($old_values, $new_values);
    // }
}
