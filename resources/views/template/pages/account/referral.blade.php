@extends('template/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="content-area">
	<div class="container container-product">
		<div class="row">
            <div class="col-md-9 col-sm-12 col-12 offset-md-3 offset-0 pt-3">
				<h3 class="bold-300 mb-4 pt-5">Referral</h3>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-6">
				@include('template/pages/account/includes/sidemenu')
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-6 pr-5">
                        <form action="">
                            <p class="bold-700 mb-2">Invite orthers to join Talasi family: </p>
                            <div class="desc-talasi-point">
                                <p>
                                    Undang saudara saudari, teman-teman dan kerabat Anda untuk bergabung dengan keluarga Talasi. Talasi Coupon spesial akan diberikan kepada Anda dan
                                    pihak yang Anda undang*. Let's explore the planet!
                                </p>
                            </div>
                            <input type="text" class="form-control label-14 rounded-0 mb-4"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="Input email here" name="email" required/>
                            <button type="button" class="btn btn-pink btn-oval btn-addcart-popup w-100 mb-5">SUBMIT REFERRAL CODE</button>
                        </form>
                        <div class="row d-flex justify-content-start mb-5">
                            <div class="desc-talasi-point col-md-5">Atau undang via media sosial:</div>
                            <div class="col-md-7 d-flex align-items-center">
                                <ul class="sosmed-referral w-100 pl-0 mb-0 d-flex justify-content-start ">
                                    <li><a href=""><img src="{{asset('assets/img/facebook.png')}}" alt=""></a></li>
                                    <li><a href=""><img src="{{asset('assets/img/twitter.png')}}" alt=""></a></li>
                                    <li><a href=""><img src="{{asset('assets/img/google.png')}}" alt=""></a></li>
                                    <li><a href=""><img src="{{asset('assets/img/linkedin.png')}}" alt=""></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="desc-talasi-point">
                            <p><i>*Talasi Coupon spesial akan diberikan ketika pihak yang diundang telah berhasil mendaftarkan akun Talasi dan memasukkan kode referral.</i></p>
                            <p><a href="">Klik di sini</a> untuk mendapatkan informasi yang lebih detail mengenai sistem referral Talasi.</p>
                        </div>
                    </div>
                    <div class="col-md-6 pl-5">
                        <form action="">
                            <p class="bold-700 mb-2">I got referral code! </p>
                            <div class="desc-talasi-point">
                                <p> Selamat! Silahkan memasukkan kode referensi yang Anda dapatkan pada form di bawah ini untuk mendapatkan Talasi Coupon spesial.</p>
                            </div>
                            <input type="text" class="form-control label-14 rounded-0 mb-4" placeholder="Input referral code" name="email" required/>
                            <button type="button" data-toggle="modal" data-target="#modal_codesuccess" class="btn btn-pink btn-oval btn-addcart-popup w-100">SUBMIT REFERRAL CODE</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('template/pages/account/includes/modal_codesuccess')
@endsection

@section('footer')
@include('template/includes/footer')
@endsection

@section('custom_js')

@endsection
