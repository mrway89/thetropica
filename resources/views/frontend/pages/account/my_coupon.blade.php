@extends('frontend/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="content-area">
	<div class="container container-product">
		<div class="row">
            <div class="col-md-9 col-sm-12 col-12 offset-md-3 offset-0 pt-3">
				<h3 class="bold-300 mb-4 pt-5">My Coupon</h3>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-6">
				@include('frontend/pages/account/includes/sidemenu')
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="mb-2 border-top-mb pt-mb-0 pt-3">
                    {!! $content->{'content_' . $language} !!}
                </div>
               <div class="row">
                   @foreach (\Auth::user()->coupons as $userCoupon)
                        @if ($userCoupon->type == 'voucher')
                            @if ($userCoupon->checkCoupon())
                                <div class="col-md-6 position-relative pt-3 mb-4">
                                    @if ($userCoupon->created_at->isToday())
                                        <div class="new-coupon position-absolute"><img src="{{asset('assets/img/new.png')}}" alt=""></div>
                                    @endif
                                    <div class="coupon mb-3">
                                        <img src="{{asset($userCoupon->coupon->images)}}" alt="">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-mb-6 col-12 mb-md-0 mb-3 pr-md-3  pl-md-3 pl-5 pr-5">
                                            <a href="#" class="coupon_detail" data-id="{{ Crypt::encryptString($userCoupon->coupon_id) }}" data-vc="{{ Crypt::encryptString($userCoupon->id) }}">
                                                <button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2  w-100">ABOUT THIS COUPON</button>
                                            </a>
                                        </div>
                                        <div class="col-lg-6 col-mb-6 col-12 mb-md-0 mb-3 pr-md-3  pl-md-3 pl-5 pr-5">
                                            @if ($userCoupon->type == 'voucher')
                                                <button class="btn btn-pink btn-oval btn-addcart-popup w-100 use_cuopon" data-id="{{ Crypt::encryptString($userCoupon->voucher_id) }}">USE THIS COUPON</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            {{-- MANUAL COUPON --}}
                            @if ($userCoupon->used == 0)
                                <div class="col-md-6 position-relative pt-3 mb-4">
                                    @if ($userCoupon->created_at->isToday())
                                        <div class="new-coupon position-absolute"><img src="{{asset('assets/img/new.png')}}" alt=""></div>
                                    @endif
                                    <div class="coupon mb-3">
                                        <img src="{{asset($userCoupon->coupon->images)}}" alt="">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-mb-6 col-12 mb-md-0 mb-3 pr-md-3  pl-md-3 pl-5 pr-5">
                                            <a href="#" class="coupon_detail" data-id="{{ Crypt::encryptString($userCoupon->coupon_id) }}" data-vc="{{ Crypt::encryptString($userCoupon->id) }}">
                                                <button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2  w-100">ABOUT THIS COUPON</button>
                                            </a>
                                        </div>
                                        <div class="col-lg-6 col-mb-6 col-12 mb-md-0 mb-3 pr-md-3  pl-md-3 pl-5 pr-5">
                                            <a href="{{ route('frontend.user.use.manual.coupon', Crypt::encryptString($userCoupon->id)) }}" class="use_manual_cuopon">
                                                <button class="btn btn-pink btn-oval btn-addcart-popup w-100" >USE THIS COUPON</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                   @endforeach

                   {{-- <div class="col-md-6 position-relative pt-3  mb-4">
                       <div class="ket_coupon position-absolute bg-abu text-truncate text-center">EXPIRED SOON...</div>
                       <div class="coupon mb-3">
                            <img src="{{asset('assets/img/coupon.png')}}" alt="">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a href=""><button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2  w-100">ABOUT THIS COUPON</button></a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-pink btn-oval btn-addcart-popup w-100">USE THIS COUPON</button>
                            </div>
                        </div>
                   </div> --}}

                </div>
            </div>
        </div>
    </div>
</div>
@include('frontend.pages.account.includes.modal_about_coupon')
@endsection

@section('footer')
@include('frontend/includes/footer')
@endsection

@section('custom_js')
<script>
$(document).ready(function () {
    $("body").on('click', '.coupon_detail', function (e) {
        e.preventDefault();
        loadingStart();

        var coupon  = $(this).data('id');
        var vc      = $(this).data('vc');

        $.ajax({
            type: 'POST',
            url: "{{ route('frontend.user.get.coupon') }}",
            data:
            {
                "coupon": coupon,
                "vc": vc,
                "_token" : "{{ csrf_token() }}"
            },
            success: function (respond) {
                console.log(respond.message);
                loadingEnd();
                $('#modal_coupon_container').html(respond.message);
                $('#modal_aboutcoupon').modal('show');
            }
        });
    });

    $("body").on('click', '.use_manual_cuopon', function (e) {
        loadingStart();
    });

    $("body").on('click', '.use_cuopon', function (e) {
        e.preventDefault();

        loadingStart();

        var coupon = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: "{{ route('frontend.user.use.coupon') }}",
            data:
            {
                "coupon": coupon,
                "_token" : "{{ csrf_token() }}"
            },
            success: function (respond) {
                loadingEnd();
                if (respond.status) {
                    $('#modal_aboutcoupon').modal('hide');
                    swal("Success", respond.message, "success");
                } else {
                    swal("Error", respond.message, "error");
                }
            }
        });
    });
});
</script>
@endsection
