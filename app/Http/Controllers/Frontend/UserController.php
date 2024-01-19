<?php

namespace App\Http\Controllers\Frontend;

use App\Cart;
use App\CartDetail;
use App\Category;
use App\Content;
use App\Cuopon;
use App\Events\Coupon;
use App\Mail\ReferalMail;
use App\Order;
use App\OrderDetail;
use App\Post;
use App\Product;
use App\ProductReview;
use App\ProductReviewImage;
use App\Reward;
use App\User;
use App\UserAddress;
use App\UserCoupon;
use App\UserReferral;
use App\UserReward;
use App\UserRewardNotification;
use App\UserServiceProvider;
use App\UserServiceProviderProject;
use App\UserServiceProviderProjectImage;
use App\UserServiceProviderQuotation;
use App\Veritrans\Veritrans;
use App\Voucher;
use App\Wishlist;
use Carbon\Carbon;
use Cookie;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Image;
use Mail;
use Storage;
use Validator;

class UserController extends CoreController
{
    public function __construct()
    {
        parent::__construct();
        Veritrans::$serverKey    = env('MIDTRANS_SERVER_KEY');
        Veritrans::$isProduction = env('MIDTRANS_PRODUCTION');
        $this->middleware('auth');
    }

    public function profile()
    {
        $user               = \Auth::user();
        $this->data['user'] = $user;

        $summary     = Order::with('user')->where('user_id', \Auth::id())
            ->select(DB::raw('sum(grand_total) as total_order'))
            ->where('status', 'completed')->first();

        if (!is_null($summary->total_order)) {
            $level               = Reward::where('buy_from', '<', $summary->total_order)->where('buy_to', '>', $summary->total_order)->first();
            $this->data['level'] = $level;
            $this->data['total'] = $summary->total_order;
        }

        return $this->renderView('frontend.pages.account.profile');
    }

    public function uploadAvatar(Request $request)
    {
        $user = \Auth::user();

        $file       = $request->formData;
        $allowedExt = ['jpg', 'jpeg', 'png'];

        $name = $file->getClientOriginalName();
        $ext  = strtolower($file->getClientOriginalExtension());
        $size = $file->getSize();

        if (!in_array($ext, $allowedExt)) {
            return response()->json(['status' => false, 'message' => 'File extension not allowed.']);
        }
        if ($size > 1000000) {
            return response()->json(['status' => false, 'message' => 'Image are too big']);
        }

        if (Storage::exists($user->getOriginal('avatar'))) {
            Storage::delete($user->getOriginal('avatar'));
        }

        $name           = str_slug($user->name) . '_avatar_' . str_random(20) . '.' . $ext;
        $path           = 'uploads/' . date('Y-m');
        $user->avatar   = $path . '/' . $name;
        $user->save();

        Storage::makeDirectory($path);
        if (Storage::putFileAs($path, $file, $name)) {
            $displayImg = Image::make(storage_path('app/' . $path . '/' . $name))->fit(400, 400)->save(storage_path('app/' . $path . '/' . $name));
        }

        return response()->json(['status' => true]);
    }

    public function editProfile()
    {
        return $this->renderView('frontend.pages.account.edit_profile');
    }

