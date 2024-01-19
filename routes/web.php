<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('frontend')->group(function () {
    Route::get('', ['as' => 'template.index', 'uses' => '\App\Http\Controllers\TemplateController@index']);
    Route::get('home', ['as' => 'template.index', 'uses' => '\App\Http\Controllers\TemplateController@index']);
    Route::get('login', ['as' => 'template.login', 'uses' => '\App\Http\Controllers\TemplateController@login']);
    Route::get('forgot', ['as' => 'template.forgot', 'uses' => '\App\Http\Controllers\TemplateController@forgot']);
    Route::get('reset', ['as' => 'template.reset', 'uses' => '\App\Http\Controllers\TemplateController@reset']);
    Route::get('about', ['as' => 'template.about', 'uses' => '\App\Http\Controllers\TemplateController@about']);
    Route::get('product', ['as' => 'template.pages.product', 'uses' => '\App\Http\Controllers\TemplateController@product']);
    Route::get('product-list', ['as' => 'template.product.product_list', 'uses' => '\App\Http\Controllers\TemplateController@product_list']);
    Route::get('shopping-guide', ['as' => 'template.shopping_guide', 'uses' => '\App\Http\Controllers\TemplateController@shopping_guide']);
    Route::get('payment-guide', ['as' => 'template.payment_guide', 'uses' => '\App\Http\Controllers\TemplateController@payment_guide']);
    Route::get('compare-product', ['as' => 'template.compare_product', 'uses' => '\App\Http\Controllers\TemplateController@compare_product']);
    Route::get('product/product-detail', ['as' => 'template.product_detail', 'uses' => '\App\Http\Controllers\TemplateController@product_detail']);
    Route::get('cart/order', ['as' => 'template.order', 'uses' => '\App\Http\Controllers\TemplateController@order']);
    Route::get('cart/checkout', ['as' => 'template.checkout', 'uses' => '\App\Http\Controllers\TemplateController@checkout']);
    Route::get('cart/checkout/multiple-address', ['as' => 'template.multiple', 'uses' => '\App\Http\Controllers\TemplateController@multiple']);
    Route::get('search-result', ['as' => 'template.pages.search_result', 'uses' => '\App\Http\Controllers\TemplateController@search_result']);
    Route::get('cart/payment-method', ['as' => 'template.payment_method', 'uses' => '\App\Http\Controllers\TemplateController@payment_method']);
    Route::get('cart/complete-payment', ['as' => 'template.complete_payment', 'uses' => '\App\Http\Controllers\TemplateController@complete_payment']);
    Route::get('account/profile', ['as' => 'template.pages.account.profile', 'uses' => '\App\Http\Controllers\TemplateController@profile']);
    Route::get('account/edit-profile', ['as' => 'template.pages.account.edit_profile', 'uses' => '\App\Http\Controllers\TemplateController@edit_profile']);
    Route::get('account/address', ['as' => 'template.pages.account.profile', 'uses' => '\App\Http\Controllers\TemplateController@address']);
    Route::get('account/wishlist', ['as' => 'template.pages.account.profile', 'uses' => '\App\Http\Controllers\TemplateController@wishlist']);
    Route::get('account/notifications', ['as' => 'template.pages.account.profile', 'uses' => '\App\Http\Controllers\TemplateController@notifications']);
    Route::get('account/order-history', ['as' => 'template.pages.account.order', 'uses' => '\App\Http\Controllers\TemplateController@order_history']);
    Route::get('account/my_coupon', ['as' => 'template.pages.account.my_coupon', 'uses' => '\App\Http\Controllers\TemplateController@my_coupon']);
    Route::get('account/talasi_point', ['as' => 'template.pages.account.talasi_point', 'uses' => '\App\Http\Controllers\TemplateController@talasi_point']);
    Route::get('account/referral', ['as' => 'template.pages.account.referral', 'uses' => '\App\Http\Controllers\TemplateController@referral']);
    Route::get('account/referral-invite-success', ['as' => 'template.pages.account.reveral_invite_success', 'uses' => '\App\Http\Controllers\TemplateController@referral_invite_success']);
    Route::get('faq', ['as' => 'template.pages.purchase.faq', 'uses' => '\App\Http\Controllers\TemplateController@faq']);
    Route::get('pickup_point', ['as' => 'template.pages.purchase.pick_up_point', 'uses' => '\App\Http\Controllers\TemplateController@pickup_point']);
    Route::get('origin', ['as' => 'template.pages.origin.origin_map', 'uses' => '\App\Http\Controllers\TemplateController@origin']);
    Route::get('origin/discover', ['as' => 'template.pages.origin.discover_origin', 'uses' => '\App\Http\Controllers\TemplateController@discover_origin']);
    Route::get('experience', ['as' => 'template.pages.experience.experience_index', 'uses' => '\App\Http\Controllers\TemplateController@experience']);
    Route::get('experience-list', ['as' => 'template.pages.experience.experience_index', 'uses' => '\App\Http\Controllers\TemplateController@experience_list']);
    Route::get('experience/retreat', ['as' => 'template.pages.experience.retreat', 'uses' => '\App\Http\Controllers\TemplateController@retreat']);
    Route::get('experience/detail-retreat', ['as' => 'template.pages.experience.detail_retreat', 'uses' => '\App\Http\Controllers\TemplateController@detail_retreat']);
    Route::get('experience/factory-visit', ['as' => 'template.pages.experience.factory_visit', 'uses' => '\App\Http\Controllers\TemplateController@factory_visit']);
    Route::get('experience/camp-us', ['as' => 'template.pages.experience.camp_us', 'uses' => '\App\Http\Controllers\TemplateController@camp_us']);
    Route::get('experience/camp-us-list', ['as' => 'template.pages.experience.camp_us_list', 'uses' => '\App\Http\Controllers\TemplateController@camp_us_list']);
    Route::get('user-agreement', ['as' => 'template.pages.user_agreement', 'uses' => '\App\Http\Controllers\TemplateController@user_agreement']);
    Route::get('payment-failed', ['as' => 'template.pages.payment_failed', 'uses' => '\App\Http\Controllers\TemplateController@payment_failed']);
});
// require __DIR__ . '/frontend/index.php';
Route::get('/tj', function () {
    return view('print.address');
});

require __DIR__ . '/frontend.php';
