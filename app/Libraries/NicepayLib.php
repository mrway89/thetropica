<?php

namespace App\Libraries;

use App\Cart;
use App\NicepayEnterpriseRegistration;
use App\NicepayEnterpriseRegistrationResponse;
use App\Order;
use Carbon\Carbon;
use function GuzzleHttp\json_encode;

class NicepayLib
{
    public function registrationVa($cartData, $order, $method, $ip, $bankName)
    {
        $apiUrl         = 'https://api.nicepay.co.id/nicepay/direct/v2/registration';
        $ch             = curl_init($apiUrl);

        $timestamp      = Carbon::now()->timestamp;
        $iMid           = env('NICEPAY_IMID');
        $merchantKey    = env('NICEPAY_MERCHANT_KEY');
        $amt            = $order->grand_total;

        $referenceNo    = $order->order_code;
        $validity       = Carbon::now()->addDay(1);
        $validDate      = $validity->format('Ymd');
        $validTime      = $validity->format('His');

        $merchantToken = hash('sha256', $timestamp . $iMid . $referenceNo . $amt . $merchantKey);

        $jsonData = [
            'timeStamp'       => $timestamp,
            'iMid'            => $iMid,
            'payMethod'       => '02',
            'currency'        => 'IDR',
            'amt'             => $amt,
            'referenceNo'     => $referenceNo,
            'goodsNm'         => $order->order_code,
            'billingNm'       => $order->user->name,
            'billingPhone'    => $order->user->phone ? $order->user->phone : '12345678',
            'billingEmail'    => $order->user->email,
            'billingAddr'     => $order->cart->address->address,
            'billingCity'     => $order->cart->address->city,
            'billingState'    => $order->cart->address->province,
            'billingPostCd'   => $order->cart->address->postal_code,
            'billingCountry'  => 'Indonesia',
            'deliveryNm'      => $order->user->email,
            'deliveryPhone'   => $order->cart->address->phone,
            'deliveryAddr'    => $order->cart->address->address,
            'deliveryCity'    => $order->cart->address->city,
            'deliveryState'   => $order->cart->address->province,
            'deliveryPostCd'  => $order->cart->address->postal_code,
            'deliveryCountry' => 'Indonesia',
            'dbProcessUrl'    => env('NICEPAY_DB_PROCESS_URL'),
            'vat'             => '',
            'fee'             => '',
            'notaxAmt'        => '',
            'description'     => 'VIRTUAL ACCOUNT PAYMENT FOR ' . $order->order_code,
            'merchantToken'   => $merchantToken,
            'userIP'          => $ip,
            'cartData'        => $cartData,
            'bankCd'          => $this->getBankCode($bankName),
            'vacctValidDt'    => $validDate,
            'vacctValidTm'    => $validTime,
            'payValidDt'      => $validDate,
            'payValidTm'      => $validTime,
        ];

        $registration = new NicepayEnterpriseRegistration;
        $registration->create($jsonData);

        $jsonDataEncoded = json_encode($jsonData);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $curl_result = curl_exec($ch);
        $result      = json_decode($curl_result);

        $responseData = array_merge((array) $result, ['data' => json_encode($result)]);

        $registrationResponse = new NicepayEnterpriseRegistrationResponse;
        $registrationResponse->create($responseData);

        return $result;
    }

