<?php

namespace App\Libraries;

use App\Cart;
use App\Pickpoint;
use App\UserAddress;

class GosendLib
{
    protected $clientID = null;
    protected $passKey  = null;
    protected $authKey  = null;

    public function __construct()
    {
        $this->clientID     = env('GOSEND_CLIENT_ID');
        $this->passKey      = env('GOSEND_PASS_KEY');
        $this->authKey      = env('GOSEND_AUTH_KEY');
    }

    public function checkPrice($address)
    {
        $myAddress      = UserAddress::find($address);

        if ($myAddress->lat) {
            $destination = $myAddress->lat . ',' . $myAddress->long;
        }

        // ------------------------------------------------------------------
        // GET NEAREST BY PROVINVE ID SAME TO DELIVERY PROVINCE ID
        // ------------------------------------------------------------------

        $pickpoints     = Pickpoint::where('province_id', $myAddress->province_id)->where('is_active', 1)->get();
        $min            = PHP_INT_MAX;

        foreach ($pickpoints as $i => $pickpoint) {
            $token          = env('GOOGLEMAP_API');
            $origin         = $pickpoint->latitude . ',' . $pickpoint->longitude;
            $mapApiUrl      = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=' . $origin . '&destinations=' . $destination . '&key=' . $token . '';
            $chx            = curl_init($mapApiUrl);

            curl_setopt($chx, CURLOPT_POST, 0);
            curl_setopt($chx, CURLOPT_HTTPHEADER, [
                ' Content - Type: application / json ',
                ' Accept: application / json',
            ]);
            curl_setopt($chx, CURLOPT_RETURNTRANSFER, true);

            $curl_map_result = curl_exec($chx);
            $mapresult       = json_decode($curl_map_result);

            // NEAREST
            if ($mapresult->rows[0]->elements[0]->distance->value < $min) {
                $nearestPickup = $pickpoint->id;
                $min           = $mapresult->rows[0]->elements[0]->distance->value;
            }
        }

        $nearest        = Pickpoint::find($nearestPickup);
        $warehouse      = $nearest->latitude . ',' . $nearest->longitude;

        // ---------------------------------

        $apiUrl         = 'https://kilat-api.gojekapi.com/gokilat/v10/calculate/price?origin=' . $warehouse . '&destination=' . $destination . '&paymentType=3';
        $ch             = curl_init($apiUrl);

        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
            'Client-ID: ' . $this->clientID . '',
            'Pass-Key: ' . $this->passKey . '',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $curl_result = curl_exec($ch);
        $result      = json_decode($curl_result);

        $output = [];
        $i      = 0;

        foreach ($result as $key => $val) {
            if ($val->active) {
                $output[$i]['type']                 = strtolower($key);
                $output[$i]['pickpoint_id']         = $nearest->id;
                $output[$i]['pickpoint_address']    = $nearest->address;
                $output[$i]['name']                 = $val->shipment_method;
                $output[$i]['price']                = $val->price->total_price;
                $i++;
            }
        }

        return $output;
    }

