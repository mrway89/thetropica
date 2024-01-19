@extends('template/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-area mb-5 pt-4 order-summary">
	<div class="container container-product ">
		<div class="row">
			<div class="col-md-7 mx-auto">
				<h3 class="mb-4 bold-300">Finish Payment</h3>
				<p class="mb-3">Segera selesaikan pembayaran Anda sebelum stok habis.</p>
				<p class="bold-700">Sisa waktu pembayaran Anda</p>
				<div class="row align-items-end mb-4">
					<div class="col-md-6">
						<h4 id="days" class="d-none"></h4>
						<div class="row p-0 countdown">
							<div class="col-4">
								<h4 id="hours"></h4>
								<h4 class="titikdua">:</h4>
								<p class="text-center">Jam</p>
							</div>

							<div class="col-4">
								<h4 id="minutes"></h4>
								<h4 class="titikdua">:</h4>
								<p class="text-center">Menit</p>
							</div>

							<div class="col-4">
								<h4 id="seconds"></h4>
								<p class="text-center">Detik</p>
							</div>

							<div class="col-12">
								<p class="font-italic text-small mt-2">(Sebelum Sabtu 23 Februari 2019 pukul 10.00 WIB)</p>
							</div>
						</div>
					</div>
					<div class="col-12 float-left mt-3 cl-abu label-12">
						<p>* Pastikan untuk tidak menginformasikan bukti dan data pembayaran kepada pihak manapun kecuali Talasi</p>
					</div>
				</div>
				<p class="bold-700">Transfer pembayaran ke nomor rekening :</p>
				<div class="bank-account d-inline-flex">
					<img src="{{ asset('assets/img/bank/mandiri.jpg') }}" alt="">
					<p class="mt-1" id="clipboard">102 000 58686866</p>
				</div>
				<p class="mt-2">a/n Talasi Bumi Tabanan Bali</p>
				<a href="#" onclick="copyToClipboard('#clipboard')" class="text-small link-copy" title="">Salin No. Rek</a>

				<div class="mt-md-5 pt-md-5 mt-2 pt-2 border-top border-grey">
					<div class="row align-items-end">
						<div class="col-md-6">
							<p class="bold-700">
								Jumlah yang harus dibayar
							</p>

							<h5 class="total-color bold-700 mb-3">Rp 413.000</h5>
							<span id="nominal" class="d-none">413111</span>
						</div>
					</div>
					<div class="w-100 float-left mt-3 label-12">
						<p>Silahkan melakukan konfirmasi apabila anda telah menyelesaikan pembayaran.</p>
						<button type="button" class="btn btn-primary btn-send-about">SAYA TELAH MENYELESAIKAN PEMBAYARAN</button>
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
var countDownDate = new Date("Apr 16, 2019 13:26:59").getTime();
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
