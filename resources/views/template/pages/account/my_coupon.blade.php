@extends('template/layouts/main')

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
				@include('template/pages/account/includes/sidemenu')
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="mb-2">
                    <a href="">Klik di sini</a> untuk mendapatkan Talasi Coupon yang tersedia, atau 
                    masuk ke halaman <a href="">FAQ</a> untuk informasi lebih detail mengenai Talasi coupon.
                </div>
               <div class="row">
                   <div class="col-md-6 position-relative pt-3 mb-4">
                       <div class="new-coupon position-absolute"><img src="{{asset('assets/img/new.png')}}" alt=""></div>
                       <div class="coupon mb-3">
                            <img src="{{asset('assets/img/coupon.png')}}" alt="">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:;" data-toggle="modal" data-target="#modal_aboutcoupon"><button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2  w-100">ABOUT THIS COUPON</button></a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-pink btn-oval btn-addcart-popup w-100">USE THIS COUPON</button>
                            </div>
                        </div>
                   </div>

                   <div class="col-md-6 position-relative pt-3  mb-4">
                       <div class="ket_coupon position-absolute bg-abu text-truncate text-center">EXPIRED SOON...</div>
                       <div class="coupon mb-3">
                            <img src="{{asset('assets/img/coupon.png')}}" alt="">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:;"><button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2  w-100">ABOUT THIS COUPON</button></a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-pink btn-oval btn-addcart-popup w-100">USE THIS COUPON</button>
                            </div>
                        </div>
                   </div>

                   <div class="col-md-6 position-relative pt-3  mb-4">
                       {{-- <div class="ket_coupon position-absolute bg-abu text-truncate text-center">EXPIRED SOON...</div> --}}
                       <div class="coupon mb-3">
                            <img src="{{asset('assets/img/coupon.png')}}" alt="">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:;"><button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2  w-100">ABOUT THIS COUPON</button></a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-pink btn-oval btn-addcart-popup w-100">USE THIS COUPON</button>
                            </div>
                        </div>
                   </div>

                   <div class="col-md-6 position-relative pt-3  mb-4">
                       {{-- <div class="ket_coupon position-absolute bg-abu text-truncate text-center">EXPIRED SOON...</div> --}}
                       <div class="coupon mb-3">
                            <img src="{{asset('assets/img/coupon.png')}}" alt="">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:;"><button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2  w-100">ABOUT THIS COUPON</button></a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-pink btn-oval btn-addcart-popup w-100">USE THIS COUPON</button>
                            </div>
                        </div>
                   </div>

                   <div class="col-md-6 position-relative pt-3  mb-4">
                       {{-- <div class="ket_coupon position-absolute bg-abu text-truncate text-center">EXPIRED SOON...</div> --}}
                       <div class="coupon mb-3">
                            <img src="{{asset('assets/img/coupon.png')}}" alt="">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:;"><button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2  w-100">ABOUT THIS COUPON</button></a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-pink btn-oval btn-addcart-popup w-100">USE THIS COUPON</button>
                            </div>
                        </div>
                   </div>

                   <div class="col-md-6 position-relative pt-3  mb-4">
                       {{-- <div class="ket_coupon position-absolute bg-abu text-truncate text-center">EXPIRED SOON...</div> --}}
                       <div class="coupon mb-3">
                            <img src="{{asset('assets/img/coupon.png')}}" alt="">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:;"><button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2  w-100">ABOUT THIS COUPON</button></a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-pink btn-oval btn-addcart-popup w-100">USE THIS COUPON</button>
                            </div>
                        </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('template/pages/account/includes/modal_about_coupon')
@endsection

@section('footer')
@include('template/includes/footer')
@endsection

@section('custom_js')
@endsection