    public function book($order)
    {
        $apiUrl         = 'https://kilat-api.gojekapi.com/gokilat/v10/booking';
        $ch             = curl_init($apiUrl);

        $pickpoint      = Pickpoint::find($order->cart->pickpoint_id);
        $destination    = UserAddress::find($order->cart->user_address_id);

        $products       = '';
        $myCart         = Cart::with('details')->find($order->cart->id);

        foreach ($myCart->details as $det) {
            $products .= $det->product->name;
            $products .= ',';
        }

        $pickpointCoordinates   = $pickpoint->latitude . ',' . $pickpoint->longitude;
        $destinationCoordinates = $destination->lat . ',' . $destination->long;

        $goMethod = $order->cart->courier_type_id == 'instant' ? 'Instant' : 'SameDay';

        $payload = '{
            "paymentType": 3,
            "collection_location": "pickup",
            "shipment_method": "' . $goMethod . '",
            "routes": [
              {
                "originName": "' . $pickpoint->name . '",
                "originNote": "",
                "originContactName": "' . $pickpoint->contact_person . '",
                "originContactPhone": "' . $pickpoint->contact_phone . '",
                "originLatLong": "' . $pickpointCoordinates . '",
                "originAddress": "' . trim(preg_replace('/\s\s+/', ' ', $pickpoint->address)) . '",
                "destinationName": "' . $destination->name . '",
                "destinationNote": "",
                "destinationContactName": "' . $destination->name . '",
                "destinationContactPhone": "' . $destination->phone_number . '",
                "destinationLatLong": "' . $destinationCoordinates . '",
                "destinationAddress": "' . trim(preg_replace('/\s\s+/', ' ', $destination->address)) . '",
                "item": "' . $products . '",
                "storeOrderId": "' . $order->order_code . '",
                "insuranceDetails": {
                  "applied": "false",
                  "fee": "",
                  "product_description": "' . $products . '",
                  "product_price": "' . $order->subtotal . '"
                }
              }
            ]
          }';

        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
            'Client-ID: ' . $this->clientID . '',
            'Pass-Key: ' . $this->passKey . '',
        ]);

        $curl_result = curl_exec($ch);
        
        // $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        // $header = substr($curl_result, 0, $header_size);
        // $body = substr($curl_result, $header_size);

        return $curl_result;
    }

    public function cancel($order)
    {
        $apiUrl         = 'https://kilat-api.gojekapi.com/gokilat/v10/booking/cancel';
        $ch             = curl_init($apiUrl);

        $payload = '{
            "orderNo": "' . $order->gosendStatus->code . '"
          }';

        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
            'Client-ID: ' . $this->clientID . '',
            'Pass-Key: ' . $this->passKey . '',
        ]);

        $curl_result = curl_exec($ch);

        return $curl_result;
    }

    public function checkStatus($order)
    {
        $apiUrl         = 'https://kilat-api.gojekapi.com/gokilat/v10/booking/storeOrderId/' . $order->order_code;
        $ch             = curl_init($apiUrl);

        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
            'Client-ID: ' . $this->clientID . '',
            'Pass-Key: ' . $this->passKey . '',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $curl_result = curl_exec($ch);
        $result      = json_decode($curl_result);

        return $curl_result;
    }

    public function checkPriceMulti($address)
    {
        $myAddress      = UserAddress::find($address);

        if ($myAddress->lat) {
            $destination = $myAddress->lat . ',' . $myAddress->long;
        }

        // ------------------------------------------------------------------
        // GET NEAREST BY PROVINVE ID SAME TO DELIVERY PROVINCE ID
        // ------------------------------------------------------------------

        $pickpoints     = Pickpoint::where('province_id', $myAddress->province_id)->get();
        $min            = PHP_INT_MAX;

        foreach ($pickpoints as $i => $pickpoint) {
            $token          = env('GOOGLEMAP_API');
            $origin         = $pickpoint->latitude . ',' . $pickpoint->longitude;
            $mapApiUrl      = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=' . $origin . '&destinations=' . $destination . '&key=' . $token . '';
            $chx            = curl_init($mapApiUrl);

            curl_setopt($chx, CURLOPT_POST, 0);
            curl_setopt($chx, CURLOPT_HTTPHEADER, [
                ' Content - Type: application / json ',
                ' Accept: application / json',
            ]);
            curl_setopt($chx, CURLOPT_RETURNTRANSFER, true);

            $curl_map_result = curl_exec($chx);
            $mapresult       = json_decode($curl_map_result);

            // NEAREST
            if ($mapresult->rows[0]->elements[0]->distance->value < $min) {
                $nearestPickup = $pickpoint->id;
                $min           = $mapresult->rows[0]->elements[0]->distance->value;
            }
        }

        $nearest        = Pickpoint::find($nearestPickup);
        $warehouse      = $nearest->latitude . ',' . $nearest->longitude;

        // ---------------------------------

        $apiUrl         = 'https://kilat-api.gojekapi.com/gokilat/v10/calculate/price?origin=' . $warehouse . '&destination=' . $destination . '&paymentType=3';
        $ch             = curl_init($apiUrl);

        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
            'Client-ID: ' . $this->clientID . '',
            'Pass-Key: ' . $this->passKey . '',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $curl_result = curl_exec($ch);
        $result      = json_decode($curl_result);

        $i = 0;

        $regular = '<option>Select Courier</option>';
        foreach ($result as $key => $val) {
            if ($val->active) {
                $regular .= '<option value="' . $val->shipment_method . '" data-value="' . $val->price->total_price . '">GO-SEND ' . $val->shipment_method . ' (' . currency_format($val->price->total_price) . ')</option>';
            }
        }

        return $regular;
    }
}