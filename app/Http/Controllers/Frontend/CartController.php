<?php

namespace App\Http\Controllers\Frontend;

use App\Cart;
use App\CartDetail;
use App\Events\Order\Payment\Pending;
use App\Libraries\GosendLib;
use App\Libraries\NicepayLib;
use App\Order;
use App\OrderDetail;
use App\Pickpoint;
use App\Product;
use App\User;
use App\UserAddress;
use App\UserReward;
//use App\Veritrans\Midtrans;
use App\Veritrans\Veritrans;
use App\Voucher;
use Carbon\Carbon;
use function GuzzleHttp\json_decode;
use Illuminate\Http\Request;
use Validator;
use DB;

class CartController extends CoreController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        Veritrans::$serverKey    = env('MIDTRANS_SERVER_KEY');
        //Midtrans::$serverKey     = 'SB-Mid-server-XdJony36hI9wqrhYXHO0OxFO';
        Veritrans::$isProduction = env('MIDTRANS_PRODUCTION');
        //Midtrans::$isProduction  = 'false';
    }

    public function index()
    {
        $carts  = $this->getUserCart();

        // session()->forget('voucher');

        if (!$carts) {
            return redirect()->route('frontend.home');
        }

        $this->data['shoppingCartLists'] = $carts;

        return $this->renderView('frontend.checkout.order');
    }

    public function addToCart(Request $request)
    {
        session()->forget('voucher');
        $product        = Product::find($request->id);
        $qty_available  = \App\Service\PurchaseLimitService::availableQty(\Auth::user()->id, $product->id);
        $cart           = Cart::firstOrCreate([
            'user_id'          => \Auth::user()->id,
            'status'           => 'current',
            'type'             => 'cart'
        ]);

        if ($product) {
            if ($request->qty && $request->qty > 0) {
                $qty  = $request->qty;
            } else {
                $qty = 1;
            }

            $item = null;
            foreach ($cart->details as $d) {
                if ($d->product_id == $product->id) {
                    $item = $d;
                }
            }

            $ticket        = [];
            $token         = '';
            $token_expired = '';
            $order_result  = '';

            if ($item) {
                if (($item->qty + $qty) <= $product->stock) {
                    if ($item->qty + $qty > $qty_available) {
                        return response()->json(['status' => false, 'message' => 'You have purchase maximum limit of this product']);
                    } else {
                        $item->qty = $item->qty + $qty;
                        $item->save();
                    }
                } else {
                    return response()->json(['status' => false, 'message' => 'We are sorry, the stock is not enough ']);
                }
            } else {
                if ($qty > $product->stock) {
                    return response()->json(['status' => false, 'message' => 'We are sorry, the stock is not enough ']);
                } else {
                    if ($qty > $qty_available) {
                        return response()->json(['status' => false, 'message' => 'You have purchase maximum limit of this product']);
                    } else {
                        CartDetail::create([
                            'cart_id'        => $cart->id,
                            'product_id'     => $product->id,
                            'product_name'   => $product->name,
                            'product_price'  => $product->isDiscount() ? $product->discounted_price : $product->price,
                            'product_weight' => $product->weight,
                            'qty'            => $qty,
                        ]);
                    }
                }
            }

            $this->data['cart']    = $this->recalculateCart();
            $smallCart             = view('frontend.includes.header_cart', $this->data)->render();

            return response()->json([
                'status'    => true,
                'message'   => 'Success',
                'cartsmall' => $smallCart,
            ]);
        } else {
            return response()->json(['status' => false, 'message' => 'Product Not Exists']);
        }
    }

    public function buyNow(Request $request)
    {
        session()->forget('voucher');
        $product = Product::find($request->id);
        $qty_available  = \App\Service\PurchaseLimitService::availableQty(\Auth::user()->id, $product->id);

        $cart    = Cart::firstOrCreate([
            'user_id'          => \Auth::id(),
            'status'           => 'current',
            'type'             => 'buynow'
        ]);

        $res = CartDetail::where('cart_id', $cart->id)->delete();

        if ($product) {
            if ($request->qty && $request->qty > 0) {
                $qty  = $request->qty;
            } else {
                $qty = 1;
            }

            $item = null;
            foreach ($cart->details as $d) {
                if ($d->product_id == $product->id) {
                    $item = $d;
                }
            }

            $ticket        = [];
            $token         = '';
            $token_expired = '';
            $order_result  = '';

            if ($item) {
                if ($product->type == 'product') {
                    if (($item->qty + $qty) <= $product->stock) {
                        if ($item->qty + $qty > $qty_available) {
                            return response()->json(['status' => false, 'message' => 'You have purchase maximum limit of this product']);
                        } else {
                            $item->qty = $item->qty + $qty;
                            $item->save();
                        }
                    } else {
                        return response()->json(['status' => false, 'message' => 'We are sorry, the stock is not enough ']);
                    }
                } else {
                    $unbook   = $this->LoketCom_API('POST', 'order/unbook', ['token' => $item->loketcom_token, 'id_ticket' => $item->product->id_ticket]);

                    $gettoken = $this->LoketCom_API('POST', '/order/create', ['notes' => $cart->id, 'expired_minutes' => 15]);
                    $token    = $gettoken->result->token;

                    $order_book = $this->LoketCom_API('POST', 'order/book', ['token' => $token, 'id_ticket' => $product->id_ticket, 'qty' => $qty]);
                    if ($order_book->status == false) {
                        return response()->json(['status' => false, 'message' => $order_book->result->error_message]);
                    }
                    $token_expired = $order_book->result->invoice_expired;
                    $order_result  = json_encode($order_book->result);

                    if (($item->qty + $qty) <= $ticket->available_qty) {
                        if (($item->qty + $qty) > $ticket->max_buy_qty) {
                            return response()->json(['status' => false, 'message' => 'You already add the maximum buy quantity']);
                        }
                        $item->qty            = $item->qty + $qty;
                        $item->loketcom_token = $token;
                        $item->token_expired  = $token_expired;
                        $item->order_result   = $order_result;
                        $item->save();
                    } else {
                        return response()->json(['status' => false, 'message' => 'You already add the maximum stock to your cart']);
                    }
                }
            } else {
                if ($qty > $product->stock) {
                    return response()->json(['status' => false, 'message' => 'We are sorry, the stock is not enough ']);
                }

                if ($qty > $qty_available) {
                    return response()->json(['status' => false, 'message' => 'You have purchase maximum limit of this product']);
                }

                CartDetail::create([
                    'cart_id'        => $cart->id,
                    'product_id'     => $product->id,
                    'product_name'   => $product->name,
                    'product_price'  => $product->isDiscount() ? $product->discounted_price : $product->price,
                    'product_weight' => $product->weight,
                    'qty'            => $qty,
                    'loketcom_token' => $token,
                    'token_expired'  => $token_expired,
                    'order_result'   => $order_result,
                ]);
            }
            $this->data['cart']    = $this->recalculateQuickCart();

            return response()->json(['status' => true, 'redirect_url' => route('frontend.cart.shipping', ['type' => 'quickbuy'])]);
        } else {
            return response()->json(['status' => false, 'message' => 'Product Not Exists']);
        }
    }

    public function deleteCartSingle(Request $request)
    {
        session()->forget('voucher');
        $item = CartDetail::find($request->id);
        if ($item) {
            if ($item->cart->user_id == \Auth::id()) {
                $item->delete();

                $this->data['cart'] = $this->recalculateCart();
                $smallCart          = view('frontend.includes.header_cart', $this->data)->render();

                return response()->json([
                    'status'    => true,
                    'message'   => 'Produk telah dihapus',
                    'cartsmall' => $smallCart
                ]);
            }
        }
    }

    public function multipleDelete(Request $request)
    {
        session()->forget('voucher');
        $input = array_flatten($request->products);

        foreach ($input as $key => $id) {
            $item = CartDetail::find($id);
            if ($item) {
                if ($item->cart->user_id == \Auth::id()) {
                    $item->delete();
                } else {
                    return response()->json(['status' => false, 'message' => 'This product is not yours']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'cant find product']);
            }
        }

        $carts              = $this->recalculateCart();

        $this->data['cart'] = $carts;

        $smallCart          = view('frontend.includes.header_cart', $this->data)->render();

        return response()->json([
            'status'    => true,
            'message'   => 'Produk telah dihapus',
            'cartsmall' => $smallCart
        ]);
    }

    public function updateCart(Request $request)
    {
        $carts  = $this->getUserCart();
        $item   = CartDetail::find($request->rand);

        if ($item) {
            session()->forget('voucher');
            if ($item->cart->user_id == \Auth::id()) {
                if ($item->product->stock >= $request->qty) {
                    $qty_available  = \App\Service\PurchaseLimitService::availableQty(\Auth::user()->id, $item->product->id);
                    if ($request->qty > $qty_available) {
                        return response()->json(['status' => false, 'message' => 'You have purchase maximum limit of this product']);
                    } else {
                        $item->qty = $request->qty;
                        $item->save();

                        $this->data['cart'] = $this->recalculateCart();
                        $smallCart          = view('frontend.includes.header_cart', $this->data)->render();

                        return response()->json([
                            'status'    => true,
                            'message'   => 'Success',
                            'cartsmall' => $smallCart
                        ]);
                    }
                } else {
                    $this->data['cart'] = $carts;

                    return response()->json(['status' => false, 'message' => 'Stock not enough', 'cartsmall' => $smallCart]);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Cant find cart item']);
            }
        }
    }

    public function shipping(Request $request)
    {
        $cartType = $request->type;
        if (!$cartType) {
            $carts  = $this->getUserCart();
            //var_dump($carts);
            if (!$carts) {
                return redirect()->route('frontend.home');
            }
            if (!$carts->details->count()) {
                return redirect()->route('frontend.home');
            }

            $user = User::find(\Auth::id());

            if (!$carts->user_address_id) {
                if ($user->addressDefault()) {
                    $carts->user_address_id = $user->addressDefault->id;
                    $carts->save();
                }
            }

            if ($carts->user_address_id) {
                $existAddress = UserAddress::find($carts->user_address_id);
                if (!$existAddress) {
                    $carts->user_address_id = null;
                    $carts->save();
                    $carts->refresh();
                }
            }

            $weight         = $carts->total_weight;

            if ($carts->user_address_id) {
                $origin                   = env('SHOP_ORIGIN_SUBDISTRICT') ? env('SHOP_ORIGIN_SUBDISTRICT') : env('SHOP_ORIGIN_CITY');
                $originType               = env('SHOP_ORIGIN_SUBDISTRICT') ? 'city' : 'subdistrict';
                $destination              = $carts->address->city_id;
                if (!$destination) {
                    $carts->user_address_id = \Auth::user()->addressDefault->id;
                    $carts->save();
                    $destination = \Auth::user()->addressDefault->city_id;
                }

                $destinationType          = 'city';
                $courierCost              = $this->getCost($origin, $originType, $destination, $destinationType, $weight, 'tiki:jne:rex');

                $checkPickup = Pickpoint::where('province_id', $carts->address->province_id)->first();
                if ($checkPickup) {
                    if ($carts->address->lat && $carts->address->long) {
                        $gojek                    = new GosendLib;
                        $gosend                   = $gojek->checkPrice($carts->address->id);

                        $this->data['gosend']     = $gosend;
                    }
                }

                if ($courierCost) {
                    if ($courierCost['next_day']) {
                        $this->data['nextday']    = $courierCost['next_day'];
                    }
                    $this->data['regular']    = $courierCost['regular'];
                }
            }
            if ($user) {
                $this->data['provinces']  = $this->getProvince();
                $this->data['carts']      = $carts;
                $this->data['user']       = $user;
                $this->data['weight']     = $weight;

                return $this->renderView('frontend.checkout.checkout');
            } else {
                return redirect()->route('frontend.home');
            }
        }

        return redirect()->route('frontend.home');
    }

    public function shippingStore(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'shipping' => 'required',
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors()->all();

            $message = implode('<br/>', $message);
            \Session::flash('error', $message);
            \Session::flash('error_quotation', 'ok');
            $previousUrl = app('url')->previous();

            return back()->withInput();
        } else {
            $cart                     = $this->recalculateCart();
            $cartTotal                = $cart->total_price;

            $origin                   = env('SHOP_ORIGIN_SUBDISTRICT') ? env('SHOP_ORIGIN_SUBDISTRICT') : env('SHOP_ORIGIN_CITY');
            $originType               = env('SHOP_ORIGIN_SUBDISTRICT') ? 'city' : 'subdistrict';
            $destination              = $cart->address->city_id;
            $destinationType          = 'city';
            $weight                   = $cart->total_weight;

            $courier                  = $request->shipping;
            if ($courier == 'instant' || $courier == 'sameday') {
                $gojek  = new GosendLib;
                $gosend = $gojek->checkPrice($cart->address->id);
                if ($courier == 'instant') {
                    $cost = $gosend[0]['price'];
                } else {
                    $cost = $gosend[1]['price'];
                }

                $cart->pickpoint_id = $gosend[0] ? $gosend[0]['pickpoint_id'] : $gosend[1]['pickpoint_id'];
            } elseif ($courier == 'pickup') {
                $cost = 0;
            } else {
                $cost   = $this->checkCost($origin, $originType, $destination, $destinationType, $weight, $courier);
            }

            $cart->courier_cost       = $cost;
            $cart->courier_type_id    = $request->shipping;
            if ($request->insurance) {
                $insurance       = ($cartTotal * 0.003) + 5000;
                $cart->insurance = $insurance;
            } else {
                $cart->insurance = 0;
            }

            $cart->total_price        = $cartTotal;
            $cart->save();
			
            return redirect()->route('frontend.cart.payment');
        }
    }

    public function multishipping()
    {
        $carts  = $this->getUserCart();
        if (!$carts) {
            return redirect()->route('frontend.home');
        }
        $carts  = $this->recalculateCart();
        $this->data['carts']      = $carts;

        return $this->renderView('frontend.checkout.multiple_address');
    }

    public function multishippingStore(Request $request)
    {
        Cart::where('user_id', \Auth::id())->where('type', 'multi')->where('status', 'current')->delete();
        foreach ($request->address as $addressID => $products) {
            $checkAddress = UserAddress::find($addressID);
            if (!$checkAddress) {
                \Session::flash('error', 'Please Select Address');

                return redirect()->back()->withInput();
            }

            $cart    = Cart::create([
                'user_id'          => \Auth::user()->id,
                'status'           => 'current',
                'type'             => 'multi',
                'user_address_id'  => $addressID
            ]);
            $totalQty    = 0;
            $totalWeight = 0;
            $totalPrice  = 0;

            foreach ($products as $productID => $quantities) {
                foreach ($quantities as $qty) {
                    foreach ($qty as $value) {
                        $product = Product::find($productID);
                        $price   = $product->isDiscount() ? $product->discounted_price : $product->price;

                        $totalQty += $value;
                        $totalWeight += ($product->weight * $value);
                        $totalPrice += ($price * $value);

                        CartDetail::create([
                            'cart_id'        => $cart->id,
                            'product_id'     => $product->id,
                            'product_name'   => $product->name,
                            'product_price'  => $price,
                            'product_weight' => $product->weight,
                            'qty'            => $value
                        ]);

                        $cart->total_qty    = $totalQty;
                        $cart->total_weight = $totalWeight;
                        $cart->total_price  = $totalPrice;
                        $cart->save();
                    }
                }
            }
        }

        return redirect()->route('frontend.cart.multishipping.courier');
    }

    public function multiShippingCourier()
    {
        $carts          = Cart::where('user_id', \Auth::id())->where('type', 'multi')->where('status', 'current')->get();
        if (!$carts) {
            return redirect()->route('frontend.home');
        }

        $weight         = [];

        foreach ($carts as $i => $cart) {
            foreach ($cart->details as $detail) {
                $tmpWeight = $detail->qty * $detail->product->weight;
                $weight[$i] += $tmpWeight;
            }
        }

        $origin                   = env('SHOP_ORIGIN_SUBDISTRICT') ? env('SHOP_ORIGIN_SUBDISTRICT') : env('SHOP_ORIGIN_CITY');
        $originType               = env('SHOP_ORIGIN_SUBDISTRICT') ? 'city' : 'subdistrict';

        $couriers = [];

        $totalItem = 0;
        foreach ($carts as $i => $cart) {
            $cartWeight               = $weight[$i];
            $destination              = $cart->address->city_id;
            $destinationType          = 'city';
            $courierCost              = $this->getCost($origin, $originType, $destination, $destinationType, $cartWeight, 'tiki:jne:rex');

            $couriers[$i]['nextday'] = $courierCost['next_day'];
            $couriers[$i]['regular'] = $courierCost['regular'];

            $totalItem = $cart->details->sum('qty');
        }

        $user           = User::find(\Auth::id());

        $this->data['couriers']   = $couriers;

        if ($user) {
            $this->data['totalPrice'] = $carts->sum('total_price');
            $this->data['totalItem']  = $totalItem;
            $this->data['provinces']  = $this->getProvince();
            $this->data['mycarts']    = $carts;

            return $this->renderView('frontend.checkout.multi_checkout');
        } else {
            return redirect()->route('frontend.home');
        }
    }

    public function multiShippingCourierStore(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'shipping' => 'required',
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors()->all();

            $message = implode('<br/>', $message);
            \Session::flash('error', $message);

            return back()->withInput();
        } else {
            $insurance = $request->insurance;

            foreach ($request->shipping as $cart => $courier) {
                $cart                  = Cart::find($cart);
                $cart->courier_type_id = $courier;

                $cartTotal                = $cart->total_price;

                $origin                   = env('SHOP_ORIGIN_SUBDISTRICT') ? env('SHOP_ORIGIN_SUBDISTRICT') : env('SHOP_ORIGIN_CITY');
                $originType               = env('SHOP_ORIGIN_SUBDISTRICT') ? 'city' : 'subdistrict';
                $destination              = $cart->address->city_id;
                $destinationType          = 'city';
                $weight                   = $cart->total_weight;

                if ($courier == 'Instant' || $courier == 'Sameday') {
                    $gojek  = new GosendLib;
                    $gosend = $gojek->checkPrice($cart->address->id);
                    if ($courier == 'Instant') {
                        $cost = $gosend[0]['price'];
                    } else {
                        $cost = $gosend[1]['price'];
                    }
                } else {
                    $cost                     = $this->checkCost($origin, $originType, $destination, $destinationType, $weight, $courier);
                }

                $cart->courier_cost       = $cost;
                $cart->courier_type_id    = $courier;

                if ($insurance[$cart->id] == 1) {
                    $cart->insurance = ($cartTotal * 0.003) + 5000;
                } else {
                    $cart->insurance = 0;
                }

                $cart->total_price        = $cartTotal;
                $cart->save();
            }

            return redirect()->route('frontend.cart.payment', ['type' => 'multi']);
        }
    }

    public function paymentMethod(Request $request)
    {
        if (request()->type == 'multi') {
            $carts                        = Cart::with('details')->where('user_id', \Auth::id())->where('type', 'multi')->where('status', 'current')->get();
            if (empty($carts)) {
                return redirect()->route('frontend.home');
            }
            $this->data['totalInsurance'] = $carts->sum('insurance');
            $this->data['totalCourier']   = $carts->sum('courier_cost');
            $this->data['totalPrice']     = $carts->sum('total_price');
            $this->data['totalCourier']   = $carts->sum('courier_cost');
            $this->data['grandTotal']     = $carts->sum('courier_cost') + $carts->sum('total_price');
        } else {
            $carts = $this->getUserCart();
        }
        if (!$carts) {
            return redirect()->route('frontend.home');
        }

        //purchase limit last verification
        $errors = [];
        foreach ($carts as $itm) {
            $qty_available  = \App\Service\PurchaseLimitService::availableQty(\Auth::user()->id, $itm->product_id);
            if ($itm->qty > $qty_available) {
                $errors[] = "You have purchase maximum limit of " . $itm->product_name;
            }
        }

        if (!empty($errors)) {
            return redirect()->route('frontend.cart.index')->with("error_message", $errors);
        }

        $this->data['cart']    = $carts;

        $payments = Order::where('user_id', \Auth::id())->groupBy('payment_method', 'bank')->get()->take(4);
        if ($payments) {
            $this->data['payments'] = $payments;
        }

        return $this->renderView('frontend.checkout.payment_method');
    }

    public function virtualAccount($bank)
    {
        $carts = $this->getUserCart();
        if (!$carts) {
            return redirect()->route('frontend.home');
        }

        $acceptedBank = [
            'bca', 'bni', 'mandiri', 'permata', 'maybank', 'bri', 'danamon', 'cimb', 'hana'
        ];

        $ip = request()->ip();

       
		$order = $this->paymentProcess('virtual_account', $ip, $bank);

		// IF USING SOME OF REWARDS POINT
		if (session()->has('rewards')) {
			$userRewardExpense              = new UserReward;
			$userRewardExpense->user_id     = \Auth::id();
			$userRewardExpense->order_id    = $order->id;
			$userRewardExpense->points      = \Auth::user()->creditBalance();
			$userRewardExpense->type        = 'out';
			$userRewardExpense->save();

			session()->forget('rewards');
		}            

        return $order->payment_token;
    }

    public function pointPayment()
    {
        $voucher                      = session()->get('voucher');

        if (request()->type == 'multi') {
            $cart = Cart::where('user_id', \Auth::id())->where('type', 'multi')->where('status', 'current')->get();
        } else {
            $cart = $this->getUserCart();
        }
        if (!$cart) {
            return redirect()->route('frontend.home');
        }
        if (\Auth::user()->creditBalance() < $cart->total_price) {
            return redirect()->route('frontend.home');
        }

        $order  = $this->saveToOrder('reward_point', 'reward_point');

        $userRewardExpense              = new UserReward;
        $userRewardExpense->user_id     = \Auth::id();
        $userRewardExpense->order_id    = $order->id;
        $userRewardExpense->points      = $order->grand_total;
        $userRewardExpense->type        = 'out';
        $userRewardExpense->save();

        session()->forget('rewards');

        // UPDATE CART
        if (request()->type == 'multi') {
            foreach ($cart as $mycart) {
                $mycart->status = 'checkout';
                if ($voucher) {
                    $mycart->voucher_id   = $voucher['voucher_id'];
                }
                $mycart->save();
            }
        } else {
            $cart->status = 'checkout';
            if ($voucher) {
                $cart->voucher_id   = $voucher['voucher_id'];
            }
            $cart->save();
        }

        return redirect()->route('frontend.order.detail', $order->order_code);
    }

    public function convenienceStore($cvs)
    {
        $carts = $this->getUserCart();
        if (!$carts) {
            return redirect()->route('frontend.home');
        }

        $acceptedCS = [
            'indomaret', 'alfamart'
        ];

        $ip = request()->ip();

        if ($cvs) {
            if (in_array($cvs, $acceptedCS)) {
                $order = $this->paymentProcess('cvs', $ip, $cvs);
                // IF USING SOME OF REWARDS POINT
                if (session()->has('rewards')) {
                    $userRewardExpense              = new UserReward;
                    $userRewardExpense->user_id     = \Auth::id();
                    $userRewardExpense->order_id    = $order->id;
                    $userRewardExpense->points      = \Auth::user()->creditBalance();
                    $userRewardExpense->type        = 'out';
                    $userRewardExpense->save();

                    session()->forget('rewards');
                }

                return redirect()->route('frontend.order.detail', $order->order_code);
            }
        }

        return redirect()->route('frontend.home');
    }

    public function creditCard()
    {
        $carts = $this->getUserCart();

        if (!$carts) {
            return redirect()->route('frontend.home');
        }

        $ip = request()->ip();

        $order = $this->paymentProcess('cc', $ip, $bank);
        if (request()->type == 'multi') {
            $order->refresh();
            $result     = json_decode($order->multiResponse->data);
            $grandTotal = 0;
            $orders     = Order::where('multi_code', $order->multi_code)->get();
            foreach ($orders as $ord) {
                $grandTotal += $ord->grand_total;
            }

            // IF USING SOME OF REWARDS POINT
            if (session()->has('rewards')) {
                $userRewardExpense              = new UserReward;
                $userRewardExpense->user_id     = \Auth::id();
                $userRewardExpense->order_id    = $order->id;
                $userRewardExpense->points      = \Auth::user()->creditBalance();
                $userRewardExpense->type        = 'out';
                $userRewardExpense->save();

                session()->forget('rewards');
            }

            return redirect($result->data->requestURL . '?tXid=' . $result->data->tXid . '&amt=' . $grandTotal . '&referenceNo=' . $order->multi_code);
        } else {
            $result = json_decode($order->response->data);

            // IF USING SOME OF REWARDS POINT
            if (session()->has('rewards')) {
                $userRewardExpense              = new UserReward;
                $userRewardExpense->user_id     = \Auth::id();
                $userRewardExpense->order_id    = $order->id;
                $userRewardExpense->points      = \Auth::user()->creditBalance();
                $userRewardExpense->type        = 'out';
                $userRewardExpense->save();

                session()->forget('rewards');
            }

            return redirect($result->data->requestURL . '?tXid=' . $result->data->tXid . '&amt=' . $order->grand_total . '&referenceNo=' . $order->order_code);
        }
    }

    public function ovo(Request $request)
    {
        $carts = $this->getUserCart();

        if (!$carts) {
            return redirect()->route('frontend.home');
        }

        $ip = request()->ip();

        if (!$request->phone) {
            return back()->with('error', 'Mohon masukkan nomor telepon');
        }

        $order = $this->paymentProcess('ovo', $ip, $bank, $request->phone);
        if (request()->type == 'multi') {
            $order->refresh();
            $result     = json_decode($order->multiResponse->data);
            $grandTotal = 0;
            $orders     = Order::where('multi_code', $order->multi_code)->get();
            foreach ($orders as $ord) {
                $grandTotal += $ord->grand_total;
            }

            // IF USING SOME OF REWARDS POINT
            if (session()->has('rewards')) {
                $userRewardExpense              = new UserReward;
                $userRewardExpense->user_id     = \Auth::id();
                $userRewardExpense->order_id    = $order->id;
                $userRewardExpense->points      = \Auth::user()->creditBalance();
                $userRewardExpense->type        = 'out';
                $userRewardExpense->save();

                session()->forget('rewards');
            }

            return redirect($result->data->requestURL . '?tXid=' . $result->data->tXid . '&amt=' . $grandTotal . '&referenceNo=' . $order->multi_code);
        } else {
            $result = json_decode($order->response->data);

            // IF USING SOME OF REWARDS POINT
            // if (session()->has('rewards')) {
            //     $userRewardExpense              = new UserReward;
            //     $userRewardExpense->user_id     = \Auth::id();
            //     $userRewardExpense->order_id    = $order->id;
            //     $userRewardExpense->points      = \Auth::user()->creditBalance();
            //     $userRewardExpense->type        = 'out';
            //     $userRewardExpense->save();

            //     session()->forget('rewards');
            // }

            return redirect($result->data->requestURL . '?tXid=' . $result->data->tXid . '&amt=' . $order->grand_total . '&referenceNo=' . $order->order_code . '&mitraCd=OVOE');
        }
    }

    public function ovoProcess($order, Request $request)
    {
        $order        = Order::where('order_code', $request->referenceNo)->first();
        $cart         = Cart::find($order->cart_id);
        $cart->status = 'checkout';
        $cart->save();

        $paymentStatus  = new NicepayLib;
        $paymentStatus  = $paymentStatus->checkTransaction($order);
        if (isset($paymentStatus->status) && $paymentStatus->status == '0') {
            if ($order->status == 'pending') {
                $order->status         = 'paid';
                $order->payment_date   = Carbon::parse($paymentStatus->transDt . $paymentStatus->transTm);
                $order->payment_status = 1;
                $order->save();
                $order->refresh();

                session()->forget('voucher');
                $this->reduceStock($cart);
                $this->setSoldProduct($order);
                insertOrderLog($order, 'paid', 'callback ovo');

                event(new Pending($order));

                \Session::flash('success', 'Pembayaran OVO berhasil, Pesanan anda akan segera kami proses. Untuk mengecek pesanan anda mohon cek "My Order" di Profile Account Anda. Terima Kasih');

                return redirect('https://www.talasi.co.id');
            }
            return redirect('https://www.talasi.co.id');
        } else {
            $order->status         = 'failed';
            $order->save();
            $order->refresh();

            session()->forget('voucher');
            insertOrderLog($order, 'pending', 'callback ovo');

            \Session::flash('error', 'Pembayaran OVO gagal, silahkan lakukan pemesanan kembali. Terima Kasih');

            return redirect('https://www.talasi.co.id');
        }

        return redirect('https://www.talasi.co.id');
    }

    private function recalculateCart()
    {
        $user                    = \Auth::id();
        $carts                   = $this->getUserCart();
        $carts->courier_type_id  = null;
        $carts->courier_cost     = null;
        $carts->insurance        = null;

        if (!empty($carts->details)) {
            $totalQty       = 0;
            $totalWeight    = 0;
            $totalPrice     = 0;
            foreach ($carts->details as $d) {
                $totalQty += $d->qty;
                $totalWeight += $d->product_weight * $d->qty;
                $totalPrice += $d->product_price * $d->qty;
            }

            $carts->total_qty    = $totalQty;
            $carts->total_weight = $totalWeight;
            $carts->total_price  = $totalPrice;
            $carts->save();
        } else {
            $carts->total_qty    = 0;
            $carts->total_weight = 0;
            $carts->total_price  = 0;
            $carts->save();
        }

        return $carts;
    }

    public function checkVoucher(Request $request)
    {
        $code           = $request->code;
        $user_id        = \Auth::id();
        if ($request->type == 'quickbuy') {
            $carts                  = $this->getBuyNowCart();
        } else {
            $carts                  = $this->getUserCart();
        }
        $subtotal       = $carts->total_price;

        $voucher = Voucher::where('start_date', '<=', date('Y-m-d'))
            ->where('end_date', '>=', date('Y-m-d'))
            ->where('code', $code)
            ->first();

        if (!empty($voucher)) {
            $orderCount        = Order::where('voucher_id', $voucher->id)->where('status', '!=', 'failed')->count();
            $limitPerUserCount = Order::where('user_id', $user_id)->where('voucher_id', $voucher->id)->where('status', '!=', 'failed')->count();
        }

        if (!empty($voucher)) {
            if ($subtotal > $voucher->min_amount) {
                if ($orderCount < $voucher->quota || $voucher->quota == -1) {
                    if ($limitPerUserCount < $voucher->limit_per_user || $voucher->limit_per_user == -1) {
                        if ($voucher->type == 'payment_based') {
                            $data = [
                                'voucher_id'    => $voucher->id,
                                'voucher_code'  => $voucher->code,
                                'voucher_value' => $voucher->discount,
                                'voucher_unit'  => $voucher->unit,
                                'voucher_type'  => $voucher->type,
                                'voucher_bank'  => $voucher->bank,
                            ];
                            session()->put('voucher', $data);
                            session()->flash('voucher_status', 'Kode voucher berhasil digunakan!');

                            return \Response::json([
                                'status'  => true,
                                'message' => 'Voucher code has been appliead',
                            ]);
                        } else {
                            $data = [
                                'voucher_id'    => $voucher->id,
                                'voucher_code'  => $voucher->code,
                                'voucher_value' => $voucher->discount,
                                'voucher_unit'  => $voucher->unit,
                                'voucher_type'  => $voucher->type,
                            ];
                            session()->put('voucher', $data);
                            session()->flash('voucher_status', 'Kode voucher berhasil digunakan!');

                            return \Response::json([
                                'status'  => true,
                                'message' => 'Voucher code has been applied',
                            ]);
                        }
                    } else {
                        return \Response::json([
                            'status'  => false,
                            'message' => 'You already use this code before',
                        ]);
                    }
                } else {
                    return \Response::json([
                        'status'  => false,
                        'message' => 'Voucher code quota is over',
                    ]);
                }
            } else {
                return \Response::json([
                    'status'  => false,
                    'message' => 'Your transaction amount is below the minimum required',
                ]);
            }
        } else {
            return \Response::json([
                'status'  => false,
                'message' => 'Voucher code is not exist',
            ]);
        }
    }

    public function cancelVoucher(Request $request)
    {
        session()->forget('voucher');

        return \Response::json([
            'status'  => 'true',
        ]);
    }

    private function paymentProcess($type, $ip, $bank = null, $ovo = '')
    {
        $voucher = session()->get('voucher');
        if (request()->type == 'multi') {
            $cart = Cart::where('user_id', \Auth::id())->where('type', 'multi')->where('status', 'current')->get();
        } else {
            $cart = $this->getUserCart();
        }
        if (empty($cart)) {
            return redirect()->route('frontend.home');
        }

        // SAVE TO ORDER TABLE
        if (request()->type == 'multi') {
            switch ($type) {
                case $type == 'virtual_account':
                    $order        = $this->saveToMultiOrder('virtual_account', $bank);
                    break;
                case $type == 'cvs':
                    $order        = $this->saveToMultiOrder('cvs', $bank);
                    break;
                case $type == 'cc':
                    $order        = $this->saveToMultiOrder('cc', $bank);
                    break;
                case $type == 'ovo':
                    $order        = $this->saveToMultiOrder('ovo', $bank);
                    break;

                default:
                    $order        = $this->saveToMultiOrder('virtual_account', $bank);
                    break;
            }
        } else {
            $lastOrder = Order::where('cart_id', $cart->id)->first();
            switch ($type) {
                case $type == 'virtual_account':
                    if ($lastOrder) {
                        if ($lastOrder->payment_method == 'virtual_account') {
                            $order      = $lastOrder;
                        } else {
                            $lastOrder->payment_method  = 'virtual_account';
                            $lastOrder->bank            = $bank;
                            $lastOrder->save();
                            $lastOrder->refresh();

                            $order = $lastOrder;
                        }
                    } else {
                        $order  = $this->saveToOrder('virtual_account', $bank);
                    }
                    break;
                case $type == 'cvs':
                    if ($lastOrder) {
                        if ($lastOrder->payment_method == 'cvs') {
                            $order      = $lastOrder;
                        } else {
                            $lastOrder->payment_method  = 'cvs';
                            $lastOrder->bank            = $bank;
                            $lastOrder->save();
                            $lastOrder->refresh();

                            $order = $lastOrder;
                        }
                    } else {
                        $order        = $this->saveToOrder('cvs', $bank);
                    }
                    break;
                case $type == 'cc':
                    if ($lastOrder) {
                        if ($lastOrder->payment_method == 'cc') {
                            $order      = $lastOrder;
                        } else {
                            $lastOrder->payment_method = 'cc';
                            $lastOrder->save();
                            $lastOrder->refresh();

                            $order = $lastOrder;
                        }
                    } else {
                        $order      = $this->saveToOrder('cc', $bank);
                    }
                    break;
                case $type == 'ovo':
                    if ($lastOrder) {
                        if ($lastOrder->payment_method == 'ovo') {
                            $order      = $lastOrder;
                        } else {
                            $lastOrder->payment_method = 'ovo';
                            $lastOrder->save();
                            $lastOrder->refresh();

                            $order = $lastOrder;
                        }
                    } else {
                        $order      = $this->saveToOrder('ovo', $bank);
                    }
                    break;

                default:
                    $order        = $this->saveToOrder('virtual_account', $bank);
                    break;
            }
        }

        // UPDATE CART
        if (request()->type == 'multi') {
            foreach ($cart as $mycart) {
                $mycart->status = 'checkout';
                if ($voucher) {
                    $mycart->voucher_id   = $voucher['voucher_id'];
                }
                $mycart->save();
            }
        } else {
            if ($type !== 'cc') {
                if ($type !== 'ovo') {
                    $cart->status = 'checkout';
                }
            }
            if ($voucher) {
                $cart->voucher_id   = $voucher['voucher_id'];
            }
            $cart->save();
        }

        // REMOVE VOUCHER FROM SESSION
        session()->forget('voucher');

        if (request()->type == 'multi') {
            foreach ($cart as $mycart) {
                $this->reduceStock($mycart);
            }

            $orders     = Order::whereIn('id', $order)->get();
            $response   = $this->requestNicePayMulti($order, $bank, $ip);
            foreach ($orders as $order) {
                if ($type == 'cvs' || $type == 'virtual_account') {
                    $order->refresh();
                    event(new Pending($order));
                }
            }
        } else {
            // REDUCE PRODUCT STOCK
            $this->reduceStock($cart);

            // PAYMENT PROCESS

            //$response                = $this->requestNicePay($order, $bank, $ip, $ovo);

            if ($type == 'cvs' || $type == 'virtual_account') {
                $order->refresh();
                event(new Pending($order));
            }
        }

        // if ($type == 'cstore') {
        //     $response                = $this->requestMidtransCs($order, $request->csname);
        // }

        return $order;
    }

    private function saveToOrder($method, $bank, $quickbuy = false)
    {
        $cart                         = $this->getUserCart();
        $cart->status                 = 'checkout';
        $cart->save();
        $voucher                      = session()->get('voucher');

        $next                         = Order::whereRaw('DATE(created_at) = DATE(NOW())')->count() + 1;

        $order                        = new Order;
        $order->order_code            = $this->generateOrderCode($next);
        $order->user_id               = \Auth::id();
        $order->cart_id               = $cart->id;
        $order->status                = $method == 'reward_point' ? 'paid' : 'pending';
        $order->payment_method        = $method;
        $order->bank                  = $bank;

        if ($method == 'reward_point') {
            $order->payment_date   = Carbon::now();
            $order->payment_status = 1;
        }
        // $order->payment_date          = ;
        $order->payment_status        = $method == 'reward_point' ? 1 : 0;
        $order->subtotal              = $cart->total_price;
        $order->total_weight          = $cart->total_weight;
        $order->total_shipping_cost   = $cart->courier_cost;
        $order->insurance             = $cart->insurance;

        $usePoints                    = 0;
        if (session()->has('rewards')) {
            $usePoints = \Auth::user()->creditBalance();
        }

        $grandTotal = $cart->total_price + $cart->courier_cost + $cart->insurance;
        if ($voucher) {
            if ($voucher['voucher_unit'] == 'amount' || $voucher['voucher_unit'] == 'Amount') {
                if ($voucher['voucher_type'] == 'shipping') {
                    // SHIPPING VOUCHER
                    if ($cart->courier_cost > $voucher['voucher_value']) {
                        // JIKA KURIR LEBIH BESAR DARI NILAI VOUCHER
                        $discountVal =  $voucher['voucher_value'];
                    } else {
                        // JIKA KURIR LEBIH kecil DARI NILAI VOUCHER
                        $discountVal =  $cart->courier_cost;
                    }
                } else {
                    // TOTAL VOUCHER
                    $discountVal = $voucher['voucher_value'];
                }
            } else {
                if ($voucher['voucher_type'] == 'shipping') {
                    $voucherVal  = $cart->courier_cost * $voucher['voucher_value'] / 100;
                    $discountVal = $voucherVal;
                } else {
                    $voucherVal  = $cart->total_price * $voucher['voucher_value'] / 100;
                    $discountVal = $voucherVal;
                }
            }
            $grandTotal = $grandTotal - $discountVal;
        }

        $order->points_used           = $usePoints;
        $order->grand_total           = $grandTotal - $usePoints;
        $order->notes                 = $cart->note;
        if ($voucher) {
            $order->voucher_id            = $voucher['voucher_id'];
            $order->voucher_code          = $voucher['voucher_code'];
            $order->voucher_value         = $discountVal;
            $order->voucher_unit          = $voucher['voucher_unit'];
            $order->voucher_type          = $voucher['voucher_type'];
        }
        $order->save();

        foreach ($cart->details as $item) {
            $detail                 = new OrderDetail;
            $detail->order_id       = $order->id;
            $detail->product_id     = $item->product_id;
            $detail->quantity       = $item->qty;
            $detail->price          = $item->product_price;
            $detail->loketcom_token = $item->loketcom_token;
            $detail->token_expired  = $item->token_expired;
            $detail->order_result   = $item->order_result;
            $detail->save();
        }
		
		$user = DB::table('users')->where('id', $order->user_id)->first();
		//dd($user);
		
		require_once dirname(__FILE__) . '/midtrans/midtrans-php/Midtrans.php'; 
		// Set your Merchant Server Key
              \Midtrans\Config::$serverKey = 'Mid-server-smsTIr4vHsCziMDKurq7p4Qp'; #Production ServerKey
            // \Midtrans\Config::$serverKey = 'SB-Mid-server-XdJony36hI9wqrhYXHO0OxFO'; #Sandbox ServerKey

        	// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
                \Midtrans\Config::$isProduction = true;
             //	\Midtrans\Config::$isProduction = false;
        	// Set sanitization on (default)
        	\Midtrans\Config::$isSanitized = true;
        	// Set 3DS transaction for credit card to true
        	\Midtrans\Config::$is3ds = true;

        $params = array(
			'transaction_details' => array(
				'order_id' => "TA-".$order->id,
				'gross_amount' => $order->grand_total,
			),
			'customer_details' => array(
				'first_name' => $user->name,
				'last_name' => '',
				'email' => $user->email,
				'phone' => $user->phone,
			),
		);

        $snapToken = \Midtrans\Snap::getSnapToken($params);
		
        
		$update['payment_token'] = $snapToken;
		Order::where('id', $order->id)->update($update);

        return $order;
    }

    private function saveToMultiOrder($method, $bank, $quickbuy = false)
    {
        $carts = Cart::where('user_id', \Auth::id())->where('type', 'multi')->where('status', 'current')->get();

        $voucher                      = session()->get('voucher');

        $getOrder = [];

        foreach ($carts as $i => $cart) {
            $next                         = Order::whereRaw('DATE(created_at) = DATE(NOW())')->count() + 1;

            $order                        = new Order;
            $order->order_code            = $this->generateOrderCode($next);
            $order->user_id               = \Auth::id();
            $order->cart_id               = $cart->id;
            $order->status                = 'pending';
            $order->payment_method        = $method;
            $order->bank                  = $bank;
            // $order->payment_date          = ;
            $order->payment_status        = 0;
            $order->subtotal              = $cart->total_price;
            $order->total_weight          = $cart->total_weight;
            $order->total_shipping_cost   = $cart->courier_cost;
            $order->insurance             = $cart->insurance;
            $grandTotal                   = $cart->total_price + $cart->courier_cost + $cart->insurance;
            if ($voucher) {
                if ($i == 0) {
                    $total_courier      = $carts->sum('courier_cost');
                    $total_price        = $carts->sum('total_price');

                    if ($voucher['voucher_unit'] == 'amount' || $voucher['voucher_unit'] == 'Amount') {
                        if ($voucher['voucher_type'] == 'shipping') {
                            // SHIPPING VOUCHER
                            if ($total_courier > $voucher['voucher_value']) {
                                // JIKA KURIR LEBIH BESAR DARI NILAI VOUCHER
                                $discountVal =  $voucher['voucher_value'];
                            } else {
                                // JIKA KURIR LEBIH kecil DARI NILAI VOUCHER
                                $discountVal =  $total_courier;
                            }
                        } else {
                            // TOTAL VOUCHER
                            $discountVal = $voucher['voucher_value'];
                        }
                    } else {
                        if ($voucher['voucher_type'] == 'shipping') {
                            $voucherVal  = $total_courier * $voucher['voucher_value'] / 100;
                            $discountVal = $voucherVal;
                        } else {
                            $voucherVal  = $total_price * $voucher['voucher_value'] / 100;
                            $discountVal = $voucherVal;
                        }
                    }
                    $grandTotal = $grandTotal - $discountVal;
                } else {
                    $grandTotal = $grandTotal;
                }
            }
            $order->grand_total           = $grandTotal;
            $order->notes                 = $cart->note;
            $order->multi                 = 1;
            if ($voucher) {
                if ($i == 0) {
                    $order->voucher_id            = $voucher['voucher_id'];
                    $order->voucher_code          = $voucher['voucher_code'];
                    $order->voucher_value         = $discountVal;
                    $order->voucher_unit          = $voucher['voucher_unit'];
                    $order->voucher_type          = $voucher['voucher_type'];
                }
            }
            $order->save();

            foreach ($cart->details as $item) {
                $detail                 = new OrderDetail;
                $detail->order_id       = $order->id;
                $detail->product_id     = $item->product_id;
                $detail->quantity       = $item->qty;
                $detail->price          = $item->product_price;
                $detail->loketcom_token = $item->loketcom_token;
                $detail->token_expired  = $item->token_expired;
                $detail->order_result   = $item->order_result;
                $detail->save();
            }

            array_push($getOrder, $order->id);
        }

        return $getOrder;
    }

    private function requestNicePay($order, $bankName, $ip, $ovo = '')
    {
        $vt                  = new NicepayLib;

        $cartData = [
            'count' => 0,
            'item'  => [],
        ];

        foreach ($order->details as $index => $detail) {
            $cartData['count'] += 1;
            $cartData['item'][] = [
                'img_url'      => $detail->product->cover->url,
                'goods_name'   => $detail->product->full_name,
                'goods_detail' => '',
                'goods_amt'    => $detail->quantity * $detail->price,
            ];
        }
        $cartCount = count($cartData['item']);
        if ($order->total_shipping_cost) {
            $cartData['item'][$cartCount] = [
                'img_url'      => asset('assets/img/delivery.png'),
                'goods_name'   => 'Biaya Pengiriman',
                'goods_detail' => '',
                'goods_amt'    => $order->total_shipping_cost,
            ];
        }
        if ($order->insurance) {
            $cartData['item'][$cartCount + 1] = [
                'img_url'      => asset('assets/img/insurance.png'),
                'goods_name'   => 'Biaya Asuransi Pengiriman',
                'goods_detail' => '',
                'goods_amt'    => $order->insurance,
            ];
        }

        $method = $order->payment_method;
        switch ($method) {
            case $method == 'virtual_account':
                $vt->registrationVa(json_encode($cartData), $order, '02', $ip, $bankName);
                break;
            case $method == 'cvs':
                $vt->registrationCvs(json_encode($cartData), $order, '03', $ip, $bankName);
                break;
            case $method == 'cc':
                $vt->registrationCC(json_encode($cartData), $order, '01', $ip, $bankName);
                break;
            case $method == 'ovo':
                $vt->registrationEw(json_encode($cartData), $order, '01', $ip, $bankName, $ovo);
                break;

            default:
                // code...
                break;
        }

        return;
    }

    private function requestNicePayMulti($orderID, $bankName, $ip)
    {
        $orders = Order::whereIn('id', $orderID)->get();
        $vt     = new NicepayLib;

        $cartData = [
            'count' => 0,
            'item'  => [],
        ];

        $shippingCost   = 0;
        $insuranceCost  = 0;

        foreach ($orders as $order) {
            foreach ($order->details as $index => $detail) {
                $cartData['count'] += 1;
                $cartData['item'][] = [
                    'img_url'      => $detail->product->cover->url,
                    'goods_name'   => $detail->product->full_name,
                    'goods_detail' => '',
                    'goods_amt'    => $detail->quantity * $detail->price,
                ];
            }
            $shippingCost += $order->total_shipping_cost;
            $shippingCost += $order->insurance;

            $method = $order->payment_method;
        }
        $cartCount = count($cartData['item']);

        $cartData['item'][$cartCount] = [
            'img_url'      => asset('assets/img/delivery.png'),
            'goods_name'   => 'Biaya Pengiriman',
            'goods_detail' => '',
            'goods_amt'    => $shippingCost,
        ];

        // $cartData['item'][$cartCount + 1] = [
        //     'img_url' => asset('assets/img/insurance.png'),
        //     'goods_name' => 'Biaya Asuransi Pengiriman',
        //     'goods_detail' => '',
        //     'goods_amt' => $insuranceCost,
        // ];
        $multi = 1;
        switch ($method) {
            case $method == 'virtual_account':
                $vt->registrationMultiVa(json_encode($cartData), $orderID, '02', $ip, $bankName, $multi);
                break;
            case $method == 'cvs':
                $vt->registrationMultiCvs(json_encode($cartData), $orderID, '03', $ip, $bankName, $multi);
                break;
            case $method == 'cc':
                $vt->registrationMultiCC(json_encode($cartData), $orderID, '01', $ip, $bankName, $multi);
                break;

            default:
                // code...
                break;
        }

        return;
    }

    private function getUserCart()
    {
        $cart   = Cart::with('details', 'details.product', 'details.product.cover', 'details.product.brand')->where('status', 'current')->where('type', 'cart')->where('user_id', \Auth::id())->first();

        return $cart;
    }

    private function reduceStock($cart)
    {
        foreach ($cart->details as $item) {
            $currentStock   = $item->product->stock;
            $qty            = $item->qty;
            $calc           = $currentStock - $qty;

            $product        = Product::find($item->product_id);
            $product->stock = $calc;
            $product->save();
        }

        return true;
    }

    protected function setSoldProduct($order)
    {
        foreach ($order->details as $detail) {
            $detail->product->sold += $detail->quantity;
            $detail->product->save();
        }

        return;
    }

    private function generateOrderCode($next)
    {
        $temp   = date('ymd') . str_pad($next . str_random(3), 7, '0000000', STR_PAD_LEFT);
        $exists = Order::where('order_code', $temp)->count();

        while ($exists) {
            $next++;
            $temp   = date('ymd') . str_pad($next . str_random(3), 7, '0000000', STR_PAD_LEFT);
            $exists = Order::where('order_code', $temp)->count();
        }

        return strtoupper('TKA' . $temp);
    }

    public function gopay(Request $request)
    {
        $this->validate($request, [
            'result_data'   => 'required',
            'result_type'   => 'required'
        ]);

        $voucher                      = session()->get('voucher');
        if ($request->multi) {
            $carts               = Cart::where('user_id', \Auth::id())->where('type', 'multi')->where('status', 'current')->get();
        } else {
            $cart               = Cart::where('user_id', \Auth::id())->where('type', 'cart')->orderBy('created_at', 'desc')->first();
        }

        if ($request->result_type == 'success') {
            if ($request->multi) {
                foreach ($carts as $cart) {
                    if ($voucher) {
                        $cart->voucher_id   = $voucher['voucher_id'];
                    }
                    $cart->save();

                    session()->forget('voucher');

                    $this->reduceStock($cart);

                    $order                  = Order::with('details')->where('cart_id', $cart->id)->first();
                    $order->setPaid();

                    insertRhapsodieOrderLog($order, 'paid', 'snap');

                    $resultJson             = json_decode($request->result_data);
                    $order->payment_date    = $resultJson->transaction_time;
                    $order->midtrans        = $request->result_data;
                    $order->payment_status  = 1;
                    $order->save();

                    $this->setSoldProduct($order);
                }
            } else {
                if ($voucher) {
                    $cart->voucher_id   = $voucher['voucher_id'];
                }
                $cart->save();

                session()->forget('voucher');

                $this->reduceStock($cart);

                $order                  = Order::with('details')->where('cart_id', $cart->id)->first();
                $order->setPaid();

                insertRhapsodieOrderLog($order, 'paid', 'snap');

                $resultJson             = json_decode($request->result_data);
                $order->payment_date    = $resultJson->transaction_time;
                $order->midtrans        = $request->result_data;
                $order->payment_status  = 1;
                $order->save();

                $this->setSoldProduct($order);
            }

            // IF USING SOME OF REWARDS POINT
            if (session()->has('rewards')) {
                $userRewardExpense              = new UserReward;
                $userRewardExpense->user_id     = \Auth::id();
                $userRewardExpense->order_id    = $order->id;
                $userRewardExpense->points      = \Auth::user()->creditBalance();
                $userRewardExpense->type        = 'out';
                $userRewardExpense->save();

                session()->forget('rewards');
            }

            return redirect()->route('frontend.order.detail', $order->order_code);
        } else {
            if ($request->multi) {
                foreach ($carts as $cart) {
                    $order                  = Order::where('cart_id', $cart->id)->first();

                    // if snap window close
                    $order->status          = 'pending';
                    $order->midtrans        = $request->result_data;
                    $order->save();

                    // UPDATE CART
                    $cart->status = 'checkout';
                    if ($voucher) {
                        $cart->voucher_id   = $voucher['voucher_id'];
                    }
                    $cart->save();

                    // REDUCE PRODUCT STOCK
                    $this->reduceStock($cart);

                    // REMOVE VOUCHER FROM SESSION
                    session()->forget('voucher');
                }
            } else {
                $order                  = Order::where('cart_id', $cart->id)->first();

                // if snap window close
                $order->status          = 'pending';
                $order->midtrans        = $request->result_data;
                $order->save();

                // UPDATE CART
                $cart->status = 'checkout';
                if ($voucher) {
                    $cart->voucher_id   = $voucher['voucher_id'];
                }
                $cart->save();

                // REDUCE PRODUCT STOCK
                $this->reduceStock($cart);

                // REMOVE VOUCHER FROM SESSION
                session()->forget('voucher');
            }

            // IF USING SOME OF REWARDS POINT
            if (session()->has('rewards')) {
                $userRewardExpense              = new UserReward;
                $userRewardExpense->user_id     = \Auth::id();
                $userRewardExpense->order_id    = $order->id;
                $userRewardExpense->points      = \Auth::user()->creditBalance();
                $userRewardExpense->type        = 'out';
                $userRewardExpense->save();

                session()->forget('rewards');
            }

            return redirect()->route('frontend.order.detail', $order->order_code);
        }
    }

    public function midtransToken(Request $request)
    {
        $method         = $request->method;
        if ($request->type == 'multi') {
            $cart    = Cart::where('user_id', \Auth::id())->where('type', 'multi')->where('status', 'current')->get();
            $orders  = $this->saveToMultiOrder($method, 'gopay');
        } else {
            $cart       = $this->getUserCart();
            $checkOrder = Order::where('cart_id', $cart->id)->delete();

            // if ($checkOrder) {
            //     $order = $checkOrder;
            // } else {
            $order  = $this->saveToOrder($method, $bank);
            // }
            $cart->save();
        }
        $bank           = null;

        if (!$cart) {
            return response()->json(['status' => true]);
        }

        $midtrans            = new Midtrans;

        if ($request->type == 'multi') {
            $itemCount = 0;

            // $transaction_details = [
            //     'gross_amount'      => $order->grand_total,
            //     'order_id'          => $order->order_code
            // ];

            $curOrders      = Order::whereIn('id', $orders)->get();
            $referenceNo    = date('ymdHis');

            foreach ($curOrders as $i => $order) {
                foreach ($order->details as $index => $detail) {
                    $items[$itemCount]['id']                = $detail->id;
                    $items[$itemCount]['price']             = $detail->price;
                    $items[$itemCount]['quantity']          = $detail->quantity;
                    $items[$itemCount]['name']              = strlen($detail->product->name) > 45 ? substr($detail->product->name, 0, 45) . '...' : $detail->product->name;
                    $itemCount++;
                }

                $order->multi_code = $referenceNo;
                $order->save();

                if ($order->total_shipping_cost) {
                    $totalCourier += $order->total_shipping_cost;
                }

                if ($order->voucher_id) {
                    $totalDiscount += $order->voucher_value;
                }

                if ($order->insurance) {
                    $totalInsurance += $order->insurance;
                }

                if ($order->grand_total) {
                    $totalGrandTotal += $order->grand_total;
                }
            }

            $items[$itemCount]['id']       = 'SHIPPINGFEE';
            $items[$itemCount]['price']    = $totalCourier;
            $items[$itemCount]['quantity'] = 1;
            $items[$itemCount]['name']     = 'Ongkos Kirim';

            if ($totalDiscount) {
                $items[$itemCount + 1]['id']       = 'VOUCHER';
                $items[$itemCount + 1]['price']    = 0 - $totalDiscount;
                $items[$itemCount + 1]['quantity'] = 1;
                $items[$itemCount + 1]['name']     = 'Voucher Discount';

                if ($totalInsurance) {
                    $items[$itemCount + 2]['id']       = 'SHIPPINGINSURANCE';
                    $items[$itemCount + 2]['price']    = $totalInsurance;
                    $items[$itemCount + 2]['quantity'] = 1;
                    $items[$itemCount + 2]['name']     = 'Shipping Insurance';
                }
            } else {
                if ($totalInsurance) {
                    $items[$itemCount + 1]['id']       = 'SHIPPINGINSURANCE';
                    $items[$itemCount + 1]['price']    = $totalInsurance;
                    $items[$itemCount + 1]['quantity'] = 1;
                    $items[$itemCount + 1]['name']     = 'Shipping Insurance';
                }
            }

            $transaction_details = [
                'gross_amount'      => $totalGrandTotal,
                'order_id'          => $referenceNo
            ];
        } else {
            // NORMAL CHECKOUT
            $transaction_details = [
                'gross_amount'      => $order->grand_total,
                'order_id'          => $order->order_code
            ];

            foreach ($order->details as $index => $detail) {
                $items[$index]['id']                = $detail->id;
                $items[$index]['price']             = $detail->price;
                $items[$index]['quantity']          = $detail->quantity;
                $items[$index]['name']              = strlen($detail->product->name) > 45 ? substr($detail->product->name, 0, 45) . '...' : $detail->product->name;
            }

            $myCount    = 0;
            if ($order->total_shipping_cost) {
                $items[$order->details->count() + $myCount]['id']       = 'SHIPPINGFEE';
                $items[$order->details->count() + $myCount]['price']    = $order->total_shipping_cost;
                $items[$order->details->count() + $myCount]['quantity'] = 1;
                $items[$order->details->count() + $myCount]['name']     = 'Ongkos Kirim';
                $myCount += 1;
            }

            $voucher    = session()->get('voucher');

            if ($voucher) {
                $items[$order->details->count() + $myCount]['id']       = 'VOUCHER';
                $items[$order->details->count() + $myCount]['price']    = 0 - $order->voucher_value;
                $items[$order->details->count() + $myCount]['quantity'] = 1;
                $items[$order->details->count() + $myCount]['name']     = 'Voucher Discount';
                $myCount += 1;
            }

            if ($order->insurance) {
                $items[$order->details->count() + $myCount]['id']       = 'SHIPPINGINSURANCE';
                $items[$order->details->count() + $myCount]['price']    = $order->insurance;
                $items[$order->details->count() + $myCount]['quantity'] = 1;
                $items[$order->details->count() + $myCount]['name']     = 'Shipping Insurance';
                $myCount += 1;
            }

            if (session()->has('rewards')) {
                $items[$order->details->count() + $myCount]['id']       = 'TALASIREWARDSPOINTUSED';
                $items[$order->details->count() + $myCount]['price']    =  0 - \Auth::user()->creditBalance();
                $items[$order->details->count() + $myCount]['quantity'] = 1;
                $items[$order->details->count() + $myCount]['name']     = 'Talasi Reward Points';
                $myCount += 1;
            }

            // Populate customer's billing address
            $billing_address['first_name']         = \Auth::user()->name;
            $billing_address['last_name']          = '';
            $billing_address['address']            = $order->cart->address->address;
            $billing_address['city']               = $order->cart->address->city;
            $billing_address['postal_code']        = $order->cart->address->postal_code;
            $billing_address['phone']              = $order->cart->address->phone_number;
            $billing_address['country_code']       = 'IDN';

            $shipping_address['first_name']        = \Auth::user()->name;
            $shipping_address['last_name']         = '';
            $shipping_address['address']           = $order->cart->address->address;
            $shipping_address['city']              = $order->cart->address->city;
            $shipping_address['postal_code']       = $order->cart->address->postal_code;
            $shipping_address['phone']             = $order->cart->address->phone_number;
            $shipping_address['country_code']      = 'IDN';
        }

        $credit_card['secure'] = true;

        $time          = time();

        $custom_expiry = [
            'start_time' => date('Y-m-d H:i:s O', $time),
            'unit'       => 'minutes',
            'duration'   => 15
        ];

        // Populate customer's Info
        $customer_details = [
            'first_name'                => \Auth::user()->name,
            'last_name'                 => '',
            'email'                     => \Auth::user()->email,
            'phone'                     => \Auth::user()->phone,
            'billing_address'           => $billing_address,
            'shipping_address'          => $shipping_address
        ];

        $transaction_data = [
            'transaction_details' => $transaction_details,
            'item_details'        => $items,
            'customer_details'    => $customer_details,
            'credit_card'         => $credit_card,
            'expiry'              => $custom_expiry,
            'enabled_payments'    => [$method]
        ];

        try {
            $snap_token = $midtrans->getSnapToken($transaction_data);
            //return redirect($vtweb_url);
            echo $snap_token;
        } catch (Exception $e) {
            return $e->getMessage;
        }
    }

    public function useReward(Request $request)
    {
        $balance = \Auth::user()->creditBalance();

        if ($balance) {
            if ($request->status == 1) {
                if ($balance > 0) {
                    $data = [
                        'use'    => 1,
                    ];
                    session()->put('rewards', $data);

                    return response()->json(['status', true]);
                }
            }
        }

        session()->forget('rewards');

        return response()->json(['status', false]);
    }
}
