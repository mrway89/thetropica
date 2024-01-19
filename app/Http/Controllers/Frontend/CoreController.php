<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Image;
use App\Menu;
use App\Order;
use Cache;
use DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

class CoreController extends Controller
{
    public $data;
    protected $productsorts = [
        ['id' => 1, 'name' => 'Published (Newest - Oldest)'],
        ['id' => 2, 'name' => 'Published (Oldest - Newest)'],
        ['id' => 3, 'name' => 'Name (A - Z)'],
        ['id' => 4, 'name' => 'Name (Z - A)'],
        ['id' => 5, 'name' => 'Price (Low - High)'],
        ['id' => 6, 'name' => 'Price (High - Low)'],
    ];
    protected $locale;

    public function __construct()
    {
        $this->initSiteConfig();
        $this->setPopUp();
        $this->middleware(function ($request, $next) {
            $locale = false;
            $locale = $request->session()->get('locale') ? $request->session()->get('locale') : $locale;

            $locales = array_keys(config('app.localization'));
            if (in_array($locale, $locales)) {
                \App::setLocale($locale);
                app()->setLocale($locale);
            } else {
                session()->put('locale', 'en');
                \App::setLocale('en');
            }
            $lang       = session()->get('locale');
            $transQuery = DB::table('translations');
            $trans      = $this->cacheQuery('translation', $transQuery, 'get');
            $this->data['language'] = $lang;
            foreach ($trans as $t) {
                $value  = 'value_' . $lang;
                $this->data['trans'][$t->name]   = $t->{$value};
            }

            return $next($request);
        });
        $this->initData();
    }

    protected function initData()
    {
        $ip                     = Request::ip();
        $whitelistIP            = str_replace(' ', '', $this->data['whitelist_ip']);
        $whitelistIP            = explode(',', $whitelistIP);
        $maintenance_mode       = (int) ($this->data['maintenance_mode']);

        if ($maintenance_mode == 1) {
            // if (!in_array($ip, $whitelistIP)) {
            //     echo view('errors.maintenance', $this->data);
            //     exit;
            // }
        }
    }

    protected function initSiteConfig()
    {
        $query_config = DB::table('configs');
        $config       = $this->cacheQuery('configs', $query_config, 'get');
        foreach ($config as $c) {
            $this->data[$c->name] = $c->value;
        }

        $footerQuery          = Menu::orderBy('sorting', 'ASC');
        $footerShippingQuery  = Image::where('type', 'footer_shipping')->get();
        $footerSPaymentQuery  = Image::where('type', 'footer_payment');

        $this->data['footerNav']          = $this->cacheQuery('footer_nav', $footerQuery, 'get');
        $this->data['footerShipping']     = $footerShippingQuery;
        $this->data['footerPayment']      = $this->cacheQuery('footer_payment', $footerSPaymentQuery, 'get');
    }

    protected function setPageTitle($title)
    {
        $pageTitle = $title;

        return true;
    }

    protected function checkMaintenance()
    {
        if ($maintenance_mode === 1) {
            return view('errors.maintenance');
        }
    }

    private function setPopUp()
    {
        // $active = (int)$this->data['pop_up_active'];
        // if ($active) {
        //     if (!Cookie::get('pu')) {
        //         $active = true;
        //         Cookie::queue('pu', 1, 120);
        //     } else {
        //         $active  = false;
        //     }
        // } else {
        //     $active = false;
        // }

        // $this->data['pop_up_active']    = $active;
    }

    public function renderView($name)
    {
        return view($name, $this->data);
    }

    public function getAdminEmails()
    {
        $bcc    = str_replace(' ', '', $this->data['bcc_email_system']);
        $bcc    = explode(',', $bcc);

        foreach ($bcc as $index => $email) {
            if ($email == '') {
                unset($bcc[$index]);
            }
        }

        return $bcc;
    }

    public function cacheQuery($name, $query, $type = '', $time = 60 * 24)
    {
        $c = Cache::remember($name, $time, function () use ($query, $type) {
            if (!empty($type)) {
                if ($type == 'first') {
                    $q = $query->first();
                } else {
                    $q = $query->get();
                }

                return $q;
            } else {
                return $query;
            }
        });
        if (env('APP_ENV') == 'local') {
            Cache::flush();
        }

        return $c;
    }

    public function getProvince()
    {
        $key = env('RAJAONGKIR_KEY');

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL             => 'https://pro.rajaongkir.com/api/province',
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

        if ($err) {
            return 'cURL Error #:' . $err;
        } else {
            $data = json_decode($response, true);
            for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
                $output .= "<option value='" . $data['rajaongkir']['results'][$i]['province_id'] . '-' . $data['rajaongkir']['results'][$i]['province'] . "'>" . $data['rajaongkir']['results'][$i]['province'] . '</option>';
            }
        }