    public function registrationEw($cartData, $order, $method, $ip, $bankName, $phone)
    {
        $apiUrl             = 'https://www.nicepay.co.id/nicepay/api/orderRegist.do';
        $timeout_connect    = 30;

        $timestamp      = Carbon::now()->timestamp;
        $iMid           = env('NICEPAY_IMID');
        $merchantKey    = env('NICEPAY_MERCHANT_KEY');
        $amt            = $order->grand_total;

        $referenceNo    = $order->order_code;
        $validity       = Carbon::now()->addDay(1);
        $validDate      = $validity->format('Ymd');
        $validTime      = $validity->format('His');
        $merchantToken  = hash('sha256', $iMid . $referenceNo . $amt . $merchantKey);

        $jsonData = [
            'iMid'            => $iMid,
            'payMethod'       => '05',
            'currency'        => 'IDR',
            'amt'             => $amt,
            'referenceNo'     => $referenceNo,
            'goodsNm'         => $order->order_code,
            'billingNm'       => $order->user->name,
            'billingPhone'    => $phone,
            'billingEmail'    => $order->user->email,
            'billingAddr'     => $order->cart->address->address,
            'billingCity'     => $order->cart->address->city,
            'billingState'    => $order->cart->address->province,
            'billingPostCd'   => $order->cart->address->postal_code,
            'billingCountry'  => 'Indonesia',
            'deliveryNm'      => $order->user->email,
            'deliveryPhone'   => $order->cart->address->phone,
            'deliveryAddr'    => $order->cart->address->address,
            'deliveryCity'    => $order->cart->address->city,
            'deliveryState'   => $order->cart->address->province,
            'deliveryPostCd'  => $order->cart->address->postal_code,
            'deliveryCountry' => 'Indonesia',
            'callBackUrl'     => env('OVO_CALL_BACK_URL') . '/' . $order->order_code,
            'dbProcessUrl'    => env('NICEPAY_DB_PROCESS_URL'),
            'description'     => 'OVO PAYMENT FOR ' . $order->order_code,
            'merchantToken'   => $merchantToken,
            'userIP'          => $ip,
            'cartData'        => $cartData,
            'mitraCd'         => 'OVOE',
        ];

        // dd($jsonData);

        $registration = new NicepayEnterpriseRegistration;
        $registration->create($jsonData);

        $postData = '';
        foreach ($jsonData as $key => $value) {
            $postData .= urlencode($key) . '=' . urlencode($value) . '&';
        }
        $postData = rtrim($postData, '&');
        $ch       = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout_connect);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout_connect);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $curl_result = curl_exec($ch);
        $result      = json_decode(substr($curl_result, 4));

        // dd($jsonData);

        $responseData = array_merge((array) $result, ['data' => json_encode($result), 'referenceNo' => $order->order_code]);

        $registrationResponse = new NicepayEnterpriseRegistrationResponse;
        $registrationResponse->create($responseData);

        return $result;

        // $apiUrl         = 'https://api.nicepay.co.id/nicepay/direct/v2/registration';
        // $ch             = curl_init($apiUrl);

        // $timestamp      = Carbon::now()->timestamp;
        // $iMid           = env('NICEPAY_IMID');
        // $merchantKey    = env('NICEPAY_MERCHANT_KEY');
        // $amt            = $order->grand_total;

        // $referenceNo    = $order->order_code;
        // $validity       = Carbon::now()->addDay(1);
        // $validDate      = $validity->format('Ymd');
        // $validTime      = $validity->format('His');

        // $merchantToken = hash('sha256', $timestamp . $iMid . $referenceNo . $amt . $merchantKey);

        // $jsonData = array(
        //     "timeStamp"=> $timestamp,
        //     "iMid" => $iMid,
        //     "payMethod" => "05",
        //     "currency" => "IDR",
        //     "amt" => $amt,
        //     "referenceNo" => $referenceNo,
        //     "merchantToken"=> $merchantToken,
        //     "goodsNm" => $referenceNo,
        //     "billingNm" => $order->user->name,
        //     "billingPhone" => $order->user->phone ? $order->user->phone : '12345678',
        //     "billingEmail" => $order->user->email,
        //     "billingAddr" => $order->cart->address->address,
        //     "billingCity" => $order->cart->address->city,
        //     "billingState" => $order->cart->address->province,
        //     "billingPostCd" => $order->cart->address->postal_code,
        //     "billingCountry" => "Indonesia",
        //     "deliveryNm" => $order->user->email,
        //     "deliveryPhone" => $order->cart->address->phone,
        //     "deliveryAddr" => $order->cart->address->address,
        //     "deliveryCity" => $order->cart->address->city,
        //     "deliveryState" => $order->cart->address->province,
        //     "deliveryPostCd" => $order->cart->address->postal_code,
        //     "deliveryCountry" => "Indonesia",
        //     "dbProcessUrl" => env('NICEPAY_DB_PROCESS_URL'),
        //     "vat"=>"0",
        //     "fee"=>"0",
        //     "notaxAmt"=>"0",
        //     "description" => "OVO PAYMENT FOR " . $order->order_code,
        //     // "reqDt"=>"20190813",
        //     // "reqTm"=>"091098",
        //     // "reqDomain"=>"merchant.com",
        //     // "reqServerIP" => "172.29.2.178",
        //     // "reqClientVer"=>"",
        //     "userIP" => $ip,
        //     // "userSessionID"=>"697D6922C961070967D3BA1BA5699C2C",
        //     // "userAgent"=>"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML,like Gecko) Chrome/60.0.3112.101 Safari/537.36",
        //     "userLanguage"=>"en-US",
        //     "cartData" => $cartData,
        //     "mitraCd"=>"OVOE"
        // );

        // $registration = new NicepayEnterpriseRegistration;
        // $registration->create($jsonData);

        // $jsonDataEncoded = json_encode($jsonData);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // $curl_result = curl_exec($ch);
        // $result = json_decode($curl_result);

        // $responseData = array_merge((array)$result, ['data' => json_encode($result)]);

        // $registrationResponse = new NicepayEnterpriseRegistrationResponse;
        // $registrationResponse->create($responseData);

        // $apiUrl         = 'https://api.nicepay.co.id/nicepay/direct/v2/payment';
        // $chPayment      = curl_init($apiUrl);

        // $jsonData = array(
        //     "timeStamp"=> $timestamp,
        //     // "iMid" => $iMid,
        //     "tXid" => $result->tXid,
        //     "merchantToken"=> $merchantToken,
        //     "callBackUrl" => route('system.nicepay.callback'),
        // );
        // // dd($jsonData);

        // $jsonDataEncodedData = json_encode($jsonData);
        // curl_setopt($chPayment, CURLOPT_POST, 1);
        // curl_setopt($chPayment, CURLOPT_POSTFIELDS, $jsonDataEncodedData);
        // curl_setopt($chPayment, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        // curl_setopt($chPayment, CURLOPT_RETURNTRANSFER, true);

        // $curl_payment = curl_exec($chPayment);
        // $resultPayment = json_decode($curl_payment);

        // dd($curl_payment);

        // return $result;
    }

    public function registrationCvs($cartData, $order, $method, $ip, $cs)
    {
        $apiUrl         = 'https://api.nicepay.co.id/nicepay/direct/v2/registration';
        $ch             = curl_init($apiUrl);

        $timestamp      = Carbon::now()->timestamp;
        $iMid           = env('NICEPAY_IMID');
        $merchantKey    = env('NICEPAY_MERCHANT_KEY');
        $amt            = $order->grand_total;

        $referenceNo    = $order->order_code;
        $validity       = Carbon::now()->addDay(1);
        $validDate      = $validity->format('Ymd');
        $validTime      = $validity->format('His');

        $merchantToken = hash('sha256', $timestamp . $iMid . $referenceNo . $amt . $merchantKey);

        $jsonData = [
            'timeStamp' => $timestamp,
            'iMid'      => $iMid,
            'payMethod' => '03',
            'currency'  => 'IDR',
            'amt'       => $amt,

            'referenceNo'     => $referenceNo,
            'goodsNm'         => $order->order_code,
            'billingNm'       => $order->user->name,
            'billingPhone'    => $order->user->phone ? $order->user->phone : '12345678',
            'billingEmail'    => $order->user->email,
            'billingAddr'     => $order->cart->address->address,
            'billingCity'     => $order->cart->address->city,
            'billingState'    => $order->cart->address->province,
            'billingPostCd'   => $order->cart->address->postal_code,
            'billingCountry'  => 'Indonesia',
            'deliveryNm'      => $order->user->email,
            'deliveryPhone'   => $order->cart->address->phone,
            'deliveryAddr'    => $order->cart->address->address,
            'deliveryCity'    => $order->cart->address->city,
            'deliveryState'   => $order->cart->address->province,
            'deliveryPostCd'  => $order->cart->address->postal_code,
            'deliveryCountry' => 'Indonesia',
            'dbProcessUrl'    => env('NICEPAY_DB_PROCESS_URL'),
            'vat'             => '',
            'fee'             => '',
            'notaxAmt'        => '',
            'description'     => 'CONVENIENCE STORE PAYMENT FOR ' . $order->order_code,
            'merchantToken'   => $merchantToken,
            'userIP'          => $ip,
            'cartData'        => $cartData,
            'mitraCd'         => $this->getCsCode($cs),
            'vacctValidDt'    => $validDate,
            'vacctValidTm'    => $validTime,
            'payValidDt'      => $validDate,
            'payValidTm'      => $validTime,
        ];

        $registration = new NicepayEnterpriseRegistration;
        $registration->create($jsonData);

        $jsonDataEncoded = json_encode($jsonData);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $curl_result = curl_exec($ch);
        $result      = json_decode($curl_result);

        $responseData = array_merge((array) $result, ['data' => json_encode($result)]);

        $registrationResponse = new NicepayEnterpriseRegistrationResponse;
        $registrationResponse->create($responseData);

        return $result;
    }

    public function registrationCC($cartData, $order, $method, $ip, $cs)
    {
        $apiUrl             = 'https://www.nicepay.co.id/nicepay/api/orderRegist.do';
        $timeout_connect    = 30;

        $timestamp      = Carbon::now()->timestamp;
        $iMid           = env('NICEPAY_IMID');
        $merchantKey    = env('NICEPAY_MERCHANT_KEY');
        $amt            = $order->grand_total;

        $referenceNo    = $order->order_code;
        $validity       = Carbon::now()->addDay(1);
        $validDate      = $validity->format('Ymd');
        $validTime      = $validity->format('His');
        $merchantToken  = hash('sha256', $iMid . $referenceNo . $amt . $merchantKey);

        $jsonData = [
            'iMid'            => $iMid,
            'payMethod'       => '01',
            'currency'        => 'IDR',
            'merchantKey'     => env('NICEPAY_MERCHANT_KEY'),
            'amt'             => $amt,
            'instmntType'     => 1,
            'instmntMon'      => 1,
            'referenceNo'     => $referenceNo,
            'goodsNm'         => $order->order_code,
            'billingNm'       => $order->user->name,
            'billingPhone'    => $order->user->phone ? $order->user->phone : '12345678',
            'billingEmail'    => $order->user->email,
            'billingAddr'     => $order->cart->address->address,
            'billingCity'     => $order->cart->address->city,
            'billingState'    => $order->cart->address->province,
            'billingPostCd'   => $order->cart->address->postal_code,
            'billingCountry'  => 'Indonesia',
            'deliveryNm'      => $order->user->email,
            'deliveryPhone'   => $order->cart->address->phone,
            'deliveryAddr'    => $order->cart->address->address,
            'deliveryCity'    => $order->cart->address->city,
            'deliveryState'   => $order->cart->address->province,
            'deliveryPostCd'  => $order->cart->address->postal_code,
            'deliveryCountry' => 'Indonesia',
            'callBackUrl'     => env('NICEPAY_CALL_BACK_URL'),
            'dbProcessUrl'    => env('NICEPAY_DB_PROCESS_URL'),
            'description'     => 'CREDIT CARD PAYMENT FOR ' . $order->order_code,
            'merchantToken'   => $merchantToken,
            'userIP'          => $ip,
            'cartData'        => $cartData,
        ];

        $registration = new NicepayEnterpriseRegistration;
        $registration->create($jsonData);

        $postData = '';
        foreach ($jsonData as $key => $value) {
            $postData .= urlencode($key) . '=' . urlencode($value) . '&';
        }
        $postData = rtrim($postData, '&');
        $ch       = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout_connect);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout_connect);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $curl_result = curl_exec($ch);
        $result      = json_decode(substr($curl_result, 4));

        $responseData = array_merge((array) $result, ['data' => json_encode($result), 'referenceNo' => $order->order_code]);

        $registrationResponse = new NicepayEnterpriseRegistrationResponse;
        $registrationResponse->create($responseData);

        return $result;
    }

    public function registrationMultiVa($cartData, $order, $method, $ip, $bankName)
    {
        $apiUrl         = 'https://api.nicepay.co.id/nicepay/direct/v2/registration';
        $ch             = curl_init($apiUrl);

        $timestamp      = Carbon::now()->timestamp;
        $iMid           = env('NICEPAY_IMID');
        $merchantKey    = env('NICEPAY_MERCHANT_KEY');

        $orders     = Order::whereIn('id', $order)->get();
        $date       = date('ymdHis');
        $amt        = 0;
        foreach ($orders as $order) {
            $amt += $order->grand_total;
            $name     = $order->user->name;
            $phone    = $order->user->phone;
            $email    = $order->user->email;
            $address  = $order->user->addressDefault->address;
            $city     = $order->user->addressDefault->city;
            $province = $order->user->addressDefault->province;
            $postal   = $order->user->addressDefault->postal_code;

            $order->multi_code = $date;
            $order->save();
        }

        $cart         = Cart::where('status', 'current')->where('type', 'cart')->where('user_id', \Auth::id())->first();
        $cart->status = 'checkout';
        $cart->save();

        $referenceNo    = $date;
        $validity       = Carbon::now()->addDay(1);
        $validDate      = $validity->format('Ymd');
        $validTime      = $validity->format('His');

        $merchantToken = hash('sha256', $timestamp . $iMid . $referenceNo . $amt . $merchantKey);

        $jsonData = [
            'timeStamp'       => $timestamp,
            'iMid'            => $iMid,
            'payMethod'       => '02',
            'currency'        => 'IDR',
            'amt'             => $amt,
            'referenceNo'     => $referenceNo,
            'goodsNm'         => $referenceNo,
            'billingNm'       => $name,
            'billingPhone'    => $phone ? $phone : '12345678',
            'billingEmail'    => $email,
            'billingAddr'     => $address,
            'billingCity'     => $city,
            'billingState'    => $province,
            'billingPostCd'   => $postal,
            'billingCountry'  => 'Indonesia',
            'deliveryNm'      => $email,
            'deliveryPhone'   => $phone,
            'deliveryAddr'    => $address,
            'deliveryCity'    => $city,
            'deliveryState'   => $province,
            'deliveryPostCd'  => $postal,
            'deliveryCountry' => 'Indonesia',
            'dbProcessUrl'    => env('NICEPAY_DB_PROCESS_URL'),
            'vat'             => '',
            'fee'             => '',
            'notaxAmt'        => '',
            'description'     => 'VIRTUAL ACCOUNT PAYMENT FOR ' . $referenceNo,
            'merchantToken'   => $merchantToken,
            'userIP'          => $ip,
            'cartData'        => $cartData,
            'bankCd'          => $this->getBankCode($bankName),
            'vacctValidDt'    => $validDate,
            'vacctValidTm'    => $validTime,
            'payValidDt'      => $validDate,
            'payValidTm'      => $validTime,
        ];

        $registration = new NicepayEnterpriseRegistration;
        $registration->create($jsonData);

        $jsonDataEncoded = json_encode($jsonData);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $curl_result = curl_exec($ch);
        $result      = json_decode($curl_result);

        $responseData = array_merge((array) $result, ['data' => json_encode($result)]);

        $registrationResponse = new NicepayEnterpriseRegistrationResponse;
        $registrationResponse->create($responseData);

        return $result;
    }

    public function registrationMultiCvs($cartData, $order, $method, $ip, $cs)
    {
        $apiUrl         = 'https://api.nicepay.co.id/nicepay/direct/v2/registration';
        $ch             = curl_init($apiUrl);

        $timestamp      = Carbon::now()->timestamp;
        $iMid           = env('NICEPAY_IMID');
        $merchantKey    = env('NICEPAY_MERCHANT_KEY');

        $orders     = Order::whereIn('id', $order)->get();
        $date       = date('ymdHis');
        $amt        = 0;
        foreach ($orders as $order) {
            $amt += $order->grand_total;
            $name     = $order->user->name;
            $phone    = $order->user->phone;
            $email    = $order->user->email;
            $address  = $order->user->addressDefault->address;
            $city     = $order->user->addressDefault->city;
            $province = $order->user->addressDefault->province;
            $postal   = $order->user->addressDefault->postal_code;

            $order->multi_code = $date;
            $order->save();
        }

        $cart         = Cart::where('status', 'current')->where('type', 'cart')->where('user_id', \Auth::id())->first();
        $cart->status = 'checkout';
        $cart->save();

        $referenceNo    = $date;
        $validity       = Carbon::now()->addDay(1);
        $validDate      = $validity->format('Ymd');
        $validTime      = $validity->format('His');

        $merchantToken = hash('sha256', $timestamp . $iMid . $referenceNo . $amt . $merchantKey);

        $jsonData = [
            'timeStamp' => $timestamp,
            'iMid'      => $iMid,
            'payMethod' => '03',
            'currency'  => 'IDR',
            'amt'       => $amt,

            'referenceNo'    => $referenceNo,
            'goodsNm'        => $referenceNo,
            'billingNm'      => $name,
            'billingPhone'   => $phone,
            'billingEmail'   => $email,
            'billingAddr'    => $address,
            'billingCity'    => $city,
            'billingState'   => $province,
            'billingPostCd'  => $postal,
            'billingCountry' => 'Indonesia',
            'dbProcessUrl'   => env('NICEPAY_DB_PROCESS_URL'),
            'vat'            => '',
            'fee'            => '',
            'notaxAmt'       => '',
            'description'    => 'CONVENIENCE STORE PAYMENT FOR ' . $referenceNo,
            'merchantToken'  => $merchantToken,
            'userIP'         => $ip,
            'cartData'       => $cartData,
            'mitraCd'        => $this->getCsCode($cs),
            'vacctValidDt'   => $validDate,
            'vacctValidTm'   => $validTime,
            'payValidDt'     => $validDate,
            'payValidTm'     => $validTime,
        ];

        $registration = new NicepayEnterpriseRegistration;
        $registration->create($jsonData);

        $jsonDataEncoded = json_encode($jsonData);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $curl_result = curl_exec($ch);
        $result      = json_decode($curl_result);

        $responseData = array_merge((array) $result, ['data' => json_encode($result)]);

        $registrationResponse = new NicepayEnterpriseRegistrationResponse;
        $registrationResponse->create($responseData);

        return $result;
    }

    public function registrationMultiCC($cartData, $order, $method, $ip, $cs)
    {
        $apiUrl             = 'https://www.nicepay.co.id/nicepay/api/orderRegist.do';
        $timeout_connect    = 30;

        $iMid           = env('NICEPAY_IMID');
        $merchantKey    = env('NICEPAY_MERCHANT_KEY');
        $amt            = $order->grand_total;

        $orders     = Order::whereIn('id', $order)->get();
        $date       = date('ymdHis');
        $amt        = 0;
        foreach ($orders as $order) {
            $amt += $order->grand_total;
            $name     = $order->user->name;
            $phone    = $order->user->phone;
            $email    = $order->user->email;
            $address  = $order->user->addressDefault->address;
            $city     = $order->user->addressDefault->city;
            $province = $order->user->addressDefault->province;
            $postal   = $order->user->addressDefault->postal_code;

            $order->multi_code = $date;
            $order->save();
        }

        $cart         = Cart::where('status', 'current')->where('type', 'cart')->where('user_id', \Auth::id())->first();
        $cart->status = 'checkout';
        $cart->save();

        $referenceNo    = $date;

        $merchantToken = hash('sha256', $iMid . $referenceNo . $amt . $merchantKey);

        $jsonData = [
            'iMid'            => $iMid,
            'payMethod'       => '01',
            'currency'        => 'IDR',
            'merchantKey'     => env('NICEPAY_MERCHANT_KEY'),
            'amt'             => $amt,
            'instmntType'     => 1,
            'instmntMon'      => 1,
            'referenceNo'     => $referenceNo,
            'goodsNm'         => $referenceNo,
            'billingNm'       => $name,
            'billingPhone'    => $phone,
            'billingEmail'    => $email,
            'billingAddr'     => $address,
            'billingCity'     => $city,
            'billingState'    => $province,
            'billingPostCd'   => $postal,
            'billingCountry'  => 'Indonesia',
            'deliveryNm'      => $email,
            'deliveryPhone'   => $phone,
            'deliveryAddr'    => $address,
            'deliveryCity'    => $city,
            'deliveryState'   => $province,
            'deliveryPostCd'  => $postal,
            'deliveryCountry' => 'Indonesia',
            'callBackUrl'     => env('NICEPAY_CALL_BACK_URL'),
            'dbProcessUrl'    => env('NICEPAY_DB_PROCESS_URL'),
            'description'     => 'CREDIT CARD PAYMENT FOR ' . $referenceNo,
            'merchantToken'   => $merchantToken,
            'userIP'          => $ip,
            'cartData'        => $cartData,
        ];

        $registration = new NicepayEnterpriseRegistration;
        $registration->create($jsonData);

        $postData = '';
        foreach ($jsonData as $key => $value) {
            $postData .= urlencode($key) . '=' . urlencode($value) . '&';
        }
        $postData = rtrim($postData, '&');
        $ch       = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout_connect);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout_connect);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $curl_result = curl_exec($ch);
        $result      = json_decode(substr($curl_result, 4));

        $responseData = array_merge((array) $result, ['data' => json_encode($result), 'referenceNo' => $referenceNo]);

        $registrationResponse = new NicepayEnterpriseRegistrationResponse;
        $registrationResponse->create($responseData);

        return $result;
    }

    public function checkTransaction($order)
    {
        $apiUrl             = 'https://www.nicepay.co.id/nicepay/direct/v2/inquiry';
        $timeout_connect    = 30;
        $ch                 = curl_init($apiUrl);

        $timestamp      = Carbon::now()->timestamp;
        $iMid           = env('NICEPAY_IMID');
        $merchantKey    = env('NICEPAY_MERCHANT_KEY');
        $amt            = $order->grand_total;

        $referenceNo    = $order->order_code;
        $merchantToken  = hash('sha256', $timestamp . $iMid . $referenceNo . $amt . $merchantKey);

        $jsonData = [
            'timeStamp'     => $timestamp,
            'tXid'          => $order->response->tXid,
            'iMid'          => $iMid,
            'referenceNo'   => $order->order_code,
            'amt'           => $amt,
            'merchantToken' => $merchantToken
        ];
        $jsonDataEncoded = json_encode($jsonData);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $curl_result = curl_exec($ch);
        $result      = json_decode($curl_result);

        return $result;
    }

    public function checkMultiTransaction($order)
    {
        $apiUrl             = 'https://www.nicepay.co.id/nicepay/direct/v2/inquiry';
        $timeout_connect    = 30;
        $ch                 = curl_init($apiUrl);

        $timestamp      = Carbon::now()->timestamp;
        $iMid           = env('NICEPAY_IMID');
        $merchantKey    = env('NICEPAY_MERCHANT_KEY');
        $amt            = $order->grand_total;

        $referenceNo    = $order->multi_code;
        $merchantToken  = hash('sha256', $timestamp . $iMid . $referenceNo . $amt . $merchantKey);

        $jsonData = [
            'timeStamp'     => $timestamp,
            'tXid'          => $order->multiResponse->tXid,
            'iMid'          => $iMid,
            'referenceNo'   => $referenceNo,
            'amt'           => $amt,
            'merchantToken' => $merchantToken
        ];
        $jsonDataEncoded = json_encode($jsonData);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $curl_result = curl_exec($ch);
        $result      = json_decode($curl_result);

        return $result;
    }

    private function getBankCode($bankName)
    {
        switch ($bankName) {
            case 'mandiri':
                return 'BMRI';
                break;
            case 'maybank':
                return 'IBBK';
                break;
            case 'permata':
                return 'BBBA';
                break;
            case 'bca':
                return 'CENA';
                break;
            case 'bni':
                return 'BNIN';
                break;
            case 'hana':
                return 'HNBN';
                break;
            case 'bri':
                return 'BRIN';
                break;
            case 'cimb':
                return 'BNIA';
                break;
            case 'danamon':
                return 'BDIN';
                break;

            default:
                return 'OTHR';
                break;
        }
    }

    private function getCsCode($cs)
    {
        switch ($cs) {
            case $cs == 'indomaret':
                return 'INDO';
                break;
            case $cs == 'alfamart':
                return 'ALMA';
                break;

            default:
                return 'INDO';
                break;
        }
    }
}
