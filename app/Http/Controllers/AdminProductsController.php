<?php

namespace App\Http\Controllers;

use App\Category;
use App\Feature;
use App\OrderDetail;
use App\Origin;
use App\Product;
use App\ProductBrand;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use DB;
use Illuminate\Http\Request;
use Validator;

class AdminProductsController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {
        // START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field         = 'name';
        $this->limit               = '20';
        $this->orderby             = 'sorting,asc';
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
        $this->button_export       = true;
        $this->table               = 'products';
        // END CONFIGURATION DO NOT REMOVE THIS LINE
        $max_sorting        = DB::table($this->table)->max('sorting');

        // START COLUMNS DO NOT REMOVE THIS LINE
        $this->col   = [];
        $this->col[] = ['label' => 'Default Image', 'name' => '(select url from images where images.item_id = products.id and images.is_featured=1 and images.type="product") as img', 'image' => true, 'callback' => function ($row) {
            if ($row->img) {
                return '<img src="' . asset($row->img) . '" width=40 height=40></img>';
            } else {
                return '<img src="' . asset('assets/img/no-img.svg') . '" width=40 height=40></img>';
            }
        }];
        $this->col[] = ['label' => 'Name', 'name' => 'name', 'callback' => function ($row) {
            return $row->name . ' ' . $row->product_weight . ' ' . $row->unit;
        }];
        // $this->col[] = ['label' => 'Name', 'name' => '(select name from origins where origins.id = products.origin_id) as origin', 'image' => true, 'callback' => function ($row) {
        //     $origin = explode(',', $row->origin);
        //     return $row->name . ' ' . $origin[0];
        // }];
        //$this->col[] = ['label' => 'Brand', 'name' => 'brand_id', 'join' => 'product_brands,name'];
        $this->col[] = ['label' => 'Category', 'name' => 'category_id', 'join' => 'categories,title_en'];
        //$this->col[] = ['label' => 'Origin', 'name' => 'origin_id', 'join' => 'origins,name'];
        $this->col[] = ['label' => 'Price', 'name' => 'price', 'callback' => function ($row) {
            return currency_format($row->price);
        }];
        // $this->col[] = ['label'=> 'Discounted Price', 'name'=>'discounted_price', 'callback'=>function ($row) {
        //     if ($row->discounted_price) {
        //         return currency_format($row->discounted_price);
        //     }
        // }];
        $this->col[] = ['label' => 'Description ID', 'name' => 'description_id', 'visible' => false];
        $this->col[] = ['label' => 'Description EN', 'name' => 'description_en', 'visible' => false];
        $this->col[] = ['label' => 'Information', 'name' => 'information', 'visible' => false];
        $this->col[] = ['label' => 'Specification', 'name' => 'specification', 'visible' => false];
        $this->col[] = ['label' => 'Features', 'name' => 'features', 'visible' => false];
        $this->col[] = ['label' => 'SKU', 'name' => 'sku', 'visible' => false];
        $this->col[] = ['label' => 'Type', 'name' => 'type', 'visible' => false];
        $this->col[] = ['label' => 'Tags', 'name' => 'tags', 'visible' => false];
        $this->col[] = ['label' => 'View', 'name' => 'view'];
        $this->col[] = ['label' => 'Weight', 'name' => 'weight'];
        $this->col[] = ['label' => 'Product Nett Weight', 'name' => 'product_weight', 'visible' => false];
        $this->col[] = ['label' => 'Unit', 'name' => 'unit', 'visible' => false];
        $this->col[] = ['label' => 'Sorting', 'name' => 'sorting', 'visible' => false];
        $this->col[] = ['label' => 'Stock', 'name' => 'stock'];
        $this->col[] = ['label' => 'Sold', 'name' => 'id', 'callback' => function ($row) {
            $orders = OrderDetail::where('product_id', $row->id)->whereHas('order', function ($e) {
                $e->whereIn('status', ['paid', 'sent', 'completed']);
            })->select(DB::raw('SUM(quantity) as qty'))->get();

            return $orders->first()->qty;
        }];
        $this->col[] = ['label' => 'Link', 'name' => 'slug', 'callback' => function ($row) {
            return '<a href="' . route('frontend.product.detail', $row->slug) . '" target="_blank">Link</a>';
        }];
        $this->col[] = ['label' => 'Active', 'name' => 'is_active', 'callback' => function ($row) {
            if ($row->is_active == 1) {
                return '<span class="label label-success">Active</span>';
            } else {
                return '<span class="label label-warning">Inactive</span>';
            }
        }];
        $this->col[] = ['label' => 'Purchase Limit Qty', 'name' => 'purchase_limit_qty'];
        $this->col[] = ['label' => 'Purchase Limit for (days)', 'name' => 'purchase_limit_days'];
        // END COLUMNS DO NOT REMOVE THIS LINE

