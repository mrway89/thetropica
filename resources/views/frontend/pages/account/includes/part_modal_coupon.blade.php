<div class="col-md-5 py-3 d-flex align-items-center justify-content-center img-coupon mt-mb-0 mt-3">
    <img src="{{asset($coupon->images)}}" alt="">
</div>
<div class="col-md-7 py-3">
    <div class="congrats mb-3">{{ $coupon->title }}</div>
    <h3 class="referral-title mb-4">{{ $coupon->name }}</h3>
    <div class="desc-modal mh-modal mb-3">
        {!! $coupon->description !!}
    </div>

    @if ($userVc)

        @if ($userCoupon->type == 'voucher')
            <button class="btn btn-pink btn-oval btn-addcart-popup use_cuopon" data-id="{{ Crypt::encryptString($userVc->voucher_id) }}">USE THIS COUPON</button>
        @else
            <a href="{{ route('frontend.user.use.manual.coupon', Crypt::encryptString($userVc->id)) }}" class="use_manual_cuopon">
                <button class="btn btn-pink btn-oval btn-addcart-popup" data-id="{{ Crypt::encryptString($userVc->voucher_id) }}">USE THIS COUPON</button>
            </a>
        @endif
    @else
        @if ($coupon->points <= \Auth::user()->creditBalance())
            <button class="btn btn-pink btn-oval btn-addcart-popup buy_cuopon" data-id="{{ Crypt::encryptString($coupon->id) }}">GET THIS COUPON</button>
        @endif
    @endif
</div>
