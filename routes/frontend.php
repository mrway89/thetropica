<?php

Route::group(['middleware' => 'App\Http\Middleware\Maintenance'], function () {
    Route::get('/', 'Frontend\HomeController@index')->name('frontend.home');
    Route::get('/home', 'Frontend\HomeController@index');

    // AUTH
    Route::get('old/login', 'Frontend\AuthController@loginIndex')->name('login');
    Route::get('/login', 'Frontend\AuthController@loginIndex')->name('frontend.login');
    Route::post('/login/user', 'Frontend\AuthController@login')->name('frontend.login.post');
    Route::post('/register', 'Frontend\AuthController@register')->name('frontend.register');
    route::get('/email-confimation/{hash}', 'Frontend\AuthController@verification')->name('frontend.verification');
    Route::get('/logout', 'Frontend\AuthController@logout')->name('frontend.logout');
    Route::get('/forgot-password', 'Frontend\AuthController@forgotPasswordIndex')->name('frontend.forgot');
    Route::post('/forgot-password/post', 'Frontend\AuthController@forgotPassword')->name('frontend.forgot.post');
    Route::get('/forgot-password/{hash}', 'Frontend\AuthController@forgotPasswordVerification')->name('frontend.forgot.verification');

    // NEWSLETTER
    Route::post('/newsletter/add', 'Frontend\ContentController@subscribe')->name('frontend.newsletter.add');

    // EXPERIENCE
    Route::get('experience', 'Frontend\ExperienceController@experienceIndex')->name('frontend.experience.index');
    Route::get('experience/list', 'Frontend\ExperienceController@experienceList')->name('frontend.experience.list');
    Route::get('experience/retreat', 'Frontend\ExperienceController@experienceRetreat')->name('frontend.experience.retreat');
    Route::get('experience/retreat/{slug}', 'Frontend\ExperienceController@experienceRetreatDetail')->name('frontend.experience.retreat.detail');
    Route::get('experience/factory-visit', 'Frontend\ExperienceController@experienceFactory')->name('frontend.experience.factory');
    Route::get('experience/camp-with-us', 'Frontend\ExperienceController@experienceCamps')->name('frontend.experience.camps');
    Route::get('experience/camp-with-us/{slug}', 'Frontend\ExperienceController@experienceCampsDetail')->name('frontend.experience.camps.detail');

    // STATIC CONTENT
    Route::get('/pages/{slug}', 'Frontend\ContentController@staticContent')->name('frontend.static.content');

    // CART
    Route::post('/cart/add', 'Frontend\CartController@addToCart')->name('frontend.cart.add');
    Route::post('/cart/update', 'Frontend\CartController@updateCart')->name('frontend.cart.update');
    Route::post('/cart/delete', 'Frontend\CartController@deleteCartSingle')->name('frontend.cart.delete');
    Route::post('/cart/delete-multiple', 'Frontend\CartController@multipleDelete')->name('frontend.cart.multidelete');

    // wishlist
    Route::get('/user/wishlist', 'Frontend\UserController@wishlist')->name('frontend.user.wishlist');
    Route::post('/user/wishlist/set', 'Frontend\UserController@setWishlist')->name('frontend.user.wishlist.set');
    Route::post('/user/wishlist/delete', 'Frontend\UserController@deleteWishlist')->name('frontend.user.wishlist.delete');
    Route::post('/user/wishlist/search', 'Frontend\UserController@wishlistSearch')->name('frontend.user.wishlist.search');

    // ABOUT US
    Route::get('about', 'Frontend\ContentController@aboutUs')->name('frontend.about');
    Route::get('contactus', 'Frontend\ContentController@contactUs')->name('frontend.contactus');
    Route::post('about/contact/post', 'Frontend\ContentController@contactPost')->name('frontend.about.contact.post');
    Route::get('news', 'Frontend\ContentController@newsIndex')->name('frontend.news');
    Route::get('news-detail/{id}', 'Frontend\ContentController@newsDetail')->name('frontend.news_detail');

    // USER AGREEMENT
    Route::get('user-agreement', 'Frontend\ContentController@userAgreement')->name('frontend.user.agreement');

    // SHOPPING
    Route::prefix('product')->group(function () {
        Route::get('/', 'Frontend\ShoppingController@productBrand')->name('frontend.product.brand');
        Route::get('{slug}', 'Frontend\ShoppingController@productDetail')->name('frontend.product.detail');
    });

    Route::prefix('purchase')->group(function () {
        Route::get('product-list', 'Frontend\ShoppingController@purchase')->name('frontend.product.purchase');
        Route::get('product-at-home', 'Frontend\ShoppingController@athome')->name('frontend.product.athome');
        Route::get('product-gift', 'Frontend\ShoppingController@gift')->name('frontend.product.gift');
        Route::get('product-massage-oil', 'Frontend\ShoppingController@purchase_oil')->name('frontend.product.purchase_oil');
	Route::get('product-aromatherapy', 'Frontend\ShoppingController@purchase_aromatherapy')->name('frontend.product.purchase_aromatherapy');
	Route::get('product-beauty-and-wellness', 'Frontend\ShoppingController@purchase_beauty_and_wellness')->name('frontend.product.purchase_beauty_and_wellness');
        Route::get('shopping-guide', 'Frontend\ContentController@shoppingGuide')->name('frontend.guide.shopping');
        Route::get('payment-guide', 'Frontend\ContentController@paymentGuide')->name('frontend.guide.payment');
        Route::get('faqs', 'Frontend\ContentController@faqs')->name('frontend.guide.faqs');
        Route::get('compare', 'Frontend\ShoppingController@compare')->name('frontend.product.compare');
        Route::get('product-detail/{id}', 'Frontend\ShoppingController@purchase_detail')->name('frontend.product.purchase_detail');
    });

    Route::get('search', 'Frontend\ShoppingController@searchProduct')->name('frontend.product.search');

    // ORIGIN
    Route::prefix('origin')->group(function () {
        Route::get('/', 'Frontend\ContentController@originIndex')->name('frontend.origin.index');
        Route::get('{slug}', 'Frontend\ContentController@originDetail')->name('frontend.origin.detail');
    });

    // AUTH SOCIAL MEDIA
    // Facebook
    Route::get('/user/redirect_to_facebook', 'Frontend\AuthController@redirect_to_facebook')->name('frontend.oauth.redirect_to_facebook');
    Route::get('/user/handle_facebook_callback', 'Frontend\AuthController@handle_facebook_callback')->name('frontend.oauth.handle_facebook_callback');

    // Google
    Route::get('/user/redirect_to_google', 'Frontend\AuthController@redirect_to_google')->name('frontend.oauth.redirect_to_google');
    Route::get('/user/handle_google_callback', 'Frontend\AuthController@handle_google_callback')->name('frontend.oauth.handle_google_callback');

    // LINKEDIN
    Route::get('/user/redirect_to_linkedin', 'Frontend\AuthController@redirect_to_linkedin')->name('frontend.oauth.redirect_to_linkedin');
    Route::get('/user/handle_linkedin_callback', 'Frontend\AuthController@handle_linkedin_callback')->name('frontend.oauth.handle_linkedin_callback');

    // TWITTER
    Route::get('/user/redirect_to_twitter', 'Frontend\AuthController@redirect_to_twitter')->name('frontend.oauth.redirect_to_twitter');
    Route::get('/user/handle_twitter_callback', 'Frontend\AuthController@handle_twitter_callback')->name('frontend.oauth.handle_twitter_callback');

    Route::post('/user/verification_code', 'Frontend\AuthController@verification_code')->name('frontend.user.verification_code');
    Route::post('/user/reset_password', 'Frontend\AuthController@reset_password_save')->name('frontend.user.reset_password_save');

    // LANGUANGE SWITCH
    // Route::get('locale/{locale?}', 'Frontend\AuthController@switchLangueage')->name('frontend.language');

    Route::middleware('auth')->group(function () {
        // SHIPPING
        Route::get('/shopping-cart', 'Frontend\CartController@index')->name('frontend.cart.index');
        Route::post('/address', 'Frontend\UserController@saveAddress')->name('frontend.user.address.save');
        Route::post('/acc/address', 'Frontend\UserController@saveAccAddress')->name('frontend.user.address.acc.save');
        Route::post('/checkout/address/edit', 'Frontend\AjaxController@editAddress')->name('frontend.checkout.address.edit');
        Route::post('/checkout/address/get', 'Frontend\AjaxController@getAddress')->name('frontend.checkout.address.get');
        Route::post('/checkout/address/update-pinpoint', 'Frontend\AjaxController@saveCurrentPinpoint')->name('frontend.checkout.pinpoint.update');
        Route::post('/checkout/address/use_address', 'Frontend\AjaxController@useAddress')->name('frontend.cart.use_address');
        Route::get('/checkout/shipping', 'Frontend\CartController@shipping')->name('frontend.cart.shipping');

        // MULTISHIPPING
        Route::post('/checkout/shipping/store', 'Frontend\CartController@shippingStore')->name('frontend.cart.shipping.store');
        Route::get('/checkout/multi-shipping', 'Frontend\CartController@multiShipping')->name('frontend.cart.multishipping');
        Route::post('/checkout/multi-shipping/save', 'Frontend\CartController@multiShippingStore')->name('frontend.cart.multishipping.store');
        Route::get('/checkout/multi-shipping/courier', 'Frontend\CartController@multiShippingCourier')->name('frontend.cart.multishipping.courier');
        Route::post('/checkout/multi-shipping/courier/save', 'Frontend\CartController@multiShippingCourierStore')->name('frontend.cart.multishipping.courier.save');

        Route::get('/checkout/participants', 'Frontend\CartController@participants')->name('frontend.cart.participants');
        Route::post('/checkout/participants', 'Frontend\CartController@participants')->name('frontend.cart.participants');
        // PAYMENT METHOD
        Route::get('/checkout/payment', 'Frontend\CartController@paymentMethod')->name('frontend.cart.payment');
        Route::post('/checkout/payment/process', 'Frontend\CartController@paymentProcess')->name('frontend.cart.payment.store');
        Route::post('/checkout/payment/credit-card', 'Frontend\CartController@ccProcess')->name('frontend.cart.payment.cc');
        Route::get('/checkout/payment/virtual-account/{bank}', 'Frontend\CartController@virtualAccount')->name('frontend.cart.payment.va');
        // Route::get('/checkout/payment/rewards-points', 'Frontend\CartController@pointPayment')->name('frontend.cart.payment.reward_points');
        Route::get('/checkout/payment/convenience-store/{cvs}', 'Frontend\CartController@convenienceStore')->name('frontend.cart.payment.cvs');
        Route::get('/checkout/payment/credit-card', 'Frontend\CartController@creditCard')->name('frontend.cart.payment.cc');
        Route::get('/checkout/payment/ovo', 'Frontend\CartController@ovo')->name('frontend.cart.payment.ovo');

        // MIDTRANS
        Route::post('/midtrans/snaptoken', 'Frontend\CartController@midtransToken')->name('frontend.midtrans.token');
        Route::post('/midtrans/payment/gopay', 'Frontend\CartController@gopay')->name('frontend.cart.payment.gopay');

        // ORDER
        Route::get('/order/{code}', 'Frontend\OrderController@detail')->name('frontend.order.detail');
        // VOUCHER
        Route::post('/checkout/voucher', 'Frontend\CartController@checkVoucher')->name('frontend.cart.voucher.check');
        Route::post('/checkout/voucher/cancel', 'Frontend\CartController@cancelVoucher')->name('frontend.cart.voucher.cancel');

        // Route::post('/checkout/use/reward-point', 'Frontend\CartController@useReward')->name('frontend.cart.use.reward');

        // USER PROFILE
        // profile
        Route::get('/user/profile', 'Frontend\UserController@profile')->name('frontend.user.profile');
        Route::get('/user/profile/edit-profile', 'Frontend\UserController@editProfile')->name('frontend.user.profile.edit');
        Route::post('/user/profile/edit-profile/save', 'Frontend\UserController@saveProfile')->name('frontend.user.profile.edit.save');
        // transaction history
        Route::get('/user/order-history', 'Frontend\UserController@transactions')->name('frontend.user.transaction');
        Route::get('/user/order-history/{id}', 'Frontend\UserController@reorder')->name('frontend.user.transaction.reorder');
        Route::post('/account/review/get', 'Frontend\UserController@getReview')->name('frontend.user.review.get');
        Route::post('/account/review/save', 'Frontend\UserController@saveReview')->name('frontend.user.review.store');
        // Route::get('/user/order-history/detail/{order_code}', 'Frontend\UserController@transactionDetail')->name('frontend.user.transaction.detail');
        // Route::get('/user/invoice/{order_code}', 'Frontend\UserController@invoicePrint')->name('frontend.user.transaction.invoice_print');
        // address
        Route::get('/user/address', 'Frontend\UserController@addressList')->name('frontend.user.address');
        Route::get('/user/address/new-address', 'Frontend\UserController@formAddress')->name('frontend.user.address.form_add');
        Route::get('/user/address/edit-address/{edit}', 'Frontend\UserController@formAddress')->name('frontend.user.address.form_edit');
        Route::post('/user/address/add-new-address', 'Frontend\UserController@saveFormAddress')->name('frontend.user.address.add_new');
        Route::post('/user/address/set-as-default', 'Frontend\UserController@setAsDefaultAddress')->name('frontend.user.address.set_default');
        Route::post('/user/address/update-pinpoint', 'Frontend\UserController@updatePinpoint')->name('frontend.user.address.pinpoint.update');
        Route::post('/user/address/multi-delete-address', 'Frontend\UserController@multiDeleteAddress')->name('frontend.user.address.multi_delete_address');
        Route::post('/user/address/single-delete-address', 'Frontend\UserController@singleDeleteAddress')->name('frontend.user.address.single_delete_address');
        // wishlist
        Route::get('/user/wishlist', 'Frontend\UserController@wishlist')->name('frontend.user.wishlist');
        Route::post('/user/wishlist/set', 'Frontend\UserController@setWishlist')->name('frontend.user.wishlist.set');
        Route::post('/user/wishlist/delete', 'Frontend\UserController@deleteWishlist')->name('frontend.user.wishlist.delete');
        Route::post('/user/wishlist/search', 'Frontend\UserController@wishlistSearch')->name('frontend.user.wishlist.search');
        // user notification
        Route::get('/user/notification', 'Frontend\UserController@userNotification')->name('frontend.user.notification');
        Route::post('/user/notification/mark-as-read', 'Frontend\UserController@marAsRead')->name('frontend.user.notification.mark_read');
        Route::post('/user/notification/mark-all-as-read', 'Frontend\UserController@marAllAsRead')->name('frontend.user.notification.mark_all_read');
        // REWARD
        Route::get('/user/talasi-point', 'Frontend\UserController@reward')->name('frontend.user.reward');
        Route::get('/user/my-coupon', 'Frontend\UserController@myCoupon')->name('frontend.user.coupon');
        Route::post('/user/my-coupon/use', 'Frontend\UserController@useCoupon')->name('frontend.user.use.coupon');
        Route::post('/user/coupon/get', 'Frontend\UserController@getCoupon')->name('frontend.user.get.coupon');
        Route::get('/user/my-coupon/manual/{slug}', 'Frontend\UserController@useManualCoupon')->name('frontend.user.use.manual.coupon');
        Route::post('/user/reward-point/exchange', 'Frontend\UserController@rewardExchange')->name('frontend.user.reward.exchange');
        Route::get('/user/referral', 'Frontend\UserController@referral')->name('frontend.user.referral');
        Route::post('/user/referral/send', 'Frontend\UserController@blastReferral')->name('frontend.user.referral.send');
        Route::post('/user/referral/add', 'Frontend\UserController@addReferral')->name('frontend.user.referral.add');
    });

    Route::get('test', 'Frontend\OrderController@test');

    Route::post('/language', function () {
        session(['locale' => Request::Input('locale')]);
        app()->setLocale(Request::Input('locale'));
        session()->put(['locale' => Request::Input('locale')]);

        return redirect()->back();
    })->name('frontend.language');

    // AJAX
    Route::post('/ajax/country_city', 'Frontend\ContentController@ajaxCountryCity')->name('frontend.get.country_city');
    Route::get('/rajaongkir/city', 'Frontend\AjaxController@rajaongkirGetCity')->name('frontend.rajaongkir.get_city');
    Route::get('/ajax/product/{id}', 'Frontend\ContentController@ajaxGetProduct')->name('frontend.get.product');
    Route::get('/ajax/reviews/{id}', 'Frontend\ContentController@ajaxGetReview')->name('frontend.get.review');
    Route::get('/ajax/reviews-image/{id}', 'Frontend\ContentController@ajaxGetReviewImage')->name('frontend.get.review.image');
    Route::post('/ajax/compare/get/product', 'Frontend\ContentController@ajaxCompareProduct')->name('frontend.ajax.compare.product');
    Route::post('/ajax/compare/product/detail', 'Frontend\ContentController@ajaxCompareProductDetail')->name('frontend.ajax.compare.product.detail');
    Route::post('/ajax/compare/product/remove', 'Frontend\ContentController@ajaxCompareProductRemove')->name('frontend.ajax.compare.product.remove');
    Route::post('/ajax/multiship/set/address', 'Frontend\AjaxController@setAddressMulti')->name('frontend.ajax.multi.set.address');
    Route::post('/ajax/multiship/get/user-address', 'Frontend\AjaxController@getUserAddress')->name('frontend.ajax.multi.get.address');
    Route::post('/ajax/multiship/save/address', 'Frontend\AjaxController@saveUseAddress')->name('frontend.ajax.multi.save.address');
    Route::post('/ajax/multiship/get/courier', 'Frontend\AjaxController@multiGetCourier')->name('frontend.ajax.multi.get.courier');
});

