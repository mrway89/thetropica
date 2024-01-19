@extends('frontend/layouts/main')

@section('content')

<div class="content-area mb-5 pt-md-4 pt-3 order-summary" id="shopping_cart_wrapper">
	<form action="{{ route('frontend.cart.multishipping.courier.save') }}" method="POST" id="form_shipping">
		{{ csrf_field() }}
		<div class="container container-product pt-md-5 pt-0" id="shopping_cart_content">
			{{-- <input type="hidden" id="address_rand" value="{{ $cart->user_address_id ? $cart->user_address_id : '' }}"> --}}
			<input type="hidden" id="cart_subtotal" value="{{ $totalPrice }}">
			{{-- <input type="hidden" id="cart_shipping" value={{ $cart->courier_cost ? $cart->courier_cost : '' }}> --}}
			<div class="row">
				<div class="col-md-7">
					<h3>Checkout</h3>
					<div class="cart-list mt-md-5">
						<div class="checkout-address border-bottom border-grey pb-5 mb-5">
								{{-- <div class="float-left">
									<p class="bold-700 mb-4">
										Send to this address:
									</p>
								</div>
								<div class="float-right d-none d-md-block">
									<a href="{{ route('frontend.cart.multishipping')}}" class="bold-700" title="" id="multishipping_btn">Send to multiple address</a>
									<span class="mx-2">|</span>
									<a href="#" class="bold-700" title="" data-toggle="modal" data-target="#changeAddress">Change Address</a>
								</div>
								<div class="clearfix"></div> --}}


								@foreach ($mycarts as $i=>$cart)
								<div class="container pt-3 pb-3 mt-3" style="border:1px solid #e6e6e6;box-shadow: 2px 2px 2px #e6e6e6;">

									@if ($cart->address->id)
									<div class="checkout-address-area">
										<p class="mb-1"><span class="bold-700">{{ $cart->address->name }}</span> ({{ $cart->address->label }})</p>
										<p class="mb-1">{{ $cart->address->phone_number }}</p>
										<p class="mb-1">{{ $cart->address->address }}</p>
										<p class="mb-1">{{ $cart->address->city }}, {{ $cart->address->province }}, {{ $cart->address->postal_code }}</p>
									</div>
									<hr>
									@endif

									@foreach ($cart->details as $item)
									<div class="cart-item pt-3">
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

												<span class="fa-stack fa-md ml-2 pointer btn-wishlist @auth {{ \Auth::user()->userWishlisted($item->product->id) ? 'active' : '' }} @endauth" id="heart" data-id="{{ $item->product->id }}">
														<i class="fa fa-circle fa-stack-2x"></i>
														<i class="fa fa-heart fa-stack-1x fa-inverse"></i>
												</span>
												<div class="input-group input-group-number w-60 float-right">
													<div class="d-flex">
														<div id="field1" class="input-group-btn">
																<input type="text" id="1" value="{{ $item->qty }}" min="1" max="1000" class="form-control input-number" disabled />
														</div>
													</div>
															</div>
															<div class="product-line-price text-right mt-4">Total : <span>{{ $item->product->discounted_price ? currency_format($item->product->discounted_price * $item->qty) : currency_format($item->product->price * $item->qty) }}</span></div>
											</div>
										</div>
									</div>
									@endforeach
										<div class="border-top mt-5 border-grey">
											<div class="row mt-3">
												<div class="col-5 col-md-2 pt-2 pr-0">
													<p class="bold-700">
														Shipping Method:
													</p>
												</div>
													<div class="col-7 col-md-3 p-auto p-md-0">
														<select id="select_duration{{ $i }}" class="custom-select select-shoppingguide w-100" onchange="getCourier({{$i }},{{ $cart->id }})" required>
																	{{-- <option value='0'>Instant(3 hours)</option> --}}
																	<option value=''>Select Duration</option>
																	{{-- <option value='1'>Same Day <span id="same_day"></span></option> --}}
																	<option value='2' {{ $nextDaySelected ? 'selected' : '' }}>Next Day <span id="next_day"></span></option>
																	<option value='3'{{ $regularDaySelected ? 'selected' : '' }}>Regular <span id="regular_day"></span></option>
															</select>
															<div class="form-group mt-2">
																<input type="checkbox" class="form-check-input check_insurance" data-id="{{ $cart->id }}" data-subtotal="{{ $cart->total_price }}" id="insurance{{ $cart->id }}" name="insurance[{{ $cart->id }}]" value="1" {{ $cart->insurance ? 'checked' : '' }}>
																<label class="form-check-label bold-500" for="insurance{{ $cart->id }}">Shipping Insurance</label>
															</div>
													</div>
													<div class="pt-2 col-md-1 select_courier_wrapper">
														<p><span class="bold-700">Courier:</p>
													</div>
													<div class="col-md-4">
														<select id="select_courier{{ $i }}" class="custom-select select-shoppingguide w-100 select_courier_wrapper selects selected_courier courier_select{{$cart->id}}" name="shipping[{{ $cart->id }}]" required>
																<option value="">Select Courier</option>
																{{-- @foreach ($nextday as $next)
																	@php
																			$selVal = $next['courier'] . '-' . $next['type'];
																	@endphp
																	<option value='{{ $selVal }}' data-value="{{ $next['cost'] }}" {{ $carts->courier_type_id == $selVal ? 'selected' : '' }}>{{ strtoupper($next['courier']) }}-{{ strtoupper($next['type']) }} ({{ currency_format($next['cost']) }})</option>
																@endforeach --}}
															</select>
															<input type="hidden" class="courier_selected">
													</div>
											</div>
											{{-- <div class="row">
												<div class="col-md-12">
													<div class="product-line-price text-right mt-3 mt-md-4 mb-md-0 mb-3 d-flex justify-content-between d-md-block"><span>Total : </span><span class="cart_shipping_cost">{{ $cart->courier_cost ? currency_format($cart->courier_cost) : '' }}</span></div>
												</div>
											</div> --}}
										</div>
								</div>
								@endforeach
						</div>

					</div>
				</div>

				<!-- checkout -->
				<div class="col-md-3 offset-md-1 offset-0">
					<div class="w-85">
						<h3>Summary</h3>
						<div class="row total mt-5 pt-3">
							<div class="col">
								<p class="mb-1 bold-300 float-left">Total Price (<span class="multi_total_qty">{{ $totalItem }}</span> items)</p>
								<p class="mb-1 bold-700 float-right totals-value" id="cart-total">{{ currency_format($totalPrice) }}</p>
							</div>
						</div>
						<div class="row total">
							<div class="col">
								<p class="mb-1 bold-300 float-left">Shipping Fee</p>
								<p class="mb-1 bold-700 float-right totals-value cart_shipping_cost">-</p>
							</div>
						</div>

						<div class="row total total_insurance" style="{{ 'x' }}">
							<div class="col">
								<p class="mb-1 bold-300 float-left">Insurance</p>
								<p class="mb-1 bold-700 float-right totals-value cart_insurance_cost">-</p>
							</div>
						</div>
						{{-- <div class="row total total_voucher" style="{{ 's' }}">
							<div class="col">
								<p class="mb-1 bold-300 float-left">Voucher / Promo</p>
								<p class="mb-1 bold-700 float-right totals-value">-
								</p>
							</div>
						</div> --}}

						<div class="row total mt-5">
							<div class="col">
								<p class="mb-1 bold-700 float-left">Total Payment</p>
								<p class="mb-1 bold-700 float-right totals-value total-color cart_grand_total">{{ currency_format($totalPrice) }}</p>
							</div>
						</div>
						<button class="checkout btn-send-about w-100 mt-4 mb-3">Pay</button>
					</div>
					{{-- @if(!session()->has('voucher'))
					<div class="apply-promo">
						<a title="" data-toggle="collapse" href="#promo-coupon" role="button" aria-expanded="false" aria-controls="promo-coupon">Apply Promo Code or Coupon</a>
					</div>
					<div class="collapse" id="promo-coupon">
						<div class="mt-5">
							<p class="bold-700">Promo Code</p>
							<div class="form-inline">
								<label class="sr-only" for="inlineFormInputName2">Name</label>
								<input type="text" class="form-control promo-input w-79 mb-2 mr-sm-2 pl-0" placeholder="Insert Promo Code" id="btn_text_voucher">
								<button type="button" class="btn btn-send-about mb-2 px-2 text-small" id="submit_voucher">USE</button>
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
								<input type="text" class="form-control promo-input w-79 mb-2 mr-sm-2 pl-0" placeholder="Insert Promo Code" id="btn_text_voucher" disabled value="{{ session()->get('voucher')['voucher_code'] }}">
								<button type="button" class="btn btn-send-about mb-2 px-2 text-small" id="cancel_voucher">CANCEL</button>
								<p class="line-height12"><small class="text-red" id="voucher_result_msg"></small></p>
							</div>
						</div>
					</div>
					@endif --}}


				</div>

				<!-- checkout -->

				<!-- end -->
			</div>
		</div>
	</form>
