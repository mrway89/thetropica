@extends('template/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-area">
	<div class="container container-product">
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-12 col-12 offset-md-3 offset-lg-3">
                <div class="row">
                   <div class="col-12 desc-faq">
                        <h3 class="result mb-4 pt-md-5 pt-0">Finish Payment</h3>

                        <p class="font-weight-bold">Maaf, pesanan Anda dengan kode pemesanan #431093021 dibatalkan secara otomatis
                        </p>
                        <p>Anda tidak berhasil menyelesaikan pembayaran dalam jangka waktu yang telah diberikan
                        </p>
                        <p>Silahkan memesan kembali sesuai prosedur yang berlaku dan menyelesaikan pembayaran sesuai dengan petunjuk
                        </p>
                        <p><a href="#">Klik di sini</a> untuk memesan kembali dengan daftar produk yang sama.</p>
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
<script src="{{asset('assets/js/count_qty.js')}}"></script>
<script>
	$('#select-shoppingguide').on('change', function (e) {
	    $('#tab-shoppingguide li a').eq($(this).val()).tab('show'); 
	});
</script>	

@endsection