    public function saveProfile(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'          => 'required',
                'email'         => 'required',
                'phone'         => 'required',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $user          = \Auth::user();
            $user->name    = $request->name;
            $user->email   = $request->email;
            $user->phone   = $request->phone;
            $user->save();

            return redirect()->route('frontend.user.profile')->with('success', 'Profile Successfully Updated');
        }
    }

    public function setSubscribe(Request $request)
    {
        $user               = \Auth::user();
        $user->is_subscribe = $request->subscribe;
        $user->save();

        return response()->json(['status' => true]);
    }

    public function editPassword()
    {
        return $this->renderView('frontend.pages.users.change_password');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'old_password'      => 'required',
                'password'          => 'required|string|min:8|confirmed',
            ],
            [
                'old_password.required'     => 'Password lama mohon di isi',
                'password.required'         => 'Password baru mohon di isi',
                'password.min'              => 'Password terlalu pendek, minimal 8 huruf',
                'password.confirmed'        => 'Password tidak cocok'
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors()->all();

            return back()->withErrors($validator);
        } else {
            if (!(Hash::check($request->old_password, \Auth::user()->password))) {
                // The passwords matches
                return redirect()->back()->with('message', 'Password Lama Anda Tidak Benar. Mohon coba lagi');
            }

            if (strcmp($request->old_password, $request->password) == 0) {
                return redirect()->back()->with('message', 'Password Baru Tidak Boleh Sama Dengan Password Lama');
            }

            $user           = \Auth::user();
            $user->password = bcrypt($request->password);
            $user->save();

            return redirect()->route('frontend.user.profile')->with('success', 'Password Successfully Updated');
        }
    }

    public function transactions(Request $request)
    {
        $orders = Order::with('details', 'details.product', 'details.product.cover')->where('user_id', \Auth::id());

        $status = $request->status;
        $sort   = $request->sort;

        if ($status || $sort) {
            if ($status) {
                $orders = $orders->where('status', $status);
            }

            if ($sort) {
                if ($sort == 1) {
                    $orders = $orders->orderBy('created_at', 'asc');
                }
                if ($sort == 2) {
                    $orders = $orders->orderBy('created_at', 'desc');
                }
                if ($sort == 3) {
                    $orders = $orders->orderBy('grand_total', 'asc');
                }
                if ($sort == 4) {
                    $orders = $orders->orderBy('grand_total', 'desc');
                }
            }
        } else {
            $orders = $orders->orderBy('created_at', 'DESC');
        }

        $orders = $orders->get();

        $this->data['orders'] = $orders;

        return $this->renderView('frontend.pages.account.order');
    }

    public function transactionDetail($order_code)
    {
        $order = Order::with('cart', 'cart.address', 'details', 'details.product', 'details.product.cover', 'details.product.brand')->where('order_code', $order_code)->firstOrFail();

        if ($order->user_id !== \Auth::id()) {
            return redirect()->route('frontend.home');
        }

        if ($order->midtrans) {
            $midtrans               = json_decode($order->midtrans);
            $this->data['midtrans'] = $midtrans;
            if ($midtrans->payment_type == 'bank_transfer') {
                if ($midtrans->permata_va_number) {
                    $paymentInstruction = Post::where('type', 'permata')->get();
                }
                if ($midtrans->va_numbers) {
                    // BNI
                    if ($midtrans->va_numbers[0]->bank == 'bni') {
                        $paymentInstruction = Post::where('type', 'bni')->get();
                    } else {
                        // BCA
                        $paymentInstruction = Post::where('type', 'bca')->get();
                    }
                }
            }

            if ($midtrans->payment_type == 'echannel') {
                $paymentInstruction = Post::where('type', 'mandiri')->get();
                // dd($paymentInstruction);
            }

            if ($midtrans->payment_type == 'cstore') {
                $paymentInstruction = Post::where('type', $midtrans->store)->get();
            }

            $this->data['instructions']    = $paymentInstruction;
        }

        if ($order->no_resi) {
            $track               = json_decode($this->rajaongkirTrack($order->no_resi, explode('-', $order->cart->courier_type_id)[0]));
            if ($track->rajaongkir->status->code == 200) {
                $this->data['track'] = $track;
            }
        }

        $this->data['order'] = $order;
        if ($order->status == 'pending') {
            if ($order->payment_method == 'gopay') {
                if ($order->midtrans) {
                    $qrcode = 'https://api.midtrans.com/v2/gopay/' . $midtrans->transaction_id . '/qr-code';
                } else {
                    $requestMidtrans = $this->checkMidtrans($order->order_code);
                    $order->midtrans = $requestMidtrans;
                    $order->save();

                    $midtrans = json_decode($order->midtrans);
                    $qrcode   = 'https://api.midtrans.com/v2/gopay/' . $midtrans->transaction_id . '/qr-code';
                }
                $this->data['qrcode'] = $qrcode;
            }

            return $this->renderView('frontend.pages.users.order_history_detail_waiting_payment');
        } elseif ($order->status == 'failed') {
            return $this->renderView('frontend.pages.users.order_history_detail_canceled');
        } else {
            return $this->renderView('frontend.pages.users.order_history_detail');
        }
    }

    public function invoicePrint($order_code)
    {
        $order                   = Order::with('details', 'details.product', 'details.product.cover', 'details.product.brand')->where('order_code', $order_code)->firstOrFail();

        if ($order->user_id !== \Auth::id()) {
            return redirect()->route('frontend.home');
        }

        $this->data['order']     = $order;
        $this->data['midtrans']  = json_decode($order->midtrans);

        return $this->renderView('frontend.pages.users.invoice');
    }

    public function addressList()
    {
        $addresses = UserAddress::where('user_id', \Auth::id())->orderBy('is_default', 'DESC')->get();

        $this->data['addresses'] = $addresses;

        return $this->renderView('frontend.pages.account.address');
    }

    public function formAddress($edit = false)
    {
        if ($edit) {
            $address                             = UserAddress::where('user_id', \Auth::id())->where('id', $edit)->firstOrFail();
            $this->data['provinces']             = $this->getProvinceEdit($address->province_id);
            $this->data['cities']                = $this->getCityEdit($address->province_id, $address->city_id);
            $this->data['postal_code']           = $this->getPostalCodeEditAuto($address->province_id, $address->postal_code);
            $this->data['subdistricts']          = $this->getSubdistrictEdit($address->city_id, $address->subdistrict_id);
            $this->data['address']               = $address;
            $this->data['edit']                  = true;
        } else {
            $this->data['provinces']  = $this->getProvince();
        }

        return $this->renderView('frontend.pages.users.form_address');
    }

    public function saveFormAddress(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'label'         => 'required',
                'name'          => 'required',
                'province'      => 'required',
                'city'          => 'required',
                'subdistrict'   => 'required',
                'postal_code'   => 'required',
                'address'       => 'required',
                'phone_number'  => 'required'
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $getProvince    = explode('-', $request->province);
            $getCity        = explode('-', $request->city);
            $getSubdistrict = explode('-', $request->subdistrict);

            $getOtherAddress = UserAddress::where('user_id', \Auth::id())->where('is_default', 1)->first();
            if ($getOtherAddress) {
                $default = 0;
            } else {
                $default = 1;
            }

            if (isset($request->edit)) {
                $update      = UserAddress::where('user_id', \Auth::id())->where('id', $request->edit)->first();
                $userAddress = $update->update([
                    'user_id'           => \Auth::id(),
                    'label'             => $request->label,
                    'name'              => $request->name,
                    'province_id'       => $getProvince[0],
                    'province'          => $getProvince[1],
                    'city_id'           => $getCity[0],
                    'city'              => $getCity[1],
                    'subdistrict_id'    => $getSubdistrict[0],
                    'subdistrict'       => $getSubdistrict[1],
                    'postal_code'       => $request->postal_code,
                    'address'           => $request->address,
                    'phone_number'      => $request->phone_number,
                    'is_default'        => $default
                ]);
                $type = 'Updated';
            } else {
                $userAddress = UserAddress::create([
                    'user_id'           => \Auth::id(),
                    'label'             => $request->label,
                    'name'              => $request->name,
                    'province_id'       => $getProvince[0],
                    'province'          => $getProvince[1],
                    'city_id'           => $getCity[0],
                    'city'              => $getCity[1],
                    'subdistrict_id'    => $getSubdistrict[0],
                    'subdistrict'       => $getSubdistrict[1],
                    'postal_code'       => $request->postal_code,
                    'address'           => $request->address,
                    'phone_number'      => $request->phone_number,
                    'is_default'        => $default
                ]);
                $type = 'Added';
            }

            if (isset($request->edit)) {
                $userAddress = UserAddress::where('user_id', \Auth::id())->where('id', $request->edit)->first();
            }

            $addressCount   = \Auth::user()->addresses()->count();

            return redirect()->route('frontend.user.address')->with('success', 'Address Successfully ' . $type);
        }
    }

    public function setAsDefaultAddress(Request $request)
    {
        $address       = UserAddress::where('user_id', \Auth::id())->where('id', $request->id)->firstOrFail();
        $getAllAddress = UserAddress::where('user_id', \Auth::id())->get();
        if ($getAllAddress) {
            foreach ($getAllAddress as $dd) {
                $dd->update(['is_default' => 0]);
            }
        }
        $address->is_default = 1;
        $address->save();

        $request->session()->flash('success', 'Address has been set to default');

        return response()->json(['status' => true, 'message' => 'Address has been set to default']);
    }

    public function multiDeleteAddress(Request $request)
    {
        $input = array_flatten($request->address);

        foreach ($input as $key => $id) {
            $item = UserAddress::find($id);
            if ($item) {
                if ($item->user_id == \Auth::id()) {
                    $item->delete();
                } else {
                    return response()->json(['status' => false, 'message' => 'This Address is not yours']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'cant find address']);
            }
        }

        return response()->json(['status' => true, 'message' => 'Order telah dihapus']);
    }

    public function singleDeleteAddress(Request $request)
    {
        $item = UserAddress::find($request->id);
        if ($item) {
            if ($item->user_id == \Auth::id()) {
                $item->delete();

                return response()->json(['status' => true, 'message' => 'Alamat telah dihapus']);
            }
        }
    }

    public function saveAddress(Request $request)
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
            return response()->json(['status' => false, 'message' => $validator->messages()]);
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

            if (isset($request->edit)) {
                $update      = UserAddress::where('user_id', \Auth::id())->where('id', $request->edit)->first();
                $userAddress = $update->update([
                    'user_id'           => \Auth::id(),
                    'label'             => $request->label,
                    'name'              => $request->name,
                    'province_id'       => $update->city == $getCity[0] ? $update->province_id : $getProv[0],
                    'province'          => $update->city == $getCity[0] ? $update->province : $getProv[1],
                    'city_id'           => $update->city == $getCity[0] ? $update->city_id : $getCity[0],
                    'city'              => $update->city == $getCity[0] ? $update->city : $getCity[1],
                    // 'subdistrict_id'    => $getSubdistrict[0],
                    // 'subdistrict'       => $getSubdistrict[1],
                    'postal_code'       => $request->postal_code,
                    'address'           => $request->address,
                    'phone_number'      => $request->phone_number,
                    'lat'               => $request->lat,
                    'long'              => $request->long,
                    'is_default'        => $default
                ]);
            } else {
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
            }

            if (isset($request->edit)) {
                $userAddress = UserAddress::where('user_id', \Auth::id())->where('id', $request->edit)->first();
            }

            $cart                  = Cart::with('details')->where('type', 'cart')->where('status', 'current')->where('user_id', \Auth::id())->first();
            $cart->user_address_id = $userAddress->id;
            $cart->save();

            $addressCount   = \Auth::user()->addresses()->count();

            return response()->json(
                [
                    'status'        => true,
                    'address'       => $request->address,
                    'subdistrict'   => $getSubdistrict[1],
                    'city'          => $getCity[1],
                    'postal'        => $request->postal_code,
                    'province'      => $getProvince[1],
                    'address_id'    => $userAddress->id,
                    'address_count' => $addressCount,
                ]
            );
        }
    }

    public function saveAccAddress(Request $request)
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
            return response()->json(['status' => false, 'message' => $validator->messages()]);
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

            if (isset($request->edit)) {
                $update      = UserAddress::where('user_id', \Auth::id())->where('id', $request->edit)->first();
                $userAddress = $update->update([
                    'user_id'           => \Auth::id(),
                    'label'             => $request->label,
                    'name'              => $request->name,
                    'province_id'       => $update->city == $getCity[0] ? $update->province_id : $getProv[0],
                    'province'          => $update->city == $getCity[0] ? $update->province : $getProv[1],
                    'city_id'           => $update->city == $getCity[0] ? $update->city_id : $getCity[0],
                    'city'              => $update->city == $getCity[0] ? $update->city : $getCity[1],
                    // 'subdistrict_id'    => $getSubdistrict[0],
                    // 'subdistrict'       => $getSubdistrict[1],
                    'postal_code'       => $request->postal_code,
                    'address'           => $request->address,
                    'phone_number'      => $request->phone_number,
                    'lat'               => $request->lat,
                    'long'              => $request->long,
                    'is_default'        => $default
                ]);
            } else {
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
            }

            if (isset($request->edit)) {
                $userAddress = UserAddress::where('user_id', \Auth::id())->where('id', $request->edit)->first();
            }

            $addressCount   = \Auth::user()->addresses()->count();

            return response()->json(
                [
                    'status'        => true,
                    'address'       => $request->address,
                    'subdistrict'   => $getSubdistrict[1],
                    'city'          => $getCity[1],
                    'postal'        => $request->postal_code,
                    'province'      => $getProvince[1],
                    'address_id'    => $userAddress->id,
                    'address_count' => $addressCount,
                ]
            );
        }
    }

    public function updatePinpoint(Request $request)
    {
        $address = UserAddress::where('id', $request->id)->where('user_id', \Auth::id())->first();
        if ($address) {
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
    }

    public function wishlist(Request $request)
    {
        if ($request->search) {
            $search    = $request->search;
            $wishlists = Wishlist::with('product')->whereHas('product', function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%');
            })->get();
        } else {
            $wishlists = Wishlist::with('product', 'product.cover')->where('user_id', \Auth::id())->paginate(10);
        }

        $this->data['wishlists'] = $wishlists;

        return $this->renderView('frontend.pages.account.wishlist');
    }

    public function wishlistSearch(Request $request)
    {
        return redirect()->route('frontend.user.wishlist', ['search' => $request->search]);
    }

    public function setWishlist(Request $request)
    {
        $product = Product::find($request->id);
        // if ($product) {
        $duplicate = Wishlist::where('product_id', $request->id)->where('user_id', \Auth::id())->first();
        // find duplicates
        if ($duplicate) {
            $duplicate->delete();
            if ($request->reload) {
                $request->session()->flash('success', 'Product has been remove from your wishlist');

                return response()->json(['status' => true]);
            }

            return response()->json(['status' => true, 'message' => 'Product has been remove from your wishlist', 'wishlist' => 0]);
        } else {
            $wishlist             = new Wishlist;
            $wishlist->product_id = $product->id;
            $wishlist->user_id    = \Auth::id();
            $wishlist->save();

            return response()->json(['status' => true, 'message' => 'Product has been added to your wishlist', 'wishlist' => 1]);
        }
        // }

        return response()->json(['status' => false, 'message' => 'Product not found!']);
    }

    public function deleteWishlist(Request $request)
    {
        $input = array_flatten($request->wishlist);

        foreach ($input as $key => $id) {
            $item = Wishlist::find($id);
            if ($item) {
                if ($item->user_id == \Auth::id()) {
                    $item->delete();
                } else {
                    return response()->json(['status' => false, 'message' => 'This wishlist is not yours']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'cant find wishlist item']);
            }
        }
        $request->session()->flash('success', 'Product has been remove from your wishlist');

        return response()->json(['status' => true, 'message' => 'Wishlist telah dihapus']);
    }

    public function userNotification()
    {
        if (\Auth::check()) {
            $this->data['user']          = \Auth::user();
            $this->data['notifications'] = User::findOrFail(\Auth::id())->unreadNotifications()->orderBy('created_at', 'ASC')->get();
            // $notif                       = \Auth::user()->unreadNotifications->where('id', $request->notif_id)->markAsRead();
            return $this->renderView('frontend.pages.account.notifications');
        } else {
            return redirect()->route('frontend.home');
        }
    }

    public function marAsRead(Request $request)
    {
        if (\Auth::check()) {
            if (isset($request->notif_id)) {
                $notif = \Auth::user()->unreadNotifications->where('id', $request->notif_id)->markAsRead();
            }
        }

        return response()->json(['status' => false, 'message' => 'Not Allowed!']);
    }

    public function marAllAsRead(Request $request)
    {
        if (\Auth::check()) {
            User::findOrFail(\Auth::id())->unreadNotifications->markAsRead();
            $request->session()->flash('success', 'Notification has been cleared');

            return response()->json(['status' => true, 'message' => 'ok!']);
        }

        return response()->json(['status' => false, 'message' => 'Not Allowed!']);
    }

    public function getReview(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id'       => 'required',
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors()->all();

            $request->session()->flash('error', implode(', ', $message));

            return back()->withInput();
        } else {
            $decrypted              = Crypt::decryptString($request->id);
            $order                  = Order::find($decrypted);

            if ($order->user_id !== \Auth::id()) {
                return back()->with('error', 'Not your product to review.');
            }

            $details                = OrderDetail::with('product')->where('order_id', $order->id)->where('is_reviewed', 0)->get();

            $data                          = [];
            $data['details']               = $details;
            $content                       = view('frontend.pages.account.includes.part_modal_add_review', $data)->render();

            return response()->json([
                'status'     => true,
                'content'    => $content,
            ]);

            return back()->with('success', 'Rating has been send, Thank You.');
        }
    }

    public function saveReview(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'rating'       => 'required',
                'description'  => 'required',
            ],
            [
                'rating.required'            => 'Please give some star rating',
                'description.required'       => 'Description Cant Be Empty'
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors()->all();

            $request->session()->flash('error', implode(', ', $message));

            return back()->withInput();
        } else {
            $decrypted                = Crypt::decryptString($request->product);
            $detail                   = OrderDetail::find($decrypted);

            if ($detail) {
                if ($detail->order->user_id !== \Auth::id()) {
                    return response()->json(['success' => false, 'message' => 'Not your product to review.']);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Not your product to review.']);
            }

            $detail->is_reviewed      = 1;
            $detail->save();

            $review                   = new ProductReview;
            $review->product_id       = $detail->product_id;
            $review->order_id         = $detail->order_id;
            $review->order_detail_id  = $detail->id;
            $review->rating           = $request->rating;
            $review->description      = $request->description;
            $review->user_id          = \Auth::id();
            $review->save();

            if ($request->hasFile('file')) {
                foreach ($request->file as $image) {
                    $file       = $image;
                    $allowedExt = ['jpg', 'jpeg', 'png'];

                    $name               = $file->getClientOriginalName();
                    $ext                = strtolower($file->getClientOriginalExtension());
                    $size               = $file->getSize();

                    $name               = 'review_' . str_random(20) . '.' . $ext;
                    $path               = 'uploads/' . date('Y-m');

                    $reviewUrl    = $path . '/' . $name;

                    Storage::makeDirectory($path);
                    if (Storage::putFileAs($path, $file, $name)) {
                        $reviewImg = Image::make(storage_path('app/' . $path . '/' . $name))->save(storage_path('app/' . $path . '/' . $name));
                    }

                    $image                      = new ProductReviewImage;
                    $image->user_id             = \Auth::id();
                    $image->order_detail_id     = $detail->id;
                    $image->product_review_id   = $review->id;
                    $image->product_id          = $detail->product_id;
                    $image->url                 = $reviewUrl;
                    $image->save();
                }
            }

            session()->flash('success', 'Review has been submitted, Thank You');

            return response()->json(['success' => true, 'message' => 'Rating has been send, Thank You']);
        }
    }

    public function projectList()
    {
        $provider               = UserServiceProvider::where('user_id', \Auth::id())->first();
        if (!$provider || $provider->name == 'temp_name') {
            return redirect()->route('frontend.user.provider.edit.profile');
        }
        $projects               = UserServiceProviderProject::with('images', 'videos')->where('user_service_provider_id', $provider->id)->orderBy('created_at', 'DESC')->paginate(9);
        $this->data['projects'] = $projects;

        return $this->renderView('frontend.pages.users.includes.provider_project');
    }

    public function projectDetail($id)
    {
        $project                  = UserServiceProviderProject::with('images', 'videos')->find($id);
        $this->data['project']    = $project;

        return $this->renderView('frontend.pages.users.includes.ajax_project_detail');
    }

    public function providerEditProfile()
    {
        $provider = UserServiceProvider::where('user_id', \Auth::id())->first();
        if ($provider) {
            $this->data['provider'] = $provider;
        } else {
            $newProvider              = new UserServiceProvider;
            $newProvider->user_id     = \Auth::id();
            $newProvider->category_id = 0;
            $newProvider->name        = 'temp_name';
            $newProvider->save();

            $this->data['provider']   = $newProvider;
        }

        $categories               = Category::where('type', 'service_provider_type')->orderBy('title', 'ASC')->get();
        $this->data['categories'] = $categories;

        if ($provider->province) {
            $provid                              = explode('-', $provider->province);
            $this->data['provinces']             = $this->getProvinceEdit($provid[0]);
        } else {
            $this->data['provinces']  = $this->getProvince();
        }
        if ($provider->city) {
            $cityid               = explode('-', $provider->city);
            $this->data['cities'] = $this->getCityEdit($provid[0], $cityid[0]);
        }

        // dd($provider);
        $this->data['postal_code']           = $this->getPostalCodeEditAuto($address->province_id, $address->postal_code);

        return $this->renderView('frontend.pages.users.includes.provider_edit_profile');
    }

    public function providerSaveProfile(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'category_id'         => 'required',
                'name'                => 'required',
                'email'               => 'email',
                'short_description'   => 'required',
                'description'         => 'required',
                'information'         => 'required',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $slug                   = str_slug($request->name);
            $checkSlug              = UserServiceProvider::where('slug', $slug)->get()->count();
            if ($checkSlug > 1) {
                $slug = $slug . '-' . str_random(5);
            }

            $provider                     = UserServiceProvider::where('user_id', \Auth::id())->firstOrFail();
            $provider->category_id        = $request->category_id;
            $provider->name               = $request->name;
            $provider->email              = $request->email;
            $provider->phone              = $request->phone;
            $provider->website            = $request->website;
            $provider->instagram          = $request->instagram;
            $provider->facebook           = $request->facebook;
            $provider->twitter            = $request->twitter;
            $provider->address            = $request->address;
            $provider->city               = $request->city;
            $provider->postal_code        = $request->postal_code;
            $provider->province           = $request->province;
            $provider->description        = $request->description;
            $provider->short_description  = $request->short_description;
            $provider->information        = $request->information;
            $provider->slug               = $slug;
            $provider->services           = $request->services;
            $provider->save();

            return redirect()->route('frontend.user.provider.edit.profile')->with('success', 'Profile Successfully Updated');
        }
    }

    public function providerSaveProfileImage(Request $request)
    {
        $provider = UserServiceProvider::where('user_id', \Auth::id())->first();

        $file       = $request->file('file');
        $allowedExt = ['jpg', 'jpeg', 'png'];

        $name = $file->getClientOriginalName();
        $ext  = strtolower($file->getClientOriginalExtension());
        $size = $file->getSize();

        if (!in_array($ext, $allowedExt)) {
            return response()->json(['status' => false, 'message' => 'File extension not allowed.']);
        }
        if ($size > 1000000) {
            return response()->json(['status' => false, 'message' => 'Image are too big']);
        }

        if ($request->type == 'cover') {
            if ($provider->cover) {
                if (Storage::exists($provider->cover)) {
                    Storage::delete($provider->cover);
                }
            }
        } else {
            if ($provider->logo) {
                if (Storage::exists($provider->logo)) {
                    Storage::delete($provider->logo);
                }
            }
        }

        $name           = $request->type . '_' . str_random(20) . '.' . $ext;
        $path           = 'uploads/' . date('Y-m');

        Storage::makeDirectory($path);

        if (Storage::putFileAs($path, $file, $name)) {
            if ($request->type == 'cover') {
                $displayImg = Image::make(storage_path('app/' . $path . '/' . $name))->save(storage_path('app/' . $path . '/' . $name));
            } else {
                $displayImg = Image::make(storage_path('app/' . $path . '/' . $name))->fit(400, 400)->save(storage_path('app/' . $path . '/' . $name));
            }
        }

        if ($request->type == 'cover') {
            $provider->cover = $path . '/' . $name;
        } else {
            $provider->logo = $path . '/' . $name;
        }

        $provider->save();

        return response()->json(['status' => true]);
    }

    public function uploadProject(Request $request)
    {
        if (!isset($request->edit)) {
            if (!$request->unique) {
                return response()->json(['status' => false, 'message' => 'Error Please Refresh.']);
            }
        }
        $file       = $request->file('file');
        $allowedExt = ['jpg', 'jpeg', 'png'];

        $name = $file->getClientOriginalName();
        $ext  = strtolower($file->getClientOriginalExtension());
        $size = $file->getSize();

        if (!in_array($ext, $allowedExt)) {
            return response()->json(['status' => false, 'message' => 'File extension not allowed.']);
        }
        if ($size > 1000000) {
            return response()->json(['status' => false, 'message' => 'Image are too big']);
        }

        $name           = 'provider_' . str_random(20) . '.' . $ext;
        $path           = 'uploads/' . date('Y-m');
        $image          = new UserServiceProviderProjectImage;
        $image->type    = 'image';
        $image->image   = $path . '/' . $name;
        $image->unique  = $request->unique;
        if (isset($request->edit)) {
            $image->service_provider_project_id = $request->edit;
        }
        $image->save();

        Storage::makeDirectory($path);
        if (Storage::putFileAs($path, $file, $name)) {
            $displayImg = Image::make(storage_path('app/' . $path . '/' . $name))->save(storage_path('app/' . $path . '/' . $name));
        }

        return response()->json(['status' => true, 'message' => $image->toArray()]);
    }

    public function saveProject(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'title'                => 'required',
            ]
        );

        if (!$request->project_unique) {
            return back();
        }

        if ($validator->fails()) {
            $message = $validator->errors()->all();

            $message = implode('<br/>', $message);
            \Session::flash('error', $message);

            return back();
        } else {
            $provider                           = UserServiceProvider::where('user_id', \Auth::id())->first();
            if ($request->id_proj) {
                $project = UserServiceProviderProject::find($request->id_proj);
            } else {
                $project                            = new UserServiceProviderProject;
            }
            $project->title                     = $request->title;
            $project->user_service_provider_id  = $provider->id;
            $project->description               = $request->description;
            $project->save();

            if (!isset($request->id_proj)) {
                $images = UserServiceProviderProjectImage::where('unique', $request->project_unique)->get();
            }

            if ($request->id_proj) {
                $tempVideos = UserServiceProviderProjectImage::where('service_provider_project_id', $project->id)->where('type', 'video')->get();
                foreach ($tempVideos as $v) {
                    $v->delete();
                }
            }

            foreach ($request->video as $key => $value) {
                if ($value !== '' || !empty($value)) {
                    $video                              = new UserServiceProviderProjectImage;
                    $video->service_provider_project_id = $project->id;
                    $video->url                         = $value;
                    $video->type                        = 'video';
                    $video->unique                      = $request->project_unique;
                    $video->save();
                }
            }

            if (!isset($request->id_proj)) {
                $cover          = UserServiceProviderProjectImage::where('unique', $request->project_unique)->first();
            } else {
                $cover          = UserServiceProviderProjectImage::where('service_provider_project_id', $project->id)->first();
            }
            $project->cover  = $cover->image;

            $detailData        = $this->setDetail($request->detailName, $request->detailValue);
            $project->detail   = $detailData;
            $project->save();

            if (!isset($request->id_proj)) {
                foreach ($images as $image) {
                    $image->service_provider_project_id = $project->id;
                    $image->save();
                }
            }

            return redirect()->route('frontend.user.provider.project')->with('success', 'Project Successfully saved');
        }
    }

    public function projectEdit($id)
    {
        $project               = UserServiceProviderProject::with('images', 'videos')->findOrFail($id);
        $this->data['project'] = $project;
        $this->data['details'] = json_decode($project->detail);

        return $this->renderView('frontend.pages.users.includes.provider_project_edit');
    }

    public function projectDelete(Request $request)
    {
        $provider = UserServiceProvider::where('user_id', \Auth::id())->first();
        $project  = UserServiceProviderProject::find($request->id);

        if ($provider->id == $project->user_service_provider_id) {
            $images = UserServiceProviderProjectImage::where('service_provider_project_id', $project->id)->get();
            foreach ($images as $image) {
                if ($image->type == 'image') {
                    if (Storage::exists($image->image)) {
                        Storage::delete($image->image);
                    }
                }
                $image->delete();
            }
            $project->delete();

            $request->session()->flash('success', 'Project has been deleted');

            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false, 'message' => 'You are not allowed to do this action']);
        }
    }

    public function projectDeleteImage(Request $request)
    {
        $provider = UserServiceProvider::where('user_id', \Auth::id())->first();
        $image    = UserServiceProviderProjectImage::find($request->id);
        if ($provider->id == $image->project->user_service_provider_id) {
            if (Storage::exists($image->image)) {
                Storage::delete($image->image);
            }

            $image->delete();

            return response()->json(['status' => true, 'message' => $request->id]);
        }

        return response()->json(['status' => false, 'message' => 'You are not allowed to do this action']);
    }

    public function quotationList()
    {
        $provider                 = UserServiceProvider::where('user_id', \Auth::id())->firstOrFail();
        $quotations               = UserServiceProviderQuotation::with('project')->where('user_service_provider_id', $provider->id)->orderBy('read', 'DESC')->paginate(10);

        $this->data['quotations'] = $quotations;

        return $this->renderView('frontend.pages.users.includes.provider_quotation');
    }

    public function quotationDetail($id)
    {
        $quotation               = UserServiceProviderQuotation::find($id);
        $quotation->read         = 1;
        $quotation->save();

        $this->data['quotation'] = $quotation;

        return $this->renderView('frontend.pages.users.includes.ajax_quotation_detail');
    }

    public function quotationSet(Request $request)
    {
        $quotation               = UserServiceProviderQuotation::find($request->id);
        if ($quotation->read == 0) {
            $quotation->read = 1;
            $read            = 'read';
        } else {
            $read            = 'unread';
            $quotation->read = 0;
        }
        $quotation->save();
        $request->session()->flash('success', 'Quotation has been set to ' . $read);

        return response()->json(['status' => true]);
    }

    private function setDetail($name, $value)
    {
        $specData = [];

        for ($i = 0; $i < count($name); $i++) {
            if ($name[$i] != '' && $value[$i] != '') {
                $specData[] = ['name' => "$name[$i]", 'value' => "$value[$i]"];
            }
        }

        return json_encode($specData);
    }

    private function checkMidtrans($order_code)
    {
        $vt          = new Veritrans;
        $result      = $vt->status($order->order_code);

        return json_encode($result, JSON_UNESCAPED_SLASHES);
    }

    public function reward()
    {
        $content = Content::where('type', 'talasi_point')->first();

        $this->data['content']   = $content;
        $this->data['cuopons']   = Cuopon::whereDate('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->where('is_referral', 0)->get();
        $this->data['histories'] = UserReward::where('user_id', \Auth::id())->where('type', 'out')->orderBy('created_at', 'DESC')->get();

        return $this->renderView('frontend.pages.account.talasi_point');
    }

    public function rewardExchange(Request $request)
    {
        $decrypted      = Crypt::decryptString($request->coupon);
        $coupon         = Cuopon::find($decrypted);

        if ($coupon) {
            if ($coupon->points <= \Auth::user()->creditBalance()) {
                $reward             = new UserReward;
                $reward->user_id    = \Auth::id();
                $reward->order_id   = $coupon->id;
                $reward->points     = $coupon->points;
                $reward->type       = 'out';
                $reward->save();

                $type = $coupon->type;

                $request->session()->flash('success', 'Cuopon has been bought, Please Check your My Cuopon page to use the coupon');

                $userCuopon                 = new UserCoupon;

                if ($type == 'voucher') {
                    $voucher                    = new Voucher;
                    $voucher->type              = $coupon->voucher_type;
                    $voucher->start_date        = Carbon::now();
                    $voucher->end_date          = Carbon::now()->addDays($coupon->duration);
                    $voucher->limit_per_user    = 1;
                    $voucher->quota             = 1;
                    $voucher->unit              = 'Amount';
                    $voucher->discount          = $coupon->amount;
                    $voucher->min_amount        = $coupon->min_purchase;
                    $voucher->bank              = $coupon->bank;
                    $voucher->code              = $this->generateUniqueVoucher(8);
                    $voucher->save();

                    $userCuopon->voucher_id     = $voucher->id;
                    $userCuopon->coupon_id      = $coupon->id;
                    $userCuopon->type           = 'voucher';
                    $userCuopon->save();
                } else {
                    $userCuopon->type           = 'manual';
                }

                $userCuopon->user_id        = \Auth::id();
                $userCuopon->coupon_id      = $coupon->id;
                $userCuopon->save();

                // event(new Coupon($cuopon, \Auth::user()));

                return response()->json(['status' => true]);
            }
        }

        $request->session()->flash('error', 'Failed to buy cuopon');

        return response()->json(['status' => false]);
    }

    public function useManualCoupon($slug)
    {
        $decrypted      = Crypt::decryptString($slug);
        $coupon         = UserCoupon::find($decrypted);
        if ($coupon->user_id == \Auth::id()) {
            if ($coupon->used == 0) {
                event(new Coupon($coupon, \Auth::user()));
                session()->flash('success', 'Coupon has been used, our team will contact you soon.');
            } else {
                session()->flash('error', 'Coupon already used');
            }
        } else {
            session()->flash('error', 'Not your coupon');
        }

        $coupon->used = 1;
        $coupon->save();

        return redirect()->route('frontend.user.coupon');
    }

    public function getCoupon(Request $request)
    {
        $decrypted      = Crypt::decryptString($request->coupon);
        $coupon         = Cuopon::find($decrypted);

        if ($coupon) {
            if ($request->vc) {
                $decryptedVc            = Crypt::decryptString($request->vc);
                $this->data['userVc']   = UserCoupon::find($decryptedVc);
            }
            $this->data['coupon']   = $coupon;
            $template               = view('frontend.pages.account.includes.part_modal_coupon', $this->data)->render();

            return response()->json([
                'status'    => true,
                'message'   => $template,
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Can not find coupon!']);
    }

    public function reorder($id)
    {
        $decrypted              = Crypt::decryptString($id);
        $order                  = Order::find($decrypted);

        $cart               = Cart::where('user_id', \Auth::id())->where('status', 'current')->first();
        if ($cart) {
            $cart->status       = 'checkout';
            $cart->save();
        }

        $oldCart = Cart::find($order->cart_id);

        $newCart         = $oldCart->replicate();
        $newCart->status = 'current';
        $newCart->save();

        $oldCartDetails = CartDetail::where('cart_id', $oldCart->id)->get();

        foreach ($oldCartDetails as $newCartDet) {
            $newDet                 = $newCartDet->replicate();
            $newDet->cart_id        = $newCart->id;
            $newDet->save();
        }

        return redirect()->route('frontend.cart.index');
    }

    public function myCoupon()
    {
        $content = Content::where('type', 'my_coupon')->first();

        $this->data['content'] = $content;

        return $this->renderView('frontend.pages.account.my_coupon');
    }

    public function useCoupon(Request $request)
    {
        $decrypted      = Crypt::decryptString($request->coupon);
        $voucher        = Voucher::find($decrypted);

        session()->forget('voucher');

        $carts          = Cart::with('details', 'details.product', 'details.product.cover', 'details.product.brand')->where('status', 'current')->where('type', 'cart')->where('user_id', \Auth::id())->first();
        $subtotal       = $carts->total_price;

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
                                'message' => 'Voucher code has been applied',
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
                    'message' => 'Your transaction amount is below ' . currency_format($voucher->min_amount),
                ]);
            }
        } else {
            return \Response::json([
                'status'  => false,
                'message' => 'Voucher code is not exist',
            ]);
        }
    }

    public function referral()
    {
        if (\Auth::id()) {
            if (\Auth::user()->hasRewardNotification()) {
                $notification           = UserRewardNotification::where('user_id', \Auth::id())->where('is_read', 0)->first();
                $notification->is_read  = 1;
                $notification->save();

                $coupon                     = Cuopon::where('is_referral', 1)->first();
                $this->data['coupon']       = $coupon;
                $this->data['notification'] = $notification;
            }
        }

        $content                    = Content::where('type', 'referral_content')->first();

        $this->data['content']      = $content;
        $this->data['json']         = json_decode($content->other_content);

        return $this->renderView('frontend.pages.account.referral');
    }

    public function blastReferral(Request $request)
    {
        $limit = Cookie::get('referal_limit');
        if ($limit) {
            \Session::flash('error', 'Recaptcha expired, please retry');

            return redirect()->back()->withInput();
        }

        $request->validate([
            'email'                      => 'required',
            'recaptcha'                  => 'required'
        ]);

        $recaptcha_url      = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret   = env('RECAPTCHAV3_SECRET');
        $recaptcha_response = $request->recaptcha;

        $recaptcha = $recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response;

        $client  = new \GuzzleHttp\Client();
        $res     = $client->get($recaptcha);
        $content = (string) $res->getBody();

        $recaptcha = json_decode($content);

        if ($recaptcha->score >= 0.5) {
            $email = $request->email;

            $data = [
                'email'              => $email,
                'title'              => 'Talasi Family Invitation',
            ];

            $bcc    = str_replace(' ', '', $request->email);
            $bcc    = explode(',', $bcc);

            foreach ($bcc as $index => $email) {
                if ($email == '') {
                    unset($bcc[$index]);
                }
            }

            $firstEmail = array_splice($bcc, 0, 1);

            if ($bcc[1]) {
                unset($bcc[0]);
            }

            Mail::to($firstEmail)
            ->bcc($bcc)
            ->queue(new ReferalMail(\Auth::user()));

            $minutes = 1;
            $cookie  = cookie('referal_limit', 'block', $minutes);

            return redirect()->back()->with('success', 'Thank You, Your invitation has been sent.')->cookie($cookie);
        } else {
            \Session::flash('error', 'Recaptcha failed, please retry');

            return redirect()->back()->withInput();
        }
        \Session::flash('error', 'Recaptcha expired, please retry');
    }

    public function addReferral(Request $request)
    {
        $request->validate([
            'referral'      => 'required',
            'recaptcha'     => 'required'
        ]);

        $recaptcha_url      = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret   = env('RECAPTCHAV3_SECRET');
        $recaptcha_response = $request->recaptcha;

        $recaptcha = $recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response;

        $client  = new \GuzzleHttp\Client();
        $res     = $client->get($recaptcha);
        $content = (string) $res->getBody();

        $recaptcha = json_decode($content);

        if ($recaptcha->score >= 0.5) {
            $id                     = substr($request->referral, 5, 9);
            $user                   = User::find($id);
            if ($user) {
                if ($user->id !== \Auth::id()) {
                    $referrer               = new UserReferral;
                    $referrer->user_id      = \Auth::id();
                    $referrer->upline_id    = $user->id;
                    $referrer->save();

                    session()->forget('referral_code');

                    return redirect()->back()->with('success', 'Your invitation has been sent.');
                }
                \Session::flash('error', 'You cannot add yourself as referrer.');

                return redirect()->back()->withInput();
            }

            \Session::flash('error', 'Cannot find referer');

            return redirect()->back()->withInput();
        } else {
            \Session::flash('error', 'Recaptcha failed, please retry');

            return redirect()->back()->withInput();
        }
        \Session::flash('error', 'Recaptcha expired, please retry');
    }

    private function generateUniqueVoucher($length = 20)
    {
        $characters       = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