</div>

@endsection

@section('footer')
@include('frontend/includes/footer')
@include('frontend/checkout/includes/addaddress')
@include('frontend/checkout/includes/changeaddress')
@include('frontend/checkout/includes/editaddress')
@include('frontend/checkout/includes/editpinpoint')
@endsection

@section('custom_js')

<script src="https://cdn.jsdelivr.net/select2/3.4.8/select2.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.8.1/parsley.min.js"></script>
<script>
function validate(evt) {
  var theEvent = evt || window.event;

  // Handle paste
  if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
  } else {
  // Handle key press
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
  }
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}

function getCourier(id, cart) {
	var duration = $('#select_duration' + id).val();
		loadingStart();
		$.ajax({
				type: 'POST',
				url: "{{ route('frontend.ajax.multi.get.courier') }}",
				data:
				{
						"duration": duration,
						'cart' : cart,
						"_token" : "{{ csrf_token() }}"
				},
				success: function (respond) {
						loadingEnd();
						var message = respond.message;
						if (respond.status) {
							$('#select_courier' + id).html(message);
						} else {
							swal('error', message, 'error')
						}
				}
		});

}

function recalculateCart() {
	var totalPrice = $('#cart_subtotal').val();
	var selected = $('.courier_selected');
	var totalCourier = 0;
	selected.each(function(){
		var val = parseInt($(this).val());
		if (!isNaN(val)) {
			totalCourier += val;
		}
	});

	var totalInsurance = recalculateInsurance();

	var grandTotal  = parseInt(totalPrice) + parseInt(totalCourier) + parseInt(totalInsurance);
	$('.cart_insurance_cost').html("Rp " + numberWithCommas(totalInsurance));
	$('.cart_shipping_cost').html("Rp " + numberWithCommas(totalCourier));
	$('.cart_grand_total').html("Rp " + numberWithCommas(grandTotal));
}

