<?php

namespace App\Http\Controllers\Frontend;

use App\Cart;
use App\UserAddress;
use Illuminate\Http\Request;
use App\City;
use Validator;
use App\Product;
use App\Libraries\GosendLib;

class AjaxController extends CoreController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function rajaongkirGetCity(Request $request)
    {
        $query              = $request->get('query');
        $result             = City::with('province')->where('city_name', 'LIKE', '%' . $query . '%')->orderBy('city_name', 'ASC')->get();
        $data['cities']    = $result;

        $data['status'] = true;

        return response()->json($data);
    }

    public function rajaongkirGetSubdistrict(Request $request)
    {
        $city = $request->city;

        $data['getSubdistrict'] = $this->getSubdistrict($city);

        //$data['getPostalCode'] = Product::getPostalCode($province);
        // $data['getPostalCode'] = $this->getPostalCodeAuto($city);

        $data['result'] = 'Success.';

        return response()->json($data);
    }

    public function editAddress(Request $request)
    {
        // validation
        $request->validate([
            'addressId' => 'required'
        ]);

        // id from user_member_addresses
        $id = $request->addressId;

        // get the address by id and user_member_id from user_member_addresses table
        $userMemberAddress = UserAddress::where('id', $id)->where('user_id', \Auth::id())->first();

        $data['address']    = $userMemberAddress;

        $data['result'] = 'Success.';

        return response()->json($data);
    }

    public function getAddress(Request $request)
    {
        // validation
        $request->validate([
            'addressId' => 'required'
        ]);

        if ($request->quickbuy) {
            $cart = Cart::with('details', 'details.product', 'details.product.cover', 'details.product.brand')
                ->where('status', 'current')
                ->where('type', '=', 'buynow')
                ->where('user_id', \Auth::id())->first();
        } else {
            $cart = Cart::with('details', 'details.product', 'details.product.cover', 'details.product.brand')
                ->where('status', 'current')
                ->where('type', '!=', 'buynow')
                ->where('user_id', \Auth::id())->first();
        }

        $cart->user_address_id = $request->addressId;
        $cart->courier_type_id = '';
        $cart->courier_cost    = '';
        $cart->save();

        $data['result'] = 'Success.';

        return response()->json($data);
    }

    public function saveCurrentPinpoint(Request $request)
    {
        $cart = $this->getUserCart();

        $address = UserAddress::find($cart->user_address_id);
        if ($address) {
            if (\Auth::id() == $address->user_id) {
                $address->lat  = $request->lat;
                $address->long = $request->long;
                $address->save();

                \Session::flash('success', 'Koordinat Alamat Berhasil disimpan');
                return response()->json(
                    [
                        'status' => true
                    ]
                );
            }
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'You are not allowed'
                ]
            );
        }
    }

    public function getUserAddress(Request $request)
    {
        $address = UserAddress::where('user_id', \Auth::id())->whereNotIn('id', $request->data)->get();
        // dd($address);
        $this->data['addresses']    = $address;
        $this->data['product']      = $request->product;
        $template                   = view('frontend.checkout.includes.parts.address_list', $this->data)->render();
        return response()->json([
            'status'    => true,
            'message'   => $template,
        ]);
    }


    public function saveUseAddress(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'label'         => 'required',
                'name'          => 'required',
                'city'          => 'required',
                'postal_code'   => 'required',
                'address'       => 'required',
                'phone_number'  => 'required'
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors()->all();

            $message = implode('<br/>', $message);
            return response()->json(['status' => false, 'message' => $message]);
        } else {
            $cityProv   = explode(',', $request->city);
            $getCity    = explode('-', $cityProv[0]);
            $getProv    = explode('-', $cityProv[1]);

            $default = 0;
            if ($request->is_default) {
                $default         = 1;
                $setOtherAddress = UserAddress::where('user_id', \Auth::id())->get();

                // SET OTHER ADDRESS AS NOT DEFAULT
                if ($setOtherAddress) {
                    foreach ($setOtherAddress as $dd) {
                        $dd->update(['is_default' => 0]);
                    }
                }
            } else {
                $getOtherAddress = UserAddress::where('user_id', \Auth::id())->where('is_default', 1)->first();
                if ($getOtherAddress) {
                    $default = 0;
                } else {
                    $default = 1;
                }
            }
            $userAddress = UserAddress::create([
                'user_id'           => \Auth::id(),
                'label'             => $request->label,
                'name'              => $request->name,
                'province_id'       => $getProv[0],
                'province'          => $getProv[1],
                'city_id'           => $getCity[0],
                'city'              => $getCity[1],
                // 'subdistrict_id'    => $getSubdistrict[0],
                // 'subdistrict'       => $getSubdistrict[1],
                'postal_code'       => $request->postal_code,
                'address'           => $request->address,
                'phone_number'      => $request->phone_number,
                'lat'               => $request->lat,
                'long'              => $request->long,
                'is_default'        => $default
            ]);

            if (\Auth::id() == $userAddress->user_id) {
                $product                  = Product::find($request->product);
                $this->data['address']    = $userAddress;
                $this->data['product']    = $product;
                $template             = view('frontend.checkout.includes.parts.multi_address', $this->data)->render();

                return response()->json([
                    'status'    => true,
                    'message' => $template,
                ]);
            }
        }
    }

    public function useAddress(Request $request)
    {
        $cart = $this->getUserCart();
        $address = UserAddress::find($request->id);
        if (\Auth::id() == $cart->user_id && \Auth::id() == $address->user_id) {
            $cart->user_address_id = $request->id;
            $cart->save();
            return response()->json(
                [
                    'status' => true
                ]
            );
        }
        return response()->json(
            [
                'status' => false,
                'message' => 'You are not allowed'
            ]
        );
    }

    public function setAddressMulti(Request $request)
    {
        $address = UserAddress::find($request->address);
        if (\Auth::id() == $address->user_id) {
            $product                  = Product::find($request->product);
            $this->data['address']    = $address;
            $this->data['product']    = $product;
            $template             = view('frontend.checkout.includes.parts.multi_address', $this->data)->render();

            return response()->json([
                'status'    => true,
                'message' => $template,
            ]);
        }
    }

    private function getUserCart()
    {

        $cart = Cart::with('details', 'details.product', 'details.product.cover', 'details.product.brand')
            ->where('status', 'current')
            ->where('type', '=', 'cart')
            ->where('user_id', \Auth::id())->first();
        return $cart;
    }

    public function multiGetCourier(Request $request)
    {
        $cart = Cart::with('address')->find($request->cart);
        if ($cart) {
            if ($cart->user_id == \Auth::id()) {
                $duration = (int)$request->duration;
                if ($duration !== 1) {
                    $origin                   = env('SHOP_ORIGIN_SUBDISTRICT') ? env('SHOP_ORIGIN_SUBDISTRICT') : env('SHOP_ORIGIN_CITY');
                    $originType               = env('SHOP_ORIGIN_SUBDISTRICT') ? 'city' : 'subdistrict';
                    $destination              = $cart->address->city_id;
                    $destinationType          = 'city';
                    $weight                   = 0;
                    $duration                 = $request->duration;

                    foreach ($cart->details as $detail) {
                        $tmpWeight = $detail->qty * $detail->product->weight;
                        $weight += $tmpWeight;
                    }

                    $courier = $this->getCostByDuration($origin, $originType, $destination, $destinationType, $weight, 'tiki:jne:rex', $duration);

                    return response()->json(['status' => true, 'message' => $courier]);
                } else {
                    if ($cart->address->lat) {
                        $gojek          = new GosendLib;
                        $gosend         = $gojek->checkPriceMulti($cart->address->id);
                        return response()->json(['status' => true, 'message' => $gosend]);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Alamat tidak memiliki koordinat, mohon input/edit pinpoint alamat ini']);
                    }
                }
            }
        }
        return response()->json(['status' => false]);
    }
}
