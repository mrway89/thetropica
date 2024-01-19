@extends('template/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="content-area">
	<div class="container container-product">
		<div class="row">
            <div class="col-md-9 col-sm-12 col-12 offset-md-3 offset-0 pt-3">
				<h3 class="bold-300 mb-4 pt-5">Talasi Point</h3>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-6">
				@include('template/pages/account/includes/sidemenu')
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-3">
                        <p class="bold-700 mb-2">My Talasi Points: </p>
                        <div class="point">300</div>
                    </div>
                    <div class="col-md-9 desc-talasi-point">
                        <p>Jumlah Talasi Poin Anda merupakan akumulasi dari poin yang didapatkan dari:
                            <ul>
                                <li>Membeli produk-produk Talasi, baik dari website Talasi maupun di toko terderkat.</li>
                                <li>Melakukan proses refferal (informasi lebih lanjut dapat dilihat di halaman <a href="">FAQ</a></li>
                                <li>Promo terbatas lain yang diberikan oleh Talasi</li>
                            </ul>
                        </p>
                        <p>Anda akan mendapatkan notifikasi setiap kali Anda berhasil memberoleh Talasi Poin(daftar perolehan poin dapat dilihat di halaman <a href="">Notifikasi</a>)</p>
                    </div>
                </div>
                <div class="mb-5 desc-talasi-point">
                   <p>Anda dapat menukarkan Talasi Point Anda dengan Talasi Coupon yang tersedia di bawah ini.
                    Talasi Coupon yang telah Anda dapatkan dapat dilihat di halaman <a href="">My Coupon</a></p> 
                </div>
               <div class="row">
                   <div class="col-md-6 position-relative pt-3 mb-5">
                        <div class="ket_coupon position-absolute bg-orange text-truncate text-center">50 Talasi Point</div>
                       {{-- <div class="new-coupon position-absolute"><img src="{{asset('assets/img/new.png')}}" alt=""></div> --}}
                       <div class="coupon mb-3">
                            <img src="{{asset('assets/img/coupon.png')}}" alt="">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a href=""><button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2  w-100">ABOUT THIS COUPON</button></a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-pink btn-oval btn-addcart-popup w-100">GET THIS COUPON</button>
                            </div>
                        </div>
                   </div>

                   <div class="col-md-6 position-relative pt-3  mb-5">
                       <div class="ket_coupon position-absolute bg-orange text-truncate text-center">50 Talasi Point</div>
                       <div class="coupon mb-3">
                            <img src="{{asset('assets/img/coupon.png')}}" alt="">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a href=""><button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2  w-100">ABOUT THIS COUPON</button></a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-pink btn-oval btn-addcart-popup w-100">GET THIS COUPON</button>
                            </div>
                        </div>
                   </div>

                   <div class="col-md-6 position-relative pt-3  mb-5">
                        <div class="ket_coupon position-absolute bg-orange text-truncate text-center">50 Talasi Point</div>
                       <div class="coupon mb-3">
                            <img src="{{asset('assets/img/coupon.png')}}" alt="">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a href=""><button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2  w-100">ABOUT THIS COUPON</button></a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-pink btn-oval btn-addcart-popup w-100">GET THIS COUPON</button>
                            </div>
                        </div>
                   </div>

                   <div class="col-md-6 position-relative pt-3  mb-5">
                        <div class="ket_coupon position-absolute bg-orange text-truncate text-center">50 Talasi Point</div>
                       <div class="coupon mb-3">
                            <img src="{{asset('assets/img/coupon.png')}}" alt="">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a href=""><button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2  w-100">ABOUT THIS COUPON</button></a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-pink btn-oval btn-addcart-popup w-100">GET THIS COUPON</button>
                            </div>
                        </div>
                   </div>

                   <div class="col-md-6 position-relative pt-3  mb-5">
                        <div class="ket_coupon position-absolute bg-orange text-truncate text-center">50 Talasi Point</div>
                       <div class="coupon mb-3">
                            <img src="{{asset('assets/img/coupon.png')}}" alt="">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a href=""><button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2  w-100">ABOUT THIS COUPON</button></a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-pink btn-oval btn-addcart-popup w-100">GET THIS COUPON</button>
                            </div>
                        </div>
                   </div>

                   <div class="col-md-6 position-relative pt-3  mb-5">
                        <div class="ket_coupon position-absolute bg-orange text-truncate text-center">50 Talasi Point</div>
                       <div class="coupon mb-3">
                            <img src="{{asset('assets/img/coupon.png')}}" alt="">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a href=""><button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2  w-100">ABOUT THIS COUPON</button></a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-pink btn-oval btn-addcart-popup w-100">GET THIS COUPON</button>
                            </div>
                        </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
@include('template/includes/footer')
@endsection

@section('custom_js')

@endsection
