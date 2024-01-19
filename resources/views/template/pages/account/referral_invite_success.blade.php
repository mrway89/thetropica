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
                        <div class="border-top-mb pt-mb-0 pt-3">
                            <p class="bold-700 mb-2">Invitation Success </p>
                        </div>
                        <div class="desc-talasi-point">
                            <p>
                                Anda telah berhasil mengundang kerabat untuk bergabung dalam Talasi family.
                                Talasi Coupon spesial akan diberikan ketika pihak yang diundang telah berhasil
                                mendaftarkan akun Talasi dan memasukkan kode referral.
                            </p>
                            <p>
                                <a href="">Klik di sini</a> untuk kembali ke halaman Referral.
                            </p>
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
