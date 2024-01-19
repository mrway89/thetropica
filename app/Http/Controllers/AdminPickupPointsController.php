<?php namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use DB;
use CRUDBooster;
use App\Pickpoint;
use Validator;

class AdminPickupPointsController extends \crocodicstudio\crudbooster\controllers\CBController
{

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "name";
		$this->limit = "20";
		$this->orderby = "id,desc";
		$this->global_privilege = false;
		$this->button_table_action = true;
		$this->button_bulk_action = true;
		$this->button_action_style = "button_icon";
		$this->button_add = true;
		$this->button_edit = true;
		$this->button_delete = true;
		$this->button_detail = false;
		$this->button_show = false;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = false;
		$this->table = "pickpoints";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "Name", "name" => "name"];
		$this->col[] = ["label" => "Province", "name" => "province"];
		$this->col[] = ["label" => "City", "name" => "city"];
		$this->col[] = ["label" => "Subdistrict", "name" => "subdistrict"];
		$this->col[] = ["label" => "Latitude", "name" => "latitude"];
		$this->col[] = ["label" => "Longitude", "name" => "longitude"];
        $this->col[] = ['label' => 'Active', 'name' => 'is_active', "callback" => function ($row) {
            if ($row->is_active == 1) {
                return '<span class="label label-success">Active</span>';
            } else {
                return '<span class="label label-warning">Inactive</span>';
            }
        }];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'validation' => 'required|string|min:3|max:70', 'width' => 'col-sm-10', 'placeholder' => 'You can only enter the letter only'];
		$this->form[] = ['label' => 'Province', 'name' => 'province', 'type' => 'select', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'City', 'name' => 'city', 'type' => 'select', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Subdistrict', 'name' => 'subdistrict', 'type' => 'select', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Address', 'name' => 'address', 'type' => 'textarea', 'validation' => 'required|string|min:5|max:5000', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Postal Code', 'name' => 'postal_code', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		# END FORM DO NOT REMOVE THIS LINE

		# OLD START FORM
		//$this->form = [];
		//$this->form[] = ["label"=>"Name","name"=>"name","type"=>"text","required"=>TRUE,"validation"=>"required|string|min:3|max:70","placeholder"=>"You can only enter the letter only"];
		//$this->form[] = ["label"=>"Address","name"=>"address","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
		//$this->form[] = ["label"=>"Subdistrict","name"=>"subdistrict","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Subdistrict Id","name"=>"subdistrict_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"subdistrict,id"];
		//$this->form[] = ["label"=>"City","name"=>"city","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"City Id","name"=>"city_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"city,id"];
		//$this->form[] = ["label"=>"Province","name"=>"province","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Province Id","name"=>"province_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"province,id"];
		//$this->form[] = ["label"=>"Postal Code","name"=>"postal_code","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
		# OLD END FORM

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
		$this->sub_module = array();


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
		$this->addaction = array();


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
		$this->button_selected = array();


		/*
	        | ----------------------------------------------------------------------
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------
	        | @message = Text of message
	        | @type    = warning,success,danger,info
	        |
	        */
		$this->alert        = array();



		/*
	        | ----------------------------------------------------------------------
	        | Add more button to header button
	        | ----------------------------------------------------------------------
	        | @label = Name of button
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        |
	        */
		$this->index_button = array();



		/*
	        | ----------------------------------------------------------------------
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.
	        |
	        */
		$this->table_row_color = array();


		/*
	        | ----------------------------------------------------------------------
	        | You may use this bellow array to add statistic at dashboard
	        | ----------------------------------------------------------------------
	        | @label, @count, @icon, @color
	        |
	        */
		$this->index_statistic = array();



		/*
	        | ----------------------------------------------------------------------
	        | Add javascript at body
	        | ----------------------------------------------------------------------
	        | javascript code in the variable
	        | $this->script_js = "function() { ... }";
	        |
	        */
		$this->script_js = NULL;


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
		$this->load_js = array();



		/*
	        | ----------------------------------------------------------------------
	        | Add css style at body
	        | ----------------------------------------------------------------------
	        | css code in the variable
	        | $this->style_css = ".style{....}";
	        |
	        */
		$this->style_css = NULL;



		/*
	        | ----------------------------------------------------------------------
	        | Include css File
	        | ----------------------------------------------------------------------
	        | URL of your css each array
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
		$this->load_css = array();
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
		if (!CRUDBooster::isCreate() && $this->global_privilege == false || $this->button_add == false) {
			CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
		}

		$data                = [];
		$data['page_title']  = 'Add New Pickups';
		$data['form_type']   = 'Add';

		$this->cbView('vendor/crudbooster/pickup_management', $data);
	}

	public function getEdit($id)
	{
		if (!CRUDBooster::isUpdate() && $this->global_privilege == false || $this->button_edit == false) {
			CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
		}

		$pickpoint  	= Pickpoint::findOrFail($id);
		$cities 		= $this->getCityEdit($pickpoint->province_id);
		$subdistricts 	= $this->getSubdistrictEdit($pickpoint->city_id);

		// dd($cities);

		$data                	= [];
		$data['edit']        	= true;
		$data['page_title']  	= 'Edit pickpoint ' . $pickpoint->name;
		$data['form_type']   	= 'Edit';
		$data['cities']		 	= $cities;
		$data['subdistricts']	= $subdistricts;
		$data['pickpoint']   	= $pickpoint;

		$this->cbView('vendor/crudbooster/pickup_management', $data);
	}

	public function postSavePickup(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				'name'             => 'required',
				'province'         => 'required',
				'city'        	   => 'required',
				'subdistrict'      => 'required',
				'address'          => 'required',
				'latitude'		   => 'required',
				'longitude'        => 'required',
				'contact_person'   => 'required',
				'contact_phone'	   => 'required',
				'contact_email'	   => 'required',
				'is_active'	   	   => 'required',
			]
		);

		$edit = $request->id;

		if ($validator->fails()) {
			$message = $validator->errors()->all();
			$res     = redirect()->back()->with(['message' => implode('<br/>', $message), 'message_type' => 'warning'])->withInput();
			\Session::driver()->save();
			$res->send();
			exit;
		} else {

			if ($edit) {
				$pickpoint				= Pickpoint::find($edit);
				$oldValue               = $pickpoint;
			} else {
				$pickpoint              = new Pickpoint;
			}

			$province 		= explode('-', $request->province);
			$city 			= explode('-', $request->city);
			$subdistrict	= explode('-', $request->subdistrict);

			$pickpoint->name					= $request->name;
			$pickpoint->address					= $request->address;
			$pickpoint->province_id				= $province[0];
			$pickpoint->province				= $province[1];
			$pickpoint->is_active				= $request->is_active;
			$pickpoint->city_id					= $city[0];
			$pickpoint->city					= $city[1];
			$pickpoint->subdistrict_id			= $subdistrict[0];
			$pickpoint->subdistrict				= $subdistrict[1];
			$pickpoint->postal_code				= $request->postal_code;
			$pickpoint->latitude				= $request->latitude;
			$pickpoint->longitude				= $request->longitude;
			$pickpoint->contact_person			= $request->contact_person;
			$pickpoint->contact_phone			= $request->contact_phone;
			$pickpoint->contact_email			= $request->contact_email;
			$pickpoint->save();

			if ($edit) {
				$logDesc = 'Update ' . $pickpoint->name . ' detail';
			} else {
				$logDesc = 'Create new Pickup Point ' . $request->name;
			}

			insertRhapsodieLog($logDesc, 'pickup_point', CRUDBooster::myId(), json_encode($request->all()));

			return redirect('admin/pickup_points')->with(['message' => 'Pickup Point Has been saved', 'message_type' => 'success'])->send();
			exit;
		}
	}

	public function getCity(Request $request)
	{
		$key  = env('RAJAONGKIR_KEY');
		$curl = curl_init();

		$province = $provi ? $provi : $request->prov;

		curl_setopt_array($curl, [
			CURLOPT_URL             => "https://pro.rajaongkir.com/api/city?province=$province",
			CURLOPT_RETURNTRANSFER  => true,
			CURLOPT_ENCODING        => '',
			CURLOPT_MAXREDIRS       => 10,
			CURLOPT_TIMEOUT         => 30,
			CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST   => 'GET',
			CURLOPT_HTTPHEADER      => ["key: $key"],
		]);

		$response = curl_exec($curl);

		$err = curl_error($curl);

		curl_close($curl);

		$output = '';

		// if ($err) {
		//     return 'cURL Error #:' . $err;
		// } else {
		$data   = json_decode($response, true);
		$mydata = [];
		for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
			$mydata[$i]['value'] = $data['rajaongkir']['results'][$i]['city_id'] . '-' . $data['rajaongkir']['results'][$i]['city_name'] . '-' . $data['rajaongkir']['results'][$i]['type'];
			$mydata[$i]['name']  = $data['rajaongkir']['results'][$i]['city_name'];
		}

		return response()->json(
			[
				'status' => true,
				'cities' => ['id' => 'myid', 'city' => $mydata]
			]
		);
	}

	public function getCityEdit($province)
	{
		$key  = env('RAJAONGKIR_KEY');
		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL             => "https://pro.rajaongkir.com/api/city?province=$province",
			CURLOPT_RETURNTRANSFER  => true,
			CURLOPT_ENCODING        => '',
			CURLOPT_MAXREDIRS       => 10,
			CURLOPT_TIMEOUT         => 30,
			CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST   => 'GET',
			CURLOPT_HTTPHEADER      => ["key: $key"],
		]);

		$response = curl_exec($curl);

		$err = curl_error($curl);

		curl_close($curl);

		$output = '';

		// if ($err) {
		//     return 'cURL Error #:' . $err;
		// } else {
		$data   = json_decode($response, true);
		$mydata = [];
		for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
			$mydata[$i]['value'] = $data['rajaongkir']['results'][$i]['city_id'] . '-' . $data['rajaongkir']['results'][$i]['city_name'] . '-' . $data['rajaongkir']['results'][$i]['type'];
			$mydata[$i]['name']  = $data['rajaongkir']['results'][$i]['city_name'];
		}
		return $mydata;
	}

	public function getSubdistrict(Request $request)
	{
		$key  = env('RAJAONGKIR_KEY');
		$curl = curl_init();

		$city = $request->city;

		curl_setopt_array($curl, [
			CURLOPT_URL             => "https://pro.rajaongkir.com/api/subdistrict?city=$city",
			CURLOPT_RETURNTRANSFER  => true,
			CURLOPT_ENCODING        => '',
			CURLOPT_MAXREDIRS       => 10,
			CURLOPT_TIMEOUT         => 30,
			CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST   => 'GET',
			CURLOPT_HTTPHEADER      => ["key: $key"],
		]);

		$response = curl_exec($curl);

		$err = curl_error($curl);

		curl_close($curl);

		$output = '';

		// if ($err) {
		//     return 'cURL Error #:' . $err;
		// } else {
		$data   = json_decode($response, true);
		$mydata = [];
		for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
			$mydata[$i]['value'] = $data['rajaongkir']['results'][$i]['subdistrict_id'] . '-' . $data['rajaongkir']['results'][$i]['subdistrict_name'] . '-' . $data['rajaongkir']['results'][$i]['type'];
			$mydata[$i]['name']  = $data['rajaongkir']['results'][$i]['subdistrict_name'];
		}

		return response()->json(
			[
				'status' => true,
				'subdistrict' => ['id' => 'myid', 'subdistrict' => $mydata]
			]
		);
	}

	public function getSubdistrictEdit($city)
	{
		$key  = env('RAJAONGKIR_KEY');
		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL             => "https://pro.rajaongkir.com/api/subdistrict?city=$city",
			CURLOPT_RETURNTRANSFER  => true,
			CURLOPT_ENCODING        => '',
			CURLOPT_MAXREDIRS       => 10,
			CURLOPT_TIMEOUT         => 30,
			CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST   => 'GET',
			CURLOPT_HTTPHEADER      => ["key: $key"],
		]);

		$response = curl_exec($curl);

		$err = curl_error($curl);

		curl_close($curl);

		$output = '';

		// if ($err) {
		//     return 'cURL Error #:' . $err;
		// } else {
		$data   = json_decode($response, true);
		$mydata = [];
		for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
			$mydata[$i]['value'] = $data['rajaongkir']['results'][$i]['subdistrict_id'] . '-' . $data['rajaongkir']['results'][$i]['subdistrict_name'] . '-' . $data['rajaongkir']['results'][$i]['type'];
			$mydata[$i]['name']  = $data['rajaongkir']['results'][$i]['subdistrict_name'];
		}

		return $mydata;
	}
}