        return $output;
    }

    public static function getCity($province)
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

        if ($err) {
            return 'cURL Error #:' . $err;
        } else {
            $data = json_decode($response, true);
            for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
                $output .= "<option value='" . $data['rajaongkir']['results'][$i]['city_id'] . '-' . $data['rajaongkir']['results'][$i]['city_name'] . '-' . $data['rajaongkir']['results'][$i]['type'] . "'>" . $data['rajaongkir']['results'][$i]['city_name'] . ' (' . $data['rajaongkir']['results'][$i]['type'] . ')' . '</option>';
            }
        }

        return $output;
    }

    public static function getSubdistrict($city)
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

        if ($err) {
            return 'cURL Error #:' . $err;
        } else {
            $data = json_decode($response, true);
            for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
                $output .= "<option value='" . $data['rajaongkir']['results'][$i]['subdistrict_id'] . '-' . $data['rajaongkir']['results'][$i]['subdistrict_name'] . '-' . $data['rajaongkir']['results'][$i]['type'] . "'>" . $data['rajaongkir']['results'][$i]['subdistrict_name'] . '</option>';
            }
        }

        return $output;
    }

    public static function getPostalCodeAuto($province)
    {
        $key = env('RAJAONGKIR_KEY');

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

        $output = [];

        if ($err) {
            return 'cURL Error #:' . $err;
        } else {
            $data = json_decode($response, true);
            for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
                $output .= "<option value='" . $data['rajaongkir']['results'][$i]['postal_code'] . "'>" . $data['rajaongkir']['results'][$i]['postal_code'] . '</option>';
            }
        }

        return $output;
    }

    public static function getPostalCodeArray($province)
    {
        $key = env('RAJAONGKIR_KEY');

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

        $output = [];

        if ($err) {
            return 'cURL Error #:' . $err;
        } else {
            $data     = json_decode($response, true);
            $newArray = [];
            for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
                array_push($newArray, $data['rajaongkir']['results'][$i]['postal_code']);
            }
        }

        return $newArray;
    }

    public static function getProvinceEdit($province_id)
    {
        $key = env('RAJAONGKIR_KEY');

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL             => 'https://pro.rajaongkir.com/api/province',
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

        if ($err) {
            return 'cURL Error #:' . $err;
        } else {
            $data = json_decode($response, true);
            for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
                $selected = $data['rajaongkir']['results'][$i]['province_id'] == $province_id ? 'selected' : '';
                $output .= '<option ' . $selected . " value='" . $data['rajaongkir']['results'][$i]['province_id'] . '-' . $data['rajaongkir']['results'][$i]['province'] . "'>" . $data['rajaongkir']['results'][$i]['province'] . '</option>';
            }
        }
    }

    public static function getCityEdit($province_id, $city_id)
    {
        $key  = env('RAJAONGKIR_KEY');
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL             => "https://pro.rajaongkir.com/api/city?province=$province_id",
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

        if ($err) {
            return 'cURL Error #:' . $err;
        } else {
            $data = json_decode($response, true);
            for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
                $selected = $data['rajaongkir']['results'][$i]['city_id'] == $city_id ? 'selected' : '';
                $output .= '<option ' . $selected . " value='" . $data['rajaongkir']['results'][$i]['city_id'] . '-' . $data['rajaongkir']['results'][$i]['city_name'] . '-' . $data['rajaongkir']['results'][$i]['type'] . "'>" . $data['rajaongkir']['results'][$i]['city_name'] . ' (' . $data['rajaongkir']['results'][$i]['type'] . ')' . '</option>';
            }
        }

        return $output;
    }

    public static function getPostalCodeEditAuto($province_id, $postal_code)
    {
        $key = env('RAJAONGKIR_KEY');

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL                     => "https://pro.rajaongkir.com/api/city?province=$province_id",
            CURLOPT_RETURNTRANSFER          => true,
            CURLOPT_ENCODING                => '',
            CURLOPT_MAXREDIRS               => 10,
            CURLOPT_TIMEOUT                 => 30,
            CURLOPT_HTTP_VERSION            => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST           => 'GET',
            CURLOPT_HTTPHEADER              => ["key: $key"],
        ]);

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        //$output = '';

        if ($err) {
            return 'cURL Error #:' . $err;
        } else {
            $data = json_decode($response, true);
            for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
                $selected = $data['rajaongkir']['results'][$i]['postal_code'] == $postal_code ? 'selected' : '';
                $output[] = $data['rajaongkir']['results'][$i]['postal_code'];
            }
        }

        return $output;
    }

    public static function getSubdistrictEdit($city_id, $subdistrict_id)
    {
        $key  = env('RAJAONGKIR_KEY');
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL             => "https://pro.rajaongkir.com/api/subdistrict?city=$city_id",
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

        if ($err) {
            return 'cURL Error #:' . $err;
        } else {
            $data = json_decode($response, true);
            for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
                $selected = $data['rajaongkir']['results'][$i]['subdistrict_id'] == $subdistrict_id ? 'selected' : '';
                $output .= '<option ' . $selected . " value='" . $data['rajaongkir']['results'][$i]['subdistrict_id'] . '-' . $data['rajaongkir']['results'][$i]['subdistrict_name'] . '-' . $data['rajaongkir']['results'][$i]['type'] . "'>" . $data['rajaongkir']['results'][$i]['subdistrict_name'] . ' (' . $data['rajaongkir']['results'][$i]['type'] . ')' . '</option>';
            }
        }

        return $output;
    }

    public static function getCost($origin, $originType, $destination, $destinationType, $weight, $courier)
    {
        if ($weight == 0) {
            return [];
        }
        $key = env('RAJAONGKIR_KEY');

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL             => 'https://pro.rajaongkir.com/api/cost',
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => '',
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 30,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => 'POST',
            CURLOPT_POSTFIELDS      => "origin=$origin&originType=$originType&destination=$destination&destinationType=$destinationType&weight=$weight&courier=$courier",
            CURLOPT_HTTPHEADER      => ['content-type: application/x-www-form-urlencoded', "key: $key"],
        ]);

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        $output = [];

        if ($err) {
            return 'error';
        } else {
            $data = json_decode($response, true);

            if ($data['rajaongkir']['status']['code'] == 200) {
                $response = $data['rajaongkir']['results'];
                for ($i = 0; $i < count($response); $i++) {
                    $courierName = $response[$i]['code'];
                    $costArray   = $response[$i]['costs'];

                    for ($ii = 0; $ii < count($costArray); $ii++) {
                        if ($costArray[$ii]['cost'][0]['etd'] == '1' || $costArray[$ii]['cost'][0]['etd'] == '1 - 1' || $costArray[$ii]['cost'][0]['etd'] == '1-1') {
                            $output['next_day'][$ii]['courier'] = $courierName;
                            $output['next_day'][$ii]['type']    = $costArray[$ii]['service'];
                            $output['next_day'][$ii]['etd']     = $costArray[$ii]['cost'][0]['etd'];
                            $output['next_day'][$ii]['cost']    = $costArray[$ii]['cost'][0]['value'];
                        }
                    }
                    for ($ii = 0; $ii < count($costArray); $ii++) {
                        if ($costArray[$ii]['cost'][0]['etd'] !== '1') {
                            if ($costArray[$ii]['cost'][0]['etd'] !== '1-1') {
                                $output['regular'][$ii]['courier'] = $courierName;
                                $output['regular'][$ii]['type']    = $costArray[$ii]['service'];
                                $output['regular'][$ii]['etd']     = $costArray[$ii]['cost'][0]['etd'];
                                $output['regular'][$ii]['cost']    = $costArray[$ii]['cost'][0]['value'];
                            }
                        }
                    }
                }
            } else {
                // $code   = $data['rajaongkir']['status']['code'];
                // $output = $data['rajaongkir']['status']['description'];
            }
        }

        $result = $data['rajaongkir']['results'][0]['costs'];

        return $output;
    }

    public static function getCostByDuration($origin, $originType, $destination, $destinationType, $weight, $courier, $duration)
    {
        if ($weight == 0) {
            return [];
        }
        $key = env('RAJAONGKIR_KEY');

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL             => 'https://pro.rajaongkir.com/api/cost',
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => '',
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 30,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => 'POST',
            CURLOPT_POSTFIELDS      => "origin=$origin&originType=$originType&destination=$destination&destinationType=$destinationType&weight=$weight&courier=$courier",
            CURLOPT_HTTPHEADER      => ['content-type: application/x-www-form-urlencoded', "key: $key"],
        ]);

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        $output = [];

        if ($err) {
            return 'cURL Error #:' . $err;
        } else {
            $data    = json_decode($response, true);
            $next    = '<option>Select Courier</option>';
            $regular = '<option>Select Courier</option>';

            if ($data['rajaongkir']['status']['code'] == 200) {
                $response = $data['rajaongkir']['results'];
                for ($i = 0; $i < count($response); $i++) {
                    $courierName = $response[$i]['code'];
                    $costArray   = $response[$i]['costs'];

                    for ($ii = 0; $ii < count($costArray); $ii++) {
                        if ($costArray[$ii]['cost'][0]['etd'] == '1' || $costArray[$ii]['cost'][0]['etd'] == '1 - 1' || $costArray[$ii]['cost'][0]['etd'] == '1-1') {
                            $next .= '<option value="' . $courierName . '-' . strtoupper($costArray[$ii]['service']) . '" data-value="' . $costArray[$ii]['cost'][0]['value'] . '">' . strtoupper($courierName) . '-' . strtoupper($costArray[$ii]['service']) . ' (' . $costArray[$ii]['cost'][0]['etd'] . ' Days)  (' . currency_format($costArray[$ii]['cost'][0]['value']) . ')</option>';
                        }
                    }
                    for ($ii = 0; $ii < count($costArray); $ii++) {
                        if ($costArray[$ii]['cost'][0]['etd'] !== '1') {
                            if ($costArray[$ii]['cost'][0]['etd'] !== '1-1') {
                                $regular .= '<option value="' . $courierName . '-' . strtoupper($costArray[$ii]['service']) . '" data-value="' . $costArray[$ii]['cost'][0]['value'] . '">' . strtoupper($courierName) . '-' . strtoupper($costArray[$ii]['service']) . ' (' . $costArray[$ii]['cost'][0]['etd'] . ' Days)  (' . currency_format($costArray[$ii]['cost'][0]['value']) . ')</option>';
                            }
                        }
                    }
                }
            } else {
                $code   = $data['rajaongkir']['status']['code'];
                $output = $data['rajaongkir']['status']['description'];
            }
        }

        $result = $data['rajaongkir']['results'][0]['costs'];

        if ($duration == 2) {
            // code...
            return $next;
        } else {
            return $regular;
        }
    }

    public static function checkCost($origin, $originType, $destination, $destinationType, $weight, $courier)
    {
        $key = env('RAJAONGKIR_KEY');

        $tempCourier    = explode('-', $courier, 2);

        $selCour = strtolower($tempCourier[0]);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL             => 'https://pro.rajaongkir.com/api/cost',
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => '',
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 30,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => 'POST',
            CURLOPT_POSTFIELDS      => "origin=$origin&originType=$originType&destination=$destination&destinationType=$destinationType&weight=$weight&courier=$selCour",
            CURLOPT_HTTPHEADER      => ['content-type: application/x-www-form-urlencoded', "key: $key"],
        ]);

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        $output = '';

        if ($err) {
            return 'cURL Error #:' . $err;
        } else {
            $data = json_decode($response, true);
        }

        $result = $data['rajaongkir']['results'][0]['costs'];

        foreach ($result as $key => $value) {
            if ($value['service'] == $tempCourier[1]) {
                $cost = $value['cost'][0]['value'];
            }
        }

        return $cost;
    }

    public static function rajaongkirTrack($waybill, $courier)
    {
        $key = env('RAJAONGKIR_KEY');

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => 'https://pro.rajaongkir.com/api/waybill',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => "waybill=$waybill&courier=$courier",
            CURLOPT_HTTPHEADER     => ['content-type: application/x-www-form-urlencoded', "key: $key"],
        ]);

        $response = curl_exec($curl);
        $err      = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            return $response;
        }
    }

    public function LoketCom_Authorization()
    {
        if (!\Session::has('header_key')) {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL            => getenv('LOKETCOM_HOST') . 'authentication/generate?client_id=' . getenv('LOKETCOM_CLIENT_ID') . '&client_secret=' . getenv('LOKETCOM_CLIENT_SECRET'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 30000,
                CURLOPT_POST           => true,

                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER    => [
                    // Set Here Your Requesred Headers
                    'Content-Type: application/json',
                ],
            ]);
            $response = curl_exec($curl);
            $err      = curl_error($curl);
            curl_close($curl);

            if ($err) {
                echo 'cURL Error #:' . $err;
            } else {
                $data = json_decode($response);

                if ($data->status) {
                    \Session::put('header_key', $data->result->hmac->Authorization->header);

                    return $data->result->hmac->Authorization->header;
                }
            }
        } else {
            return \Session::get('header_key');
        }
    }

    public function LoketCom_API($method, $url, $params = [])
    {
        $Authorization = $this->LoketCom_Authorization();
        $formdata      = '';

        if (count($params) > 0) {
            $formdata = json_encode($params);
        }
        if ($Authorization) {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL            => getenv('LOKETCOM_HOST') . $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST           => ($method == 'POST') ? true : false,
                CURLOPT_ENCODING       => '',
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_POSTFIELDS     => $formdata,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => $method,
                CURLOPT_HTTPHEADER     => [
                    'Content-Type: application/json',
                    'Authorization: ' . $Authorization,
                ],
            ]);
            $response = curl_exec($curl);
            $err      = curl_error($curl);
            curl_close($curl);

            if ($err) {
                echo 'cURL Error #:' . $err;
            } else {
                return json_decode($response);
            }
        } else {
            return [];
        }
    }

    public function stockSync($order)
    {
        $myorder = Order::with('cart', 'cart.details', 'cart.details.product')->find($order->id);
        foreach ($myorder->cart->details as $item) {
            $item->product->stock += $item->qty;
            $item->product->save();
        }
    }
}
