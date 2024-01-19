@extends('frontend/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
<style>
#clipboard {
	font-size: 18px;
}
</style>
@endsection

@section('content')

{{-- GOPAY --}}
@if ($order->payment_method == 'gopay')
	@if ($order->status == 'pending')
		<div class="content-area mb-5 pt-4 order-summary">
			<div class="container container-product ">
				<div class="row">
					<div class="col-md-7 mx-auto">
						<h3 class="mb-4 bold-300">Finish Payment</h3>
						<p class="mb-3">
						</p>
						<p class="bold-700">
							Your time to finish the payment
						</p>
						<div class="row align-items-end mb-4">
							<div class="col-md-6">
								<h4 id="days" class="d-none"></h4>
								<div class="row p-0 countdown">
									<div class="col-4">
										<h4 id="hours"></h4>
										<h4 class="titikdua">:</h4>
										<p class="text-center">
											Hours
										</p>
									</div>

									<div class="col-4">
										<h4 id="minutes"></h4>
										<h4 class="titikdua">:</h4>
										<p class="text-center">
											Minutes
										</p>
									</div>

									<div class="col-4">
										<h4 id="seconds"></h4>
										<p class="text-center">
											Seconds
										</p>
									</div>

									<div class="col-12">
										<p class="font-italic text-small mt-2">
											(Before {{ \Carbon\Carbon::parse($order->created_at)->format('d F Y') }} {{ \Carbon\Carbon::parse($order->created_at)->addMinutes(15)->format('H:i') }} WIB)
										</p>
									</div>
								</div>
							</div>
							<div class="col-12 float-left mt-3 cl-abu label-12">
								<p>
									* Make sure not to inform your payment evidence and data to any party except Talasi
									{{-- * Pastikan untuk tidak menginformasikan bukti dan data pembayaran kepada pihak manapun kecuali Talasi --}}
								</p>
							</div>
						</div>
						<p class="bold-700">
							Scan QR Code :
						</p>
						<div class="col-md-6">
							<img style="max-width: 100%;" src="{{ $qrcode }}" alt="">
						</div>
						<p class="mt-2">
							{{-- a/n Talasi Bumi Tabanan Bali --}}
						</p>

						<div class="mt-md-5 pt-md-5 mt-2 pt-2 border-top border-grey">
							<div class="row align-items-end">
								<div class="col-md-6">
									<p class="bold-700">
										Amount to be paid
									</p>
									<h5 class="total-color bold-700 mb-3">{{ $order->multi ? currency_format($grand_total) : currency_format($order->grand_total) }}</h5>
									<span id="nominal" class="d-none">413111</span>
								</div>
							</div>
							<div class="w-100 float-left mt-3 cl-abu label-12">
								{{-- <p>Silahkan melakukan konfirmasi apabila anda telah menyelesaikan pembayaran.</p> --}}
								<a href="{{ route('frontend.product.purchase') }}"><button type="button" class="btn btn-primary btn-send-about">Continue shopping</button></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endif

	@if ($order->status == 'paid')
		<div class="content-area">
			<div class="container container-product">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-12 col-12 offset-md-3 offset-lg-3">
						<div class="row">
							<div class="col-12 desc-faq">
								<h3 class="result mb-4 pt-md-5 pt-0">Succesfull Payment</h3>

								<p class="font-weight-bold">
									Thank You, We have accepted your payment for order #{{ $order->order_code }}
								</p>
								<p>
									We will process and delivering your item ASAP.
								</p>
								<p>
									Please check your email for order updates.
								</p>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endif

	@if ($order->status == 'failed')
		<div class="content-area">
			<div class="container container-product">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-12 col-12 offset-md-3 offset-lg-3">
						<div class="row">
							<div class="col-12 desc-faq">
								<h3 class="result mb-4 pt-md-5 pt-0">Finish Payment</h3>

								<p class="font-weight-bold">
									We are sorry, Your order #{{ $order->order_code }} automatically cancelled by our system
								</p>
								<p>
									You fail to completed the payment.
								</p>
								<p>
									Please re-order and finish your payment.
									{{-- Silahkan memesan kembali sesuai prosedur yang berlaku dan menyelesaikan pembayaran sesuai dengan petunjuk --}}
								</p>
								{{-- <p><a href="{{  }}">Klik di sini</a> untuk memesan kembali dengan daftar produk yang sama.</p> --}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endif

@else
	@if ($order->status == 'failed')
		<div class="content-area">
			<div class="container container-product">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-12 col-12 offset-md-3 offset-lg-3">
						<div class="row">
							<div class="col-12 desc-faq">
								<h3 class="result mb-4 pt-md-5 pt-0">Finish Payment</h3>

								<p class="font-weight-bold">
									We are sorry, Your order #{{ $order->order_code }} automatically cancelled by our system
								</p>
								<p>
									You fail to completed the payment.
								</p>
								<p>
									Please re-order and finish your payment.
									{{-- Silahkan memesan kembali sesuai prosedur yang berlaku dan menyelesaikan pembayaran sesuai dengan petunjuk --}}
								</p>
								{{-- <p><a href="{{  }}">Klik di sini</a> untuk memesan kembali dengan daftar produk yang sama.</p> --}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@else

	@if ($order->payment_method == 'reward_point' && $order->status == 'paid')
		<div class="content-area mb-5 pt-4 order-summary">
			<div class="container container-product ">
				<div class="row">
					<div class="col-md-7 mx-auto">
						<h3 class="mb-4 bold-300">Completed Payment</h3>
						<p>Thank you for your payment, we will process your order ASAP.</p>

						<div class="mt-md-5 pt-md-5 mt-2 pt-2 border-top border-grey">
							<div class="row align-items-end">
								<div class="col-md-6">
									<p class="bold-700">
										Amount paid
									</p>

									<h5 class="total-color bold-700 mb-3">{{ currency_format($order->grand_total) }}</h5>
									<span id="nominal" class="d-none">413111</span>
								</div>
							</div>
							<div class="w-100 float-left mt-3 cl-abu label-12">
								{{-- <p>Silahkan melakukan konfirmasi apabila anda telah menyelesaikan pembayaran.</p> --}}
								<a href="{{ route('frontend.product.purchase') }}"><button type="button" class="btn btn-primary btn-send-about">Continue shopping</button></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	@else
		<div class="content-area mb-5 pt-4 order-summary">
			<div class="container container-product ">
				<div class="row">
					<div class="col-md-7 mx-auto">
						<h3 class="mb-4 bold-300">Finish Payment</h3>
						<p class="mb-3">
							Please finish your payment before there is no stock left.
							{{-- Segera selesaikan pembayaran Anda sebelum stok habis. --}}
						</p>
						<p class="bold-700">
							Your time to finish the payment
							{{-- Sisa waktu pembayaran Anda --}}
						</p>
						<div class="row align-items-end mb-4">
							<div class="col-md-6">
								<h4 id="days" class="d-none"></h4>
								<div class="row p-0 countdown">
									<div class="col-4">
										<h4 id="hours"></h4>
										<h4 class="titikdua">:</h4>
										<p class="text-center">
											Hours
											{{-- Jam --}}
										</p>
									</div>

									<div class="col-4">
										<h4 id="minutes"></h4>
										<h4 class="titikdua">:</h4>
										<p class="text-center">
											Minutes
											{{-- Menit --}}
										</p>
									</div>

									<div class="col-4">
										<h4 id="seconds"></h4>
										<p class="text-center">
											Seconds
											{{-- Detik --}}
										</p>
									</div>

									<div class="col-12">
										<p class="font-italic text-small mt-2">
											(Before {{ \Carbon\Carbon::parse($order->response->payValidDt)->format('d F Y') }} {{ \Carbon\Carbon::parse($order->response->payValidTm)->format('H:i') }} WIB)
										</p>
									</div>
								</div>
							</div>
							<div class="col-12 float-left mt-3 cl-abu label-12">
								<p>
									* Make sure not to inform your payment evidence and data to any party except Talasi
									{{-- * Pastikan untuk tidak menginformasikan bukti dan data pembayaran kepada pihak manapun kecuali Talasi --}}
								</p>
							</div>
						</div>
						<p class="bold-700">
							@switch($order->payment_method)
								@case('virtual_account')
									Transfer to Virtual Account No. :
									@break
									@case('cvs')
									Your Payment Code :
									@break
								@default
								Transfer to Virtual Account No. :
							@endswitch
							{{-- Transfer pembayaran ke nomor virtual account : --}}
						</p>
						<div class="bank-account d-inline-flex">
							<img src="{{ asset('assets/img/bank/' . $order->bank . '.png') }}" alt="">
							@switch($order->payment_method)
								@case('virtual_account')
									<p class="mt-1" id="clipboard">{{ $order->multi ? $order->multiResponse->vacctNo : $order->response->vacctNo }}</p>
									@break
									@case('cvs')
									<p class="mt-1" id="clipboard">{{ $order->multi ? $order->multiResponse->payNo : $order->response->payNo }}</p>
									@break
								@default
								<p class="mt-1" id="clipboard">{{ $order->multi ? $order->multiResponse->vacctNo : $order->response->vacctNo }}</p>
							@endswitch
						</div>
						<p class="mt-2">
							{{-- a/n Talasi Bumi Tabanan Bali --}}
						</p>
						@switch($order->payment_method)
							@case('virtual_account')
								<a href="#" onclick="copyToClipboard('#clipboard')" class="text-small link-copy" title="">Copy VA No to Clipboard</a>
								@break
								@case('cvs')
								<a href="#" onclick="copyToClipboard('#clipboard')" class="text-small link-copy" title="">Copy Payment Code to Clipboard</a>
								@break
							@default
							<a href="#" onclick="copyToClipboard('#clipboard')" class="text-small link-copy" title="">Salin No. Rek</a>
						@endswitch

						<div class="mt-md-5 pt-md-5 mt-2 pt-2 border-top border-grey">
							<div class="row align-items-end">
								<div class="col-md-6">
									<p class="bold-700">
										Amount to be paid
									</p>

									<h5 class="total-color bold-700 mb-3">{{ $order->multi ? currency_format($order->multiRegistration->amt) : currency_format($order->registration->amt) }}</h5>
									<span id="nominal" class="d-none">413111</span>
								</div>
							</div>
							<div class="w-100 float-left mt-3 cl-abu label-12">
								{{-- <p>Silahkan melakukan konfirmasi apabila anda telah menyelesaikan pembayaran.</p> --}}
								<a href="{{ route('frontend.product.purchase') }}"><button type="button" class="btn btn-primary btn-send-about">Continue shopping</button></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endif
	@endif
@endif

@endsection

@section('footer')
@include('frontend/includes/footer')
@endsection

@section('custom_js')

<script>

function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}



// ------------ batas


// Set the date we're counting down to
@php
if ($order->payment_method == 'gopay') {
	$date = \Carbon\Carbon::parse($order->created_at)->addMinutes(15);
} else {
	$date = \Carbon\Carbon::parse($order->created_at)->addHours(24);
	// if ($order->multi) {
	// 	$date = \Carbon\Carbon::parse($order->multiResponse->payValidDt . $order->multiResponse->payValidTm);
	// } else {
	// 	$date = \Carbon\Carbon::parse($order->response->payValidDt . $order->response->payValidTm);
	// }
}
@endphp
var countDownDate = new Date("{{ $date->format('m d, Y H:i:s') }}").getTime();
var dateNow = Date.now();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Output the result in an element with id="demo"
 if (dateNow > countDownDate){
	hours = '00';
	minutes = '00';
	seconds = '00';
 }
  document.getElementById("days").innerHTML = days;
  document.getElementById("hours").innerHTML = hours;
  document.getElementById("minutes").innerHTML = minutes;
  document.getElementById("seconds").innerHTML = seconds;

  // If the count down is over, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>

@endsection