function recalculateInsurance() {
	var insurance = $('.check_insurance');
	var total = 0;
	insurance.each(function(){
		if(this.checked) {
			var id = $(this).attr('data-id');
			var subtotal = $(this).attr('data-subtotal');

			var totalIns = (subtotal * 0.003) + 5000;

			total += totalIns;
		}
	});
	return total;
}


$(document).ready(function(){

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


    $('#continue_checkout').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var address     = $('#address_rand').val();
        var shipment    = $('#cart_shipping').val();

        if (!address) {
            swal("Error", 'Please choose destination address or create new address', "error");
        }
        if(address && !shipment){
            swal("Error", 'Please choose Courier', "error");
        }
        if (address && shipment) {
            $('#form_shipping').submit();
						loadingStart();
        }

    });

		$('body').on('change', '.selected_courier', function() {
			$(this).next('.courier_selected').val($(this).find(':selected').data('value'));
			recalculateCart();
		});


		$('body').on('change', '.check_insurance', function() {
			var id = $(this).attr('data-id');

			if ($('.courier_select' + id).val() !== '') {
						recalculateCart();
					if(this.checked) {
					}

			} else {

				this.checked = false;
					swal('error', 'Please choose courier first', 'error')
				return;
			}

		});

});
</script>



@endsection
@section('custom_css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/select2/3.4.8/select2.css" />
<style>
select::-ms-expand {
    display: none;
}
select {
    -webkit-appearance: none;
    -moz-appearance: none;
    text-indent: 1px;
    text-overflow: '';
		font-size: 13px;
}

.select2-dropdown--above{
  display: flex; flex-direction: column;
}
.select2-dropdown--above .select2-search--dropdown{
  order: 2;
}
.select2-dropdown--above .select2-results {
order: 1;
}

.select2-dropdown--below{
  display: flex; flex-direction: column;
}
.select2-dropdown--below .select2-search--dropdown{
  order: 1;
}
.select2-dropdown--below .select2-results {
order: 2;
}

.select2-container .select2-choice {
	border:none;
	background-image: none;
}
.select2-arrow {
    display: none !important;
}
.select2-container .select2-choice {
	background: none;
}
#map .centerMarker{
  position:absolute;
  background:url({{ asset('assets/img/map_marker.png') }}) no-repeat;
  top:50%;
	left:50%;
  z-index:1;
	transform: translate(-50%, -50%);
  width:100px;
  height:56px;
  cursor:pointer;
}

</style>
@endsection
