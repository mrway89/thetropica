<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index() {
        return view('template/index');
    }

    public function login() {
        return view('template/login/login');
    }

    public function forgot() {
        return view('template/login/forgot');
    }

    public function reset() {
        return view('template/login/reset');
    }

    public function about() {
        return view('template/about');
    }
    
    public function product() {
        return view('template/pages/product');
    }
    public function product_list() {
        return view('template/product/product_list');
    }
    public function search_result() {
        return view('template/pages/search_result');
    }

    public function shopping_guide() {
        return view('template/pages/purchase/shopping_guide');
    }

    public function payment_guide() {
        return view('template/pages/purchase/payment_guide');
    }

    public function compare_product() {
        return view('template/pages/purchase/compare_product');
    }

    public function product_detail() {
        return view('template/product/product_detail');
    }

    public function order() {
        return view('template/checkout/order');
    }

    public function checkout() {
        return view('template/checkout/checkout');
    }

    public function multiple() {
        return view('template/checkout/multiple_address');
    }

    public function payment_method() {
        return view('template/checkout/payment_method');
    }

    public function complete_payment() {
        return view('template/checkout/complete_payment');
    }

    public function profile() {
        return view('template/pages/account/profile');
    }
    public function edit_profile() {
        return view('template/pages/account/edit_profile');
    }

    public function address() {
        return view('template/pages/account/address');
    }

    public function wishlist() {
        return view('template/pages/account/wishlist');
    }

    public function notifications() {
        return view('template/pages/account/notifications');
    }
    public function my_coupon() {
        return view('template/pages/account/my_coupon');
    }
    public function talasi_point() {
        return view('template/pages/account/talasi_point');
    }
    public function referral() {
        return view('template/pages/account/referral');
    }
    public function referral_invite_success() {
        return view('template/pages/account/referral_invite_success');
    }
    public function faq() {
        return view('template/pages/purchase/faq');

    }
    public function user_agreement() {
        return view('template/pages/user_agreement');

    }
    public function payment_failed() {
        return view('template/pages/purchase/payment_failed');

    }
    public function pickup_point() {
        return view('template/pages/purchase/pick_up_point');

    }
    public function order_history() {
        return view('template/pages/account/order');

    }
    public function origin() {
        $data['origin']=array('Kuansing','Bali','Lampung','Sumba','Kapuas Hulu','Luwu','Magelang');
        return view('template/pages/origin/origin_map',$data);

    }
    public function discover_origin() {
        return view('template/pages/origin/discover_origin');
    }
    public function experience() {
        return view('template/pages/experience/experience_index');
    }
    public function experience_list() {
        return view('template/pages/experience/list_experience');
    }
    public function user_aggrement() {
        return view('template/pages/user_aggrement');

    }

    public function retreat() {
        return view('template/pages/experience/retreat');
    }
    public function detail_retreat() {
        return view('template/pages/experience/detail_retreat');
    }
    public function factory_visit() {
        return view('template/pages/experience/factory_visit');
    }
    public function camp_us() {
        return view('template/pages/experience/camp_us');
    }
    public function camp_us_list() {
        return view('template/pages/experience/camp_us_list');
    }
    
}
