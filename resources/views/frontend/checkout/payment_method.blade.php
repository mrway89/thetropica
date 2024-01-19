@extends('frontend/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
<style>
.open .dropdown-menu {
    height: 300px;
    overflow: auto;
}
</style>
@endsection

@section('content')

{{-- LOGIC --}}
@php
	// $userBalance = \Auth::user()->creditBalance();
	$pointUsed = 0;
	// if (session()->has('rewards')) {
	// 	$pointUsed = $userBalance;
	// }
@endphp
@if (request()->type)
	@if (session()->has('voucher'))
		@if (session()->get('voucher')['voucher_unit'] == 'Amount' || session()->get('voucher')['voucher_unit'] == 'amount')
			@if (session()->get('voucher')['voucher_type'] == 'shipping')
				{{-- SHIPPING VOUCHER --}}
				@if ($totalCourier > session()->get('voucher')['voucher_value'])
					{{-- JIKA KURIR LEBIH BESAR DARI NILAI VOUCHER --}}
					@php
						$total_payment = $totalPrice + $totalInsurance + $totalCourier - session()->get('voucher')['voucher_value'] - $pointUsed;
					@endphp
				@else
					{{-- JIKA KURIR LEBIH kecil DARI NILAI VOUCHER --}}
					@php
						$total_payment = $totalPrice  + $totalInsurance + $totalCourier - $totalCourier - $pointUsed;
					@endphp
				@endif
			@else
				{{-- TOTAL VOUCHER --}}
				@php
					$total_payment = $totalPrice + $totalInsurance + $totalCourier - session()->get('voucher')['voucher_value'] - $pointUsed;
				@endphp
			@endif
		@else
			@if (session()->get('voucher')['voucher_type'] == 'shipping')
				@php
					$voucherVal = $totalCourier * (session()->get('voucher')['voucher_value'] / 100);
					$total_payment = ($totalPrice + $totalInsurance + $totalCourier) - $voucherVal - $pointUsed;
				@endphp
			@else
				@php
					$voucherVal = $totalPrice * (session()->get('voucher')['voucher_value'] / 100);
					$total_payment = ($totalPrice + $totalInsurance + $totalCourier) - $voucherVal - $pointUsed;
				@endphp
			@endif
		@endif
	@else
		@php
			$total_payment = $totalPrice + $totalInsurance + $totalCourier - $pointUsed;
		@endphp
	@endif
@else
	@if (session()->has('voucher'))
		@if (session()->get('voucher')['voucher_unit'] == 'Amount' || session()->get('voucher')['voucher_unit'] == 'amount')
			@if (session()->get('voucher')['voucher_type'] == 'shipping')
				{{-- SHIPPING VOUCHER --}}
				@if ($cart->courier_cost > session()->get('voucher')['voucher_value'])
					{{-- JIKA KURIR LEBIH BESAR DARI NILAI VOUCHER --}}
					@php
						$total_payment = $cart->total_price + $cart->insurance + $cart->courier_cost - session()->get('voucher')['voucher_value'] - $pointUsed;
					@endphp
				@else
					{{-- JIKA KURIR LEBIH kecil DARI NILAI VOUCHER --}}
					@php
						$total_payment = $cart->total_price + $cart->insurance + $cart->courier_cost - $cart->courier_cost - $pointUsed;
					@endphp
				@endif
			@else
				{{-- TOTAL VOUCHER --}}
					@php
						$total_payment = $cart->total_price + $cart->insurance + $cart->courier_cost - session()->get('voucher')['voucher_value'] - $pointUsed;
					@endphp
			@endif
		@else
			@if (session()->get('voucher')['voucher_type'] == 'shipping')
				@php
					$voucherVal = $cart->courier_cost * (session()->get('voucher')['voucher_value'] / 100);
					$total_payment = ($cart->total_price + $cart->insurance + $cart->courier_cost) - $voucherVal - $pointUsed;
				@endphp
			@else
				@php
					$voucherVal = $cart->total_price * (session()->get('voucher')['voucher_value'] / 100);
					$total_payment = ($cart->total_price + $cart->insurance + $cart->courier_cost) - $voucherVal - $pointUsed;
				@endphp
			@endif
		@endif
	@else
		@php
			$total_payment = $cart->total_price + $cart->insurance + $cart->courier_cost - $pointUsed;
		@endphp
	@endif
@endif
{{-- LOGIC --}}

<div class="content-area mb-5 pt-0 pt-md-4 order-summary">
	<div class="container container-product pt-md-5 pt-3">
		<div class="row mb-md-5 mb-2">
			<div class="col-md-8">
				<h3>Item</h3>
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
						@if (request()->type)
							@php
							if (!request()->type) {
								$grandTotal = 0;
								$totalPrice = 0;
								$totalCourier = 0;
								$totalInsurance = 0;
								foreach ($cart as $ca) {
									$grandTotal += $ca->grand_total;
									$totalPrice += $ca->total_price;
									$totalInsurance += $ca->insurance;
								}
							}
							@endphp
							{{-- <p class="bold-700 float-right mb-1">{{ currency_format($grandTotal) }}</p> --}}
						@else
							<p class="bold-700 float-right mb-1">{{ currency_format($cart->grand_total) }}</p>
						@endif
					</div>
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<button type="button" class="btn btn-link float-left text-small p-0" id="open-details-1">Details</button>
					</div>
				</div>

				<div id="total-payment-2-1">
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<p class="bold-500 float-left mb-1">Total Price</p>
						@if (request()->type)
							<p class="bold-700 float-right mb-1">{{ currency_format($totalPrice) }}</p>
						@else
							<p class="bold-700 float-right mb-1">{{ currency_format($cart->total_price) }}</p>
						@endif
					</div>
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<p class="bold-500 float-left mb-1">Shipping Fee</p>
						@if (request()->type)
							<p class="bold-700 float-right mb-1">{{ currency_format($totalCourier) }}</p>
						@else
							<p class="bold-700 float-right mb-1">{{ currency_format($cart->courier_cost) }}</p>
						@endif
					</div>
					{{-- @if ($cart->insurance) --}}
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<p class="bold-500 float-left mb-1">Shipping Insurance</p>
						@if (request()->type)
						<p class="bold-700 float-right mb-1">{{ currency_format($totalInsurance) }}</p>
						@else
						<p class="bold-700 float-right mb-1">{{ currency_format($cart->insurance) }}</p>
						@endif
					</div>
					{{-- @endif --}}
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<p class="bold-700 float-left mb-1">Total Payment</p>
						@if (request()->type)
						<p class="bold-700 float-right mb-1 total-color">{{ currency_format($grandTotal) }}</p>
						@else
						<p class="bold-700 float-right mb-1 total-color">{{ currency_format($cart->grand_total) }}</p>
						@endif
					</div>
					<div class="w-100 total pr-0 pr-md-5 float-left">
						<button type="button" class="btn btn-link float-left text-small p-0" id="close-details-1">Close Details</button>
					</div>
				</div>
			</div>

			<div class="col-md-8 offset-0 offset-md-0 pt-4 pt-md-0">
				@foreach ($cart->details as $item)
					<div class="cart-item pt-6">
						<div class="row product">
							<div class="col-5 col-md-2">
								<center>
									<img src="{{asset($item->product->cover_path)}}" class="w-75 img-cart-item" alt="">
								</center>
							</div>
							<div class="col-7 col-md-6">
								<p class="mb-0 bold-700">{{ $item->product->full_name }}</p>
								<p class="mb-0"><span class="bold-700">Origin:</span> {{ $item->product->origin->name }}</p>
								<p class="mb-2"><span class="bold-700">Netto:</span> {{ $item->product->weight }} gr</p>

								<p class="mb-0 bold-700 product-line-price">{{ $item->product->discounted_price ? currency_format($item->product->discounted_price) : currency_format($item->product->price) }}</p>
							</div>
							<div class="col-md-4 col-7 offset-5 offset-md-0 mt-4">
								{{-- <img src="{{ asset('assets/img/trash.png') }}" class="product-removal" alt=""> --}}

								<span class="fa-stack fa-md ml-2 pointer btn-wishlist @auth {{ \Auth::user()->userWishlisted($item->product->id) ? 'active' : '' }} @endauth" id="heart" data-id="{{ $item->product->id }}">
										<i class="fa fa-circle fa-stack-2x"></i>
										<i class="fa fa-heart fa-stack-1x fa-inverse"></i>
								</span>
								<div class="input-group input-group-number w-60 float-right">
									<div class="d-flex">
										<div id="field1" class="input-group-btn">
												{{-- <button type="button" id="sub" class="btn btn-default btn-number sub">-</button> --}}
												<input type="text" id="1" value="{{ $item->qty }}" min="1" max="1000" class="form-control input-number" disabled />
												{{-- <button type="button" id="add" class="btn btn-default btn-number add">+</button> --}}
										</div>
									</div>
								</div>
								<div class="product-line-price text-right mt-4">Total : <span>{{ $item->product->discounted_price ? currency_format($item->product->discounted_price * $item->qty) : currency_format($item->product->price * $item->qty) }}</span></div>
							</div>
						</div>
					</div>
				@endforeach
				<?php /*<div class="dropdown open" id="select_payment">
					<button class="btn btn-selectpayment bg-white w-79 text-left dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Select Payment Method
					</button>
					@if (session()->has('voucher') && session()->get('voucher')['voucher_type'] == 'payment_based')
						<div class="dropdown-menu w-79 p-3" aria-labelledby="dropdownMenu1">

						@if (session()->get('voucher')['voucher_bank'] == 'cc_bca')
							<p class="bold-700 mt-2">Credit Card (Automatic Verification)</p>

							<a href="{{ route('frontend.cart.payment.cc') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/icon-footer/credit-card.png') }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">Credit Card</p>
								</div>
							</a>
						@endif

						
						@if (session()->get('voucher')['voucher_bank'] == 'va_bca')
							<p class="bold-700 mt-2">Virtual Account (Automatic Verification)</p>
							<a href="{{ route('frontend.cart.payment.va', 'bca') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/bca.png') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">BCA Virtual Account</p>
								</div>
							</a>
						@endif

						@if (session()->get('voucher')['voucher_bank'] == 'va_mandiri')
							<p class="bold-700 mt-2">Virtual Account (Automatic Verification)</p>
							<a href="{{ route('frontend.cart.payment.va', 'mandiri') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/mandiri.jpg') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">Mandiri Virtual Account</p>
								</div>
							</a>
						@endif

						@if (session()->get('voucher')['voucher_bank'] == 'va_bni')
							<p class="bold-700 mt-2">Virtual Account (Automatic Verification)</p>
							<a href="{{ route('frontend.cart.payment.va', 'bni') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/bni.png') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">BNI Virtual Account</p>
								</div>
							</a>
						@endif

						@if (session()->get('voucher')['voucher_bank'] == 'va_bri')
							<p class="bold-700 mt-2">Virtual Account (Automatic Verification)</p>
							<a href="{{ route('frontend.cart.payment.va', 'bri') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/bri.png') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">BRI Virtual Account</p>
								</div>
							</a>
						@endif

						@if (session()->get('voucher')['voucher_bank'] == 'va_permata')
							<p class="bold-700 mt-2">Virtual Account (Automatic Verification)</p>
							<a href="{{ route('frontend.cart.payment.va', 'permata') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/permata.png') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">Permata Virtual Account</p>
								</div>
							</a>
						@endif

						@if (session()->get('voucher')['voucher_bank'] == 'va_danamon')
							<p class="bold-700 mt-2">Virtual Account (Automatic Verification)</p>
							<a href="{{ route('frontend.cart.payment.va', 'danamon') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/danamon.png') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">Danamon Virtual Account</p>
								</div>
							</a>
						@endif

						@if (session()->get('voucher')['voucher_bank'] == 'va_cimb')
							<p class="bold-700 mt-2">Virtual Account (Automatic Verification)</p>
							<a href="{{ route('frontend.cart.payment.va', 'cimb') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/cimb.png') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">CIMB Virtual Account</p>
								</div>
							</a>
						@endif

						@if (session()->get('voucher')['voucher_bank'] == 'va_hana')
							<p class="bold-700 mt-2">Virtual Account (Automatic Verification)</p>
							<a href="{{ route('frontend.cart.payment.va', 'hana') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/hana.png') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">Hana Bank Virtual Account</p>
								</div>
							</a>
						@endif

						@if (session()->get('voucher')['voucher_bank'] == 'va_maybank')
							<p class="bold-700 mt-2">Virtual Account (Automatic Verification)</p>
							<a href="{{ route('frontend.cart.payment.va', 'maybank') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/maybank.png') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">Maybank Virtual Account</p>
								</div>
							</a>
						@endif

						</div>

					@else
						<div class="dropdown-menu w-79 p-3" aria-labelledby="dropdownMenu1">
							<p class="bold-700 mt-2">Credit Card (Automatic Verification)</p>

							<a href="{{ route('frontend.cart.payment.cc') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/icon-footer/credit-card.png') }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">Credit Card</p>
								</div>
							</a>
							<a href="{{ route('frontend.cart.payment.ovo') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading" id="ovo_popup">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/ovo.png') }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">OVO</p>
								</div>
							<!--</a>-->
							{{-- @if ($total_payment + $pointUsed < \Auth::user()->creditBalance())
								<p class="bold-700 mt-2">Reward Point (Instant)</p>

								<a href="{{ route('frontend.cart.payment.reward_points') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
									<div class="d-flex" href="#">
										<img src="{{ asset('assets/img/logo.png') }}" class="img-bank-logo-small mr-3" alt="">
										<p class="bold-500 pt-1 text-dark">Reward Points</p>
									</div>
								</a>
							@endif --}}

							<p class="bold-700 mt-2">e-Money (Automatic Verification)</p>

							<a href="" data-multi="{{ request()->type == 'multi' ? 1 : 0 }}" class="process_loading gopay_payment">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/gopay.png') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">Gopay</p>
								</div>
							</a>

							<p class="bold-700 mt-2">Virtual Account (Automatic Verification)</p>

							<a href="{{ route('frontend.cart.payment.va', 'bca') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/bca.png') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">BCA Virtual Account</p>
								</div>
							</a>
							<a href="{{ route('frontend.cart.payment.va', 'mandiri') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/mandiri.jpg') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">Mandiri Virtual Account</p>
								</div>
							</a>
							<a href="{{ route('frontend.cart.payment.va', 'bni') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/bni.png') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">BNI Virtual Account</p>
								</div>
							</a>
							<a href="{{ route('frontend.cart.payment.va', 'bri') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/bri.png') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">BRI Virtual Account</p>
								</div>
							</a>
							<a href="{{ route('frontend.cart.payment.va', 'permata') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/permata.png') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">Permata Virtual Account</p>
								</div>
							</a>
							<a href="{{ route('frontend.cart.payment.va', 'danamon') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/danamon.png') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">Danamon Virtual Account</p>
								</div>
							</a>
							<a href="{{ route('frontend.cart.payment.va', 'cimb') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/cimb.png') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">CIMB Virtual Account</p>
								</div>
							</a>
							<a href="{{ route('frontend.cart.payment.va', 'hana') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/hana.png') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">Hana Bank Virtual Account</p>
								</div>
							</a>
							<a href="{{ route('frontend.cart.payment.va', 'maybank') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/maybank.png') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">Maybank Virtual Account</p>
								</div>
							</a>

							<p class="bold-700 mt-2">Convenience Store (Automatic Verification)</p>
							{{-- <a href="{{ route('frontend.cart.payment.cvs', 'indomaret') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/indomaret.png') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">Indomaret</p>
								</div>
							</a> --}}
							<a href="{{ route('frontend.cart.payment.cvs', 'alfamart') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="process_loading">
								<div class="d-flex" href="#">
									<img src="{{ asset('assets/img/bank/alfamart.png') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}" class="img-bank-logo-small mr-3" alt="">
									<p class="bold-500 pt-1 text-dark">Alfamart</p>
								</div>
							</a>

						</div>
					@endif
				</div>*/ ?>


				

			</div>

			<div class="col-md-3 pr-md-5 pr-auto d-md-flex">
				<div id="total-payment">
					<div class="w-100 total pr-0 pr-md-5 float-left hidden-768">
						<p class="bold-500 float-left mb-1">Total Price</p>
						@if (request()->type)
						<p class="bold-700 float-right mb-1">{{ currency_format($totalPrice) }}</p>
						@else
						<p class="bold-700 float-right mb-1">{{ currency_format($cart->total_price) }}</p>
						@endif
					</div>
					<div class="w-100 total pr-0 pr-md-5 float-left hidden-768">
						<p class="bold-500 float-left mb-1">Shipping Fee</p>
						@if (request()->type)
						<p class="bold-700 float-right mb-1">{{ currency_format($totalCourier) }}</p>
						@else
						<p class="bold-700 float-right mb-1">{{ currency_format($cart->courier_cost) }}</p>
						@endif
					</div>
					@if(session()->has('voucher'))
					<div class="w-100 total pr-0 pr-md-5 float-left hidden-768">
						<p class="bold-500 float-left mb-1">Promo Discount</p>
						@if (request()->type)
							<p class="bold-700 float-right mb-1">-
								@if (session()->has('voucher'))
									@if (session()->get('voucher')['voucher_unit'] == 'Amount' || session()->get('voucher')['voucher_unit'] == 'amount')
										@if (session()->get('voucher')['voucher_type'] == 'shipping')
											{{-- SHIPPING VOUCHER --}}
											@if ($totalCourier > session()->get('voucher')['voucher_value'])
												{{-- JIKA KURIR LEBIH BESAR DARI NILAI VOUCHER --}}
												{{ currency_format(session()->get('voucher')['voucher_value']) }}
											@else
												{{-- JIKA KURIR LEBIH kecil DARI NILAI VOUCHER --}}
												{{ currency_format($totalCourier) }}
											@endif
										@else
											{{-- TOTAL VOUCHER --}}
											@php
												$voucherVal = $totalCourier * (session()->get('voucher')['voucher_value'] / 100);
											@endphp
											{{ currency_format(session()->get('voucher')['voucher_value']) }}
										@endif
									@else
										@if (session()->get('voucher')['voucher_type'] == 'shipping')
											@php
												$voucherVal = $totalCourier * (session()->get('voucher')['voucher_value'] / 100);
											@endphp
											{{ currency_format($voucherVal) }}
										@else
											@php
												$voucherVal = $totalPrice * (session()->get('voucher')['voucher_value'] / 100);
											@endphp
											{{ currency_format($voucherVal) }}
										@endif
									@endif
								@else
								-
								@endif
							</p>
						@else
							<p class="bold-700 float-right mb-1">-
								@if (session()->has('voucher'))
									@if (session()->get('voucher')['voucher_unit'] == 'Amount' || session()->get('voucher')['voucher_unit'] == 'amount')
										@if (session()->get('voucher')['voucher_type'] == 'shipping')
											{{-- SHIPPING VOUCHER --}}
											@if ($cart->courier_cost > session()->get('voucher')['voucher_value'])
												{{-- JIKA KURIR LEBIH BESAR DARI NILAI VOUCHER --}}
												{{ currency_format(session()->get('voucher')['voucher_value']) }}
											@else
												{{-- JIKA KURIR LEBIH kecil DARI NILAI VOUCHER --}}
												{{ currency_format($cart->courier_cost) }}
											@endif
										@else
											{{-- TOTAL VOUCHER --}}
											@php
												$voucherVal = $cart->courier_cost * (session()->get('voucher')['voucher_value'] / 100);
											@endphp
											{{ currency_format(session()->get('voucher')['voucher_value']) }}
										@endif
									@else
										@if (session()->get('voucher')['voucher_type'] == 'shipping')
											@php
												$voucherVal = $cart->courier_cost * (session()->get('voucher')['voucher_value'] / 100);
											@endphp
											{{ currency_format($voucherVal) }}
										@else
											@php
												$voucherVal = $cart->total_price * (session()->get('voucher')['voucher_value'] / 100);
											@endphp
											{{ currency_format($voucherVal) }}
										@endif
									@endif
								@else
								-
								@endif
							</p>
						@endif
					</div>
					@endif
					{{-- @if ($cart->insurance) --}}
					<div class="w-100 total pr-0 pr-md-5 float-left hidden-768">
						<p class="bold-500 float-left mb-1">Shipping Insurance</p>
						@if (request()->type)
						<p class="bold-700 float-right mb-1">{{ currency_format($totalInsurance) }}</p>
						@else
						<p class="bold-700 float-right mb-1">{{ currency_format($cart->insurance) }}</p>
						@endif
					</div>

					{{-- @endif --}}

					{{-- @if (session()->has('rewards'))
						<div class="w-100 total pr-0 pr-md-5 float-left">
							<p class="bold-500 float-left mb-1">Reward Points Used</p>
							<p class="bold-700 float-right mb-1">- {{ currency_format(\Auth::user()->creditBalance()) }}</p>
						</div>
					@endif --}}

					<div class="w-100 total pr-0 pr-md-5 float-left mb-3 hidden-768">
						<p class="bold-700 float-left mb-1">Total Payment</p>
						<p class="bold-700 float-right mb-1 total-color">{{ currency_format($total_payment) }}</p>
					</div>
					{{-- <div class="w-100 total pr-0 pr-md-5 float-left">
						<button type="button" class="btn btn-link float-left text-small p-0" id="close-details">Close Details</button>
					</div> --}}

					<div class="w-100 total pr-0 pr-md-5 float-left mb-3 hidden-768">
						<p class="bold-500 float-left mb-1">Reward Points</p>
						@php
							$percentage = \Auth::user()->rewardPercentage();
							$points = 0;
							if ($percentage) {
								$points = (int) ceil($total_payment / $percentage);
							}
						@endphp
						<p class="bold-700 float-right mb-1 bold-700" style="color:green;">+ {{ number_format($points) }}</p>
					</div>
					@if(!session()->has('voucher'))
						<div class="apply-promo mt-md-0 mt-3">
							<a title="" data-toggle="collapse" href="#promo-coupon" role="button" aria-expanded="false" aria-controls="promo-coupon" class="lnk btn btn-tropical-vcr mb-2 px-2 text-small">Apply Promo Code or Coupon</a>
						</div>
						<div class="collapse" id="promo-coupon">
							<div class="mt-3">
								<p class="bold-700">Promo Code</p>
								<div class="form-inline">
									<label class="sr-only" for="inlineFormInputName2">Name</label>
									<input type="text" class="form-control promo-input w-80 mb-2 mr-sm-2 pl-0" placeholder="Insert Promo Code" id="btn_text_voucher">
									<button type="button" class="btn btn-tropical mb-2 px-2 text-small" id="submit_voucher">USE</button>
									<p class="line-height12"><small class="text-red" id="voucher_result_msg"></small></p>
								</div>
							</div>
						</div>
					@else
					<div class="" id="promo-coupon">
						<div class="">
							<p class="bold-700">Promo Code</p>
							<div class="form-inline">
								<label class="sr-only" for="inlineFormInputName2">Name</label>
								<input type="text" class="form-control promo-input w-80 mb-2 mr-sm-2 pl-0" placeholder="Insert Promo Code" id="btn_text_voucher" disabled value="{{ session()->get('voucher')['voucher_code'] }}">
								<button type="button" class="btn btn-send-about mb-2 px-2 text-small" id="cancel_voucher">CANCEL</button>
								@if(session()->has('voucher_status'))
								<p class="line-height12 ml-md-2"><small class="text-success" id="voucher_result_msg">{{ session()->get('voucher_status') }}</small></p>
								@endif
							</div>
						</div>
					</div>
					@endif

                    <a href="#" class="lnk btn btn-tropical-pay w-100 mt-4 mb-3" onclick="next_payment();">Continue to Payment</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="ovo_modal">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">

			<!-- Modal body -->
			<div class="modal-body">
				<button type="button" class="close btn-closemodal" data-dismiss="modal"><p class="mt-0">&times;</p></button>
				<div class="form-group row mb-5 mt-5">
					<div class="col-12">
						<label for="address-label" class="address-label bold-700">Please Input your OVO Phone Number</label>
						<input type="number" name="ovo_number" id="ovo_number" class="form-control" placeholder="contoh:081312345678">
						{{-- <p class="text-small example-text">Example: Alamat Rumah, Alamat Kantor, Apartmen, Dropship</p> --}}
					</div>
				</div>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-cancel w-100" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary btn-send-about w-100" id="pay_with_ovo">Pay Now</button>
			</div>

	  	</div>
	</div>
</div>

<form id="payment-form" method="post" action="{{ route('frontend.cart.payment.gopay') }}">
	<input type="hidden" name="_token" value="{!! csrf_token() !!}">
	@if (request()->type == 'multi')
	<input type="hidden" name="multi" value="1">
	@endif
	<input type="hidden" name="result_type" id="result-type" value=""/>
	<input type="hidden" name="result_data" id="result-data" value=""/>
</form>

@endsection

@section('footer')
@include('frontend/includes/footer')
@endsection

@section('custom_js')
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-PrEA1B6S6IGZb8l7"></script>

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
{{--
	@if(\Auth::user()->creditBalance())
	@if(\Auth::user()->creditBalance() > 0)

	var points = {{ \Auth::user()->creditBalance() }};


	$('body').on('change', '#user_reward_checkbox', function() {
		var status = 0;
		if(this.checked) {
			status = 1;
		}

		loadingStart();


		$.ajax({
			type: 'POST',
			url: "{{ route('frontend.cart.use.reward') }}",
			data:
			{
				'status' : status,
				"_token" : "{{ csrf_token() }}"
			},
			success: function (respond) {
				location.reload();
			}
		});

	});

	@endif
	@endif
	--}}

	$('#ovo_popup').click(function(e) {
		e.preventDefault();
		e.stopPropagation();
		$('#ovo_modal').modal('show');
	});

	$('#pay_with_ovo').click(function(e) {
		e.preventDefault();
		e.stopPropagation();

		var phone = $('#ovo_number').val();

		loadingStart();

		if (phone == '') {
			swal('error', 'Mohon masukkan nomor telepon', 'error');
			return false;
		}

		if (phone.charAt(0) !== '0') {
			swal('error', 'Format nomor telepon salah, nomor harus dimulai dengan "0"', 'error');
			return false;
		}

		{{ route('frontend.cart.payment.ovo') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}
		@if(request()->type == 'multi')
			window.location.href = "{{ route('frontend.cart.payment.ovo') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}&phone=" + phone;
		@else
			window.location.href = "{{ route('frontend.cart.payment.ovo') }}?phone=" + phone;
		@endif
		$('#ovo_modal').modal('hide');
	});

	$("#total-payment-2").hide();
	$("#total-payment-2-1").hide();

    // $('.collapse').on('shown.bs.collapse', function () {
    //     $(this).prev().addClass('d-none');
    //     $(this).prev().removeClass('d-flex');
    // });

    // $('.collapse').on('hidden.bs.collapse', function () {
    //     $(this).prev().removeClass('d-none');
    //     $(this).prev().addClass('d-flex');
    // });


    @if(!session()->has('voucher'))
    $('#submit_voucher').on("click",function(e){
        e.preventDefault();
		loadingStart();
        var code = $('#btn_text_voucher').val();

		if(code !== ''){
			$.ajax({
				type: 'POST',
				url: "{{ route('frontend.cart.voucher.check') }}",
				data:
				{
						"code": code,
						'type' : 'cart',
						"_token" : "{{ csrf_token() }}"
				},
				success: function (respond) {
					loadingEnd();
					var message = respond.message;
					if (respond.status) {
							location.reload();
					} else {
							$('#voucher_result_msg').html(respond.message);
					}
				}
			});
		} else { swal('error', 'Please input voucher code', 'error') }
    });
    @else
    $('#cancel_voucher').on("click",function(e){
        e.preventDefault();
        var code = $('#btn_text_voucher').val();
			if(code !== ''){
			$.ajax({
				type: 'POST',
				url: "{{ route('frontend.cart.voucher.cancel') }}",
				data:
				{
						"_token" : "{{ csrf_token() }}"
				},
				success: function (respond) {
					var message = respond.message;

					if (respond.status) {
							location.reload();
					} else {
							swal("Error", 'Somethisng wrong', "error");
					}
				}
			});
		}
    });
    @endif

	$('.gopay_payment').click(function (e) {
		e.preventDefault();

		$.ajax({
			url: '{{ route("frontend.midtrans.token") }}',
			type: 'POST',
			data:
			{
				"_token" : "{{ csrf_token() }}",
				"method" : 'gopay',
				@if(request()->type == 'multi')
				"type" : 'multi',
				@endif
			},
			cache: false,
			success: function(data) {
				loadingEnd();
				if (data.status) {
					location.reload();
				} else {
					var resultType = document.getElementById('result-type');
					var resultData = document.getElementById('result-data');
					function changeResult(type,data){
						$("#result-type").val(type);
						$("#result-data").val(JSON.stringify(data));
						//resultType.innerHTML = type;
						//resultData.innerHTML = JSON.stringify(data);
					}
					snap.pay(data, {
						onSuccess: function(result){
							changeResult('success', result);
							$("#payment-form").submit();
						},
						onPending: function(result){
							changeResult('pending', result);
							$("#payment-form").submit();
						},
						onError: function(result){
							changeResult('error', result);
							$("#payment-form").submit();
						},
  						onClose: function(){
							$("#payment-form").submit();
						}
					});
					$('#btn_pay_now').attr("disabled", false);
				}

			}
		});
	});


});

function next_payment(){
	$.ajax({
		type: 'GET',
		url: "{{ route('frontend.cart.payment.va', '0') }}{{ request()->type == 'multi' ? '?type=multi' : '' }}",
		data:
		{
			"_token" : "{{ csrf_token() }}"
		},
		success: function (respond) {
			//location.reload();
			//alert(respond);
			snap.pay(respond);
		}
	});
}

</script>

@endsection
