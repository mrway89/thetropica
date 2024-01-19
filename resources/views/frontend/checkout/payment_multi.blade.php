@extends('frontend/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-area mb-5 pt-0 pt-md-4 order-summary">
	<div class="container container-product pt-md-5 pt-0">
		<div class="row mb-md-5 mb-2">
			<div class="col-md-8">
				<h3>Payment Method</h3>
			</div>

			<div class="col-md-3 d-md-flex d-none">
				<h3>Summary</h3>
			</div>
		</div>
		<div class="row">

			<div class="col-md-3 pr-md-5 pr-auto d-md-none d-flex mb-3">
				<div id="total-payment-1-1" class="w-100">
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<p class="bold-700 float-left mb-1">Total Payment</p>
						<p class="bold-700 float-right mb-1">{{ currency_format($cart->grand_total) }}</p>
					</div>
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<button type="button" class="btn btn-link float-left text-small p-0" id="open-details-1">Details</button>
					</div>
				</div>

				<div id="total-payment-2-1">
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<p class="bold-500 float-left mb-1">Total Price</p>
						<p class="bold-700 float-right mb-1">{{ currency_format($cart->total_price) }}</p>
					</div>
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<p class="bold-500 float-left mb-1">Shipping Fee</p>
						<p class="bold-700 float-right mb-1">{{ currency_format($cart->courier_cost) }}</p>
					</div>
					@if ($cart->insurance)
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<p class="bold-500 float-left mb-1">Shipping Insurance</p>
						<p class="bold-700 float-right mb-1">{{ currency_format($cart->insurance) }}</p>
					</div>
					@endif
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<p class="bold-700 float-left mb-1">Total Payment</p>
						<p class="bold-700 float-right mb-1 total-color">{{ currency_format($cart->grand_total) }}</p>
					</div>
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<button type="button" class="btn btn-link float-left text-small p-0" id="close-details-1">Close Details</button>
					</div>
				</div>
			</div>


			<div class="col-md-3">
				<p class="bold-700">Recommended</p>
				<!-- start -->

				<div class="accordion" id="payment-method">
				  <div class="card">
				    <div class="card-header bg-white d-flex" id="klikbca" data-toggle="collapse" data-target="#klikbca-area" aria-expanded="true" aria-controls="klikbca-area">
				      <img src="{{ asset('assets/img/bank/klikbca.jpg') }}" class="img-bank-logo mr-3" alt="">
				      <div class="bank-text-area">
					      <p class="bold-700 mb-0">KlikBCA</p>
					      <p class="mb-0">PT. Talasi</p>
					  </div>
				    </div>

				    <div id="klikbca-area" class="collapse" aria-labelledby="klikbca" data-parent="#payment-method">
				      <div class="card-body">
				        <div class="d-flex justify-content-between">
				        	<div class="left">
				        		<p>KlikBCA</p>
				        	</div>
				        	<div class="right">
				        		<img src="{{ asset('assets/img/bank/klikbca.jpg') }}" class="img-bank-logo object-top" alt="">
				        	</div>
				        </div>
				        <!-- <div class="d-flex justify-content-between">
				        	<div class="left">
				        		<p class="mb-0">No.Rek: <span class="bold-700">9000008888777</span></p>
				        		<p class="mb-0">a/n <span class="bold-700">Joseph Nathaniel</span></p>
				        	</div>
				        	<div class="right align-self-end">
				        		<a href="#" title="">Change</a>
				        	</div>
				        </div> -->
				        <button class="checkout btn-send-about w-100 mt-3 mb-2">PAY</button>
				      </div>
				    </div>
				  </div>

				  <div class="card">
				    <div class="card-header bg-white d-flex" id="mandiri" data-toggle="collapse" data-target="#mandiri-area" aria-expanded="true" aria-controls="mandiri-area">
				      <img src="{{ asset('assets/img/bank/mandiri.jpg') }}" class="img-bank-logo mr-3" alt="">
				      <div class="bank-text-area">
					      <p class="bold-700 mb-0">Bank Mandiri</p>
					      <p class="mb-0">PT. Talasi</p>
					  </div>
				    </div>

				    <div id="mandiri-area" class="collapse" aria-labelledby="mandiri" data-parent="#payment-method">
				      <div class="card-body">
				        <div class="d-flex justify-content-between">
				        	<div class="left">
				        		<p>Transfer Bank Mandiri</p>
				        	</div>
				        	<div class="right">
				        		<img src="{{ asset('assets/img/bank/mandiri.jpg') }}" class="img-bank-logo object-top" alt="">
				        	</div>
				        </div>
				        <!-- <div class="d-flex justify-content-between">
				        	<div class="left">
				        		<p class="mb-0">No.Rek: <span class="bold-700">9000008888777</span></p>
				        		<p class="mb-0">a/n <span class="bold-700">Joseph Nathaniel</span></p>
				        	</div>
				        	<div class="right align-self-end">
				        		<a href="#" title="">Change</a>
				        	</div>
				        </div> -->
				        <button class="checkout btn-send-about w-100 mt-3 mb-2">PAY</button>
				      </div>
				    </div>
				  </div>


				</div>

				<!-- end -->
			</div>

			<div class="col-md-4 offset-0 offset-md-1 pt-4 pt-md-0">
				<p class="bold-700">Select Payment Method</p>
				<div class="dropdown open">
					<button class="btn btn-selectpayment bg-white w-79 text-left dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Select Payment Method
					</button>
					<div class="dropdown-menu w-79 p-3" aria-labelledby="dropdownMenu1">
						{{-- <p class="bold-700">Bank Transfer (Manual Verification)</p>

						<a href="#">
							<div class="d-flex" href="#">
								<img src="{{ asset('assets/img/bank/bca.png') }}" class="img-bank-logo-small mr-3" alt="">
								<p class="bold-500 pt-1 text-dark">Bank BCA</p>
							</div>
						</a>

						<a href="#">
							<div class="d-flex" href="#">
								<img src="{{ asset('assets/img/bank/mandiri.jpg') }}" class="img-bank-logo-small mr-3" alt="">
								<p class="bold-500 pt-1 text-dark">Bank MANDIRI</p>
							</div>
						</a>

						<a href="#">
							<div class="d-flex" href="#">
								<img src="{{ asset('assets/img/bank/bni.png') }}" class="img-bank-logo-small mr-3" alt="">
								<p class="bold-500 pt-1 text-dark">Bank BNI</p>
							</div>
						</a>

						<a href="#">
							<div class="d-flex" href="#">
								<img src="{{ asset('assets/img/bank/bri.png') }}" class="img-bank-logo-small mr-3" alt="">
								<p class="bold-500 pt-1 text-dark">Bank BRI</p>
							</div>
						</a>

						<a href="#">
							<div class="d-flex" href="#">
								<img src="{{ asset('assets/img/bank/cimb.png') }}" class="img-bank-logo-small mr-3" alt="">
								<p class="bold-500 pt-1 text-dark">Bank CIMB Niaga</p>
							</div>
						</a> --}}

						<p class="bold-700 mt-2">Credit Card (Automatic Verification)</p>

						<a href="{{ route('frontend.cart.payment.cc') }}">
							<div class="d-flex" href="#">
								<img src="{{ asset('assets/img/icon-footer/credit-card.png') }}" class="img-bank-logo-small mr-3" alt="">
								<p class="bold-500 pt-1 text-dark">Credit Card</p>
							</div>
						</a>

						<p class="bold-700 mt-2">Virtual Account (Automatic Verification)</p>

						<a href="{{ route('frontend.cart.payment.va', 'bca') }}">
							<div class="d-flex" href="#">
								<img src="{{ asset('assets/img/bank/bca.png') }}" class="img-bank-logo-small mr-3" alt="">
								<p class="bold-500 pt-1 text-dark">BCA Virtual Account</p>
							</div>
						</a>
						<a href="{{ route('frontend.cart.payment.va', 'mandiri') }}">
							<div class="d-flex" href="#">
								<img src="{{ asset('assets/img/bank/mandiri.jpg') }}" class="img-bank-logo-small mr-3" alt="">
								<p class="bold-500 pt-1 text-dark">Mandiri Virtual Account</p>
							</div>
						</a>
						<a href="{{ route('frontend.cart.payment.va', 'bni') }}">
							<div class="d-flex" href="#">
								<img src="{{ asset('assets/img/bank/bni.png') }}" class="img-bank-logo-small mr-3" alt="">
								<p class="bold-500 pt-1 text-dark">BNI Virtual Account</p>
							</div>
						</a>
						<a href="{{ route('frontend.cart.payment.va', 'bri') }}">
							<div class="d-flex" href="#">
								<img src="{{ asset('assets/img/bank/bri.png') }}" class="img-bank-logo-small mr-3" alt="">
								<p class="bold-500 pt-1 text-dark">BRI Virtual Account</p>
							</div>
						</a>

						<p class="bold-700 mt-2">Convenience Store (Automatic Verification)</p>
						{{-- <a href="{{ route('frontend.cart.payment.cvs', 'indomaret') }}">
							<div class="d-flex" href="#">
								<img src="{{ asset('assets/img/bank/indomaret.png') }}" class="img-bank-logo-small mr-3" alt="">
								<p class="bold-500 pt-1 text-dark">Indomaret</p>
							</div>
						</a> --}}
						<a href="{{ route('frontend.cart.payment.cvs', 'alfamart') }}">
							<div class="d-flex" href="#">
								<img src="{{ asset('assets/img/bank/alfamart.png') }}" class="img-bank-logo-small mr-3" alt="">
								<p class="bold-500 pt-1 text-dark">Alfamart</p>
							</div>
						</a>

					</div>
				</div>
			</div>

			<div class="col-md-3 pr-md-5 pr-auto d-md-flex d-none">
				<div id="total-payment-1" class="w-100">
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<p class="bold-700 float-left mb-1">Total Payment</p>
						<p class="bold-700 float-right mb-1">{{ currency_format($cart->grand_total) }}</p>
					</div>
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<button type="button" class="btn btn-link float-left text-small p-0" id="open-details">Details</button>
					</div>
				</div>

				<div id="total-payment-2">
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<p class="bold-500 float-left mb-1">Total Price</p>
						<p class="bold-700 float-right mb-1">{{ currency_format($cart->total_price) }}</p>
					</div>
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<p class="bold-500 float-left mb-1">Shipping Fee</p>
						<p class="bold-700 float-right mb-1">{{ currency_format($cart->courier_cost) }}</p>
					</div>
					@if ($cart->insurance)
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<p class="bold-500 float-left mb-1">Shipping Insurance</p>
						<p class="bold-700 float-right mb-1">{{ currency_format($cart->insurance) }}</p>
					</div>
					@endif
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<p class="bold-700 float-left mb-1">Total Payment</p>
						<p class="bold-700 float-right mb-1 total-color">{{ currency_format($cart->grand_total) }}</p>
					</div>
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<button type="button" class="btn btn-link float-left text-small p-0" id="close-details">Close Details</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('footer')
@include('frontend/includes/footer')
@endsection

@section('custom_js')

<script>

$("#open-details").click(function(){
	$("#total-payment-1").hide();
	$("#total-payment-2").show(200);
});

$("#close-details").click(function(){
	$("#total-payment-2").hide();
	$("#total-payment-1").show(200);
});

$("#open-details-1").click(function(){
	$("#total-payment-1-1").hide();
	$("#total-payment-2-1").show(200);
});

$("#close-details-1").click(function(){
	$("#total-payment-2-1").hide();
	$("#total-payment-1-1").show(200);
});

$(document).ready(function() {

	$("#total-payment-2").hide();
	$("#total-payment-2-1").hide();

    $('.collapse').on('shown.bs.collapse', function () {
        $(this).prev().addClass('d-none');
        $(this).prev().removeClass('d-flex');
    });

    $('.collapse').on('hidden.bs.collapse', function () {
        $(this).prev().removeClass('d-none');
        $(this).prev().addClass('d-flex');
    });

});

</script>

@endsection