        // START FORM DO NOT REMOVE THIS LINE
        $this->form   = [];
        $this->form[] = ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'validation' => 'required|string|min:3|max:70', 'width' => 'col-sm-10', 'placeholder' => 'You can only enter the letter only'];
        // $this->form[] = ['label'=>'Active', 'name'=>'is_active', 'type'=>'checkbox', 'validation'=>'boolean', 'width'=>'col-sm-10'];
        $this->form[] = ['label' => 'Category', 'name' => 'category_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'categories,title_en'];
        //$this->form[] = ['label' => 'Brand', 'name' => 'brand_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'product_brands,name'];
        $this->form[] = ['label' => 'Features', 'name' => 'features', 'type' => 'text', 'validation' => 'required', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Description', 'name' => 'description_en', 'type' => 'wysiwyg', 'validation' => 'required|string|min:5|max:500', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Information', 'name' => 'information', 'type' => 'wysiwyg', 'validation' => 'required|string|min:5|max:500', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Price', 'name' => 'price', 'type' => 'number', 'validation' => 'required|min:1|integer', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Weight', 'name' => 'weight', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Stock', 'name' => 'stock', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Sku', 'name' => 'sku', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Id', 'name' => 'id', 'type' => 'hidden', 'width' => 'col-sm-9', 'value' => request('id')];
        $this->form[] = ['label' => 'Purchase Limit Qty', 'name' => 'purchase_limit_qty', 'type' => 'number', 'width' => 'col-sm-10', 'placeholder' => 'Purchase limit Qty, left it blank for unlimited'];
        $this->form[] = ['label' => 'Purchase Limit for (days)', 'name' => 'purchase_limit_days', 'type' => 'number', 'width' => 'col-sm-10', 'placeholder' => "Days until there rule reset, left it blank will disable rule"];
        // END FORM DO NOT REMOVE THIS LINE

        // OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"Name","name"=>"name","type"=>"text","required"=>TRUE,"validation"=>"required|string|min:3|max:70","placeholder"=>"You can only enter the letter only"];
        //$this->form[] = ["label"=>"Category Id","name"=>"category_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"category,id"];
        //$this->form[] = ["label"=>"Slug","name"=>"slug","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Description","name"=>"description","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
        //$this->form[] = ["label"=>"Price","name"=>"price","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Weight","name"=>"weight","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Stock","name"=>"stock","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Sold","name"=>"sold","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Is Active","name"=>"is_active","type"=>"radio","required"=>TRUE,"validation"=>"required|integer","dataenum"=>"Array"];
        //$this->form[] = ["label"=>"Sku","name"=>"sku","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
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
        $this->sub_module[] = ['label' => 'Images', 'path' => 'product_images', 'foreign_key' => 'item_id', 'button_color' => 'info', 'button_icon' => 'fa fa-image'];
        $this->sub_module[] = ['label' => 'Certification', 'path' => 'product_certification', 'foreign_key' => 'item_id', 'button_color' => 'success', 'button_icon' => 'fa fa-image'];
        $this->sub_module[] = ['label' => 'Related', 'path' => 'product_relateds', 'parent_columns' => 'name,product_weight', 'foreign_key' => 'product_id', 'button_color' => 'primary', 'button_icon' => 'fa fa-bars'];

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
        $this->style_css = '';

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
        if (is_array($id)) {
            $product      = Product::findOrFail($id[0]);
        } else {
            $product      = Product::findOrFail($id);
        }

        $logDesc      = 'Delete product ' . $product->name;
        insertRhapsodieLog($logDesc, 'product', CRUDBooster::myId(), $product->toJson());
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
        if (!CRUDBooster::isCreate() && $this->global_privilege == false || $this->button_add == false) {
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        }

        $brands   = ProductBrand::orderBy('name')->get();
        $origins  = Origin::orderBy('name')->get();

        $data                = [];
        $data['page_title']  = 'Add New Product';
        $data['form_type']   = 'Add';
        $data['categories']  = $this->getLowestCategory();
        $data['brands']      = $brands;
        $data['origins']     = $origins;

        $this->cbView('vendor/crudbooster/product_management', $data);
    }

    public function getEdit($id)
    {
        if (!CRUDBooster::isUpdate() && $this->global_privilege == false || $this->button_edit == false) {
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        }

        $product  = Product::findOrFail($id);
        $brands   = ProductBrand::orderBy('name')->get();
        $origins  = Origin::orderBy('name')->get();

        $data                = [];
        $data['edit']        = true;
        $data['page_title']  = 'Edit Product ' . $product->name;
        $data['form_type']   = 'Edit';
        $data['categories']  = $this->getLowestCategory();
        $data['brands']      = $brands;
        $data['origins']     = $origins;
        $data['product']     = $product;

        $this->cbView('vendor/crudbooster/product_management', $data);
    }

    public function postSaveProduct(Request $request)
    {
        $unique = '|unique:products';
        $edit   = $request->id;
        if ($edit) {
            $unique = '';
        }
        $validator = Validator::make(
            $request->all(),
            [
                'name'             => 'required',
                'category_id'      => 'required|integer',
                //'origin_id'        => 'required|integer',
                //'brand_id'         => 'required|integer',
                'price'            => 'required|integer',
                'weight'           => 'required|integer',
                'stock'            => 'required|integer',
                'sku'              => 'required',
                'description_id'   => 'required',
                'description_en'   => 'required',
                'slug'             => 'required',
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            $res     = redirect()->back()->with(['message' => implode('<br/>', $message), 'message_type' => 'warning'])->withInput();
            \Session::driver()->save();
            $res->send();
            exit;
        } else {
            //$origin      = Origin::find($request->origin_id);
            $productSlug = $request->slug;

            if ($edit) {
                $product                = Product::findOrFail($edit);
                $oldValue               = $product;
            } else {
                $product                = new Product;
            }

            $specData                         = $this->setSpecification($request);

            $prdBrand = ProductBrand::find($request->brand_id);

            $product->name                     = $request->name;
            $product->note                     = $request->note;
            $product->category_id              = $request->category_id;
            //$product->origin_id                = $request->origin_id;
            //$product->brand_id                 = $request->brand_id;
            $product->brand_name               = $prdBrand->name;
            $product->features                 = strtolower($request->features);
            $product->tags                     = strtolower($request->tags);
            $product->price                    = $request->price;
            $product->discounted_price         = $request->discounted_price;
            $product->weight                   = $request->weight;
            $product->product_weight           = $request->product_weight;
            $product->stock                    = $request->stock;
            $product->sku                      = $request->sku;
            $product->packaging_type           = $request->packaging_type;
            $product->unit                     = $request->unit;
            $product->purchase_limit_qty       = $request->purchase_limit_qty;
            $product->purchase_limit_days      = $request->purchase_limit_days;
            $product->title_description_id     = $request->title_description_id;
            $product->title_description_en     = $request->title_description_en;
            $product->title_description_two_id = $request->title_description_two_id;
            $product->title_description_two_en = $request->title_description_two_en;
            $product->title_description_three_id = $request->title_description_three_id;
            $product->title_description_three_en = $request->title_description_three_en;
            $product->description_id           = $request->description_id;
            $product->description_en           = $request->description_en;
            $product->specification            = $specData;
            $product->slug                     = $request->slug;
            $product->is_active                = $request->is_active;

            $productCount                      = Product::count();

            if ($edit) {
                $product->type = $oldValue->type;
            } else {
                $product->type              = 'product';
                $product->sorting           = $productCount + 1;
            }
            $product->save();

            $this->saveFeatures($request->features);

            if ($edit) {
                $logDesc = 'Update ' . $product->name . ' detail';
            } else {
                $logDesc = 'Create new product ' . $request->name;
            }

            insertRhapsodieLog($logDesc, 'product', CRUDBooster::myId(), json_encode($request->all()));

            if ($edit) {
                return redirect('admin/products')->with(['message' => 'Product Has been saved', 'message_type' => 'success'])->send();
                exit;
            } else {
                return redirect('admin/product_images?parent_table=products&parent_columns=&parent_columns_alias=&parent_id=' . $product->id)->with(['message' => 'Product Has been saved', 'message_type' => 'success'])->send();
                exit;
            }
        }
    }

    private function setSpecification($request)
    {
        $specData = [];

        for ($i = 0; $i < count($request->specnameid); $i++) {
            $specData[] = [
                'name_id'  => $request->specnameid[$i],
                'value_id' => $request->speccontentid[$i],
                'name_en'  => $request->specnameen[$i],
                'value_en' => $request->speccontenten[$i],
            ];
        }

        return json_encode($specData);
    }

    private function setSlug($name, $edit = false)
    {
        $slug       = str_slug($name);

        $checkSlug  = Product::where('slug', str_slug($name))->get()->count();

        if ($edit) {
            if ($checkSlug >= 1) {
                $slug = str_slug($name . '-' . str_random(5));
            }
        } else {
            if ($checkSlug >= 1) {
                $slug = str_slug($name . '-' . str_random(5));
            }
        }

        return $slug;
    }

    private function getLowestCategory()
    {
        $cat = Category::where('type', 'product')->orderBy('title_en', 'ASC')->get();

        // $categories = [];
        // foreach ($cat as $dt) {
        //     if ($dt->parent->parent->id) {
        //         array_push($categories, $dt);
        //     }
        // }

        return $cat;
    }

    private function saveFeatures($features)
    {
        // if ($features) {
        //     $featuresArray = explode(',', str_replace(' ', '', $features));

        //     foreach ($featuresArray as $key => $value) {
        //         $checkExist = Feature::where('name', strtolower($value))->first();
        //         if (!$checkExist) {
        //             $feature       = new Feature;
        //             $feature->name = $value;
        //             $feature->save();
        //         }
        //     }
        // }

        return true;
    }

    public function getSetOrder($status, $id, $sorting)
    {
        if ($status == 'up') {
            DB::table('products')->where('sorting', $sorting - 1)->update(['sorting' => $sorting]);
            DB::table('products')->where('id', $id)->update(['sorting' => ($sorting - 1)]);
        } else {
            DB::table('products')->where('sorting', $sorting + 1)->update(['sorting' => $sorting]);
            DB::table('products')->where('id', $id)->update(['sorting' => ($sorting + 1)]);
        }

        CRUDBooster::redirect($_SERVER['HTTP_REFERER'], '', '');
        //This will redirect back and gives a message
    }
}