// --------------------------
// NICEPAY
Route::any('nicepay/callback-url', 'Frontend\NicepayController@callback')->name('system.nicepay.callback');
Route::any('nicepay/process-url', 'Frontend\NicepayController@process')->name('system.nicepay.process');
// MIDTRANS
Route::any('midtrans/notification', 'Frontend\MidtransController@notification')->name('system.midtrans.notification');
Route::post('midtrans/finish', 'Frontend\MidtransController@finish')->name('system.midtrans.finish');
Route::post('midtrans/unfinish', 'Frontend\MidtransController@unfinish')->name('system.midtrans.unfinish');
Route::post('midtrans/error', 'Frontend\MidtransController@error')->name('system.midtrans.error');
Route::post('midtrans/snap-finish', 'Frontend\MidtransController@snapFinish')->name('system.midtrans.snap.finish');
Route::post('midtrans/snap-unfinish', 'Frontend\MidtransController@snapUnfinish')->name('system.midtrans.snap.unfinish');
Route::post('midtrans/snap-error', 'Frontend\MidtransController@snapError')->name('system.midtrans.snap.error');

// GOSEND WEBHOOK
Route::post('gosend/webhook', 'Frontend\GosendController@webhook')->name('system.gosend.webhook');

// TEMPORARY
Route::get('dotcommsolution/trigger', 'Frontend\TemporaryController@cronTemp');
Route::get('coming-soon', 'Frontend\TemporaryController@upcomingPage')->name('frontend.upcoming.page');
Route::post('upcoming/subscribe', 'Frontend\TemporaryController@upcomingSubscribe')->name('frontend.upcoming.subscribe');

Route::any('nicepay/ovo/{order}', 'Frontend\HomeController@ovoProcess');
Route::post('/mid/notification_order', 'PaymentOrderController@payment_notification');
Route::get('/payment/finish', 'Frontend\PaymentController@payment_finish')->name('frontend.order.payment_finish');
Route::get('/payment/unfinish', 'Frontend\PaymentController@payment_unfinish')->name('frontend.order.payment_unfinish');
//Route::get('midtes', 'Frontend\ContentController@midtes')->name('frontend.midtes');
