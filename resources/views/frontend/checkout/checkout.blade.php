@extends('frontend/layouts/main')

@section('content')

@if (session()->has('voucher'))
	@if (session()->get('voucher')['voucher_unit'] == 'Amount' || session()->get('voucher')['voucher_unit'] == 'Amount')
		@if (session()->get('voucher')['voucher_type'] == 'shipping')
			{{-- SHIPPING VOUCHER --}}
			@if ($carts->courier_cost > session()->get('voucher')['voucher_value'])
				{{-- JIKA KURIR LEBIH BESAR DARI NILAI VOUCHER --}}
				@php
					$total_payment = $carts->total_price + $carts->insurance + $carts->courier_cost - session()->get('voucher')['voucher_value'];
					$voucherVal	   = session()->get('voucher')['voucher_value'];
				@endphp
			@else
				{{-- JIKA KURIR LEBIH kecil DARI NILAI VOUCHER --}}
				@php
					$total_payment = $carts->total_price + $carts->insurance + $carts->courier_cost - $carts->courier_cost;
					$voucherVal	   = $carts->courier_cost;
				@endphp
			@endif
		@else
			{{-- TOTAL VOUCHER --}}
			@php
				$total_payment = $carts->total_price + $carts->insurance + $carts->courier_cost - session()->get('voucher')['voucher_value'];
				$voucherVal	   = session()->get('voucher')['voucher_value'];
			@endphp
		@endif
	@else
		@if (session()->get('voucher')['voucher_type'] == 'shipping')
			@php
				$voucherVal	 	= $carts->courier_cost * (session()->get('voucher')['voucher_value'] / 100);
				$total_payment 	= ($carts->total_price + $carts->insurance + $carts->courier_cost) - $voucherVal;
			@endphp
		@else
			@php
				$voucherVal 	= $carts->total_price * (session()->get('voucher')['voucher_value'] / 100);
				$total_payment 	= ($carts->total_price + $carts->insurance + $carts->courier_cost) - $voucherVal;
			@endphp
		@endif
	@endif
@else
	@php
		$total_payment = $carts->total_price + $carts->insurance + $carts->courier_cost;

		if ($voucherVal > $total_payment) {
			session()->forget('voucher');
			return back();
		}
	@endphp
@endif
<div class="content-area mb-5 pt-md-4 pt-3 order-summary" id="shopping_cart_wrapper">
	<form action="{{ route('frontend.cart.shipping.store') }}" method="POST" id="form_shipping">
		{{ csrf_field() }}
		<div class="container container-product pt-md-5 pt-0" id="shopping_cart_content">
			<input type="hidden" id="address_rand" value="{{ $carts->user_address_id ? $carts->user_address_id : '' }}">
			<input type="hidden" id="cart_subtotal" value="{{ $carts->total_price }}">
			<input type="hidden" id="cart_shipping" value={{ $carts->courier_cost ? $carts->courier_cost : '' }}>
			<div class="row">
				<div class="col-md-7">
					<h3>Checkout</h3>
					<div class="cart-list mt-md-5 mt-3">
						<div class="checkout-address border-bottom border-grey pb-5 mb-5">
								<div class="float-left">
									<p class="bold-700 mb-4">
										Send to this address:
									</p>
								</div>
								<div class="float-right d-none d-md-block">
									{{-- <a href="{{ route('frontend.cart.multishipping')}}" class="bold-700" title="" id="multishipping_btn">Send to multiple address</a>
									<span class="mx-2">|</span> --}}
									<a href="#" class="bold-700" title="" data-toggle="modal" data-target="#changeAddress">Change Address</a>
								</div>
								<div class="clearfix"></div>

								@if ($carts->address->id)
								<input type="hidden" value="{{ $carts->address->city }}" id="current_address_city">
								<input type="hidden" value="{{ $carts->address->lat }}" id="current_address_lat">
								<input type="hidden" value="{{ $carts->address->long }}" id="current_address_long">
								<div class="checkout-address-area">
									<p class="mb-1"><span class="bold-700">{{ $carts->address->name }}</span> ({{ $carts->address->label }})</p>
									<p class="mb-1">{{ $carts->address->phone_number }}</p>
									<p class="mb-1">{{ $carts->address->address }}</p>
									<p class="mb-1">{{ $carts->address->city }}, {{ $carts->address->province }}, {{ $carts->address->postal_code }}</p>
									<a href="#" class="bold-700" title="" onclick="editAddress({{ $carts->address->id }})">Edit Address</a>
										<span class="mx-2">|</span>
									<a href="#" class="bold-700" title="" id="edit_pinpoint_current">Edit Pinpoint</a>
								</div>
								@endif
								<div class="d-block d-md-none mt-3">
									{{-- <a href="{{ route('frontend.cart.multishipping')}}" class="bold-700" title="" id="multishipping_btn">Send to multiple address</a>
									<span class="mx-2">|</span> --}}
									<a href="#" class="bold-700" title="" data-toggle="modal" data-target="#changeAddress">Change Address</a>
								</div>
						</div>
						@foreach ($carts->details as $item)
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

						<div class="border-top mt-5 border-grey">
							<div class="row mt-3">
								<div class="col-5 col-md-2 pt-2 pr-0">
									<p class="bold-700">
										Shipping Method:
									</p>
								</div>
								@if ($carts->address->id)
									<div class="col-7 col-md-3 p-auto p-md-0">
											@if ($carts->courier_cost)
												@php
													$nextDaySelected = false;
													$regularDaySelected = false;
													foreach ($nextday as $next) {
														$selVal = $next['courier'] . '-' . $next['type'];
														if ($selVal == $carts->courier_type_id) {
															$nextDaySelected = true;
														}
													}
													foreach ($regular as $reg) {
														$selVal = $reg['courier'] . '-' . $reg['type'];
														if ($selVal == $carts->courier_type_id) {
															$regularDaySelected = true;
														}
													}
												@endphp
											@endif
										<select id="select_shipping_day" class="custom-select select-shoppingguide w-100">
											{{-- <option value='0'>Instant(3 hours)</option> --}}
											<option value=''>Select Duration</option>
											{{-- <option value='1'>Same Day <span id="same_day"></span></option> --}}
											<option value='2' {{ $nextDaySelected ? 'selected' : '' }}>Next Day <span id="next_day"></span></option>
											<option value='3'{{ $regularDaySelected ? 'selected' : '' }}>Regular <span id="regular_day"></span></option>
											{{-- <option value='4'{{ $pickupSelected ? 'selected' : '' }}>Pickup <span id="pickup"></span></option> --}}
											<option value='5'>Regular <span id="ambil_langsung">Ambil Langsung</span></option>
										</select>
										<div class="form-group mt-2" id="insurance_wrapper">
											<input type="checkbox" class="form-check-input" id="insurance" name="insurance" value="1" {{ $carts->insurance ? 'checked' : '' }}>
											<label class="form-check-label bold-500" for="insurance">Shipping Insurance</label>
										</div>
									</div>
									<div class="pt-2 col-md-1 select_courier_wrapper" style="{{ $carts->courier_cost ? '' : 'display:none;' }}">
										<p><span class="bold-700" id="courier_text">Courier: </p>
									</div>
									<div class="col-md-4">

										<input type="hidden" id="select_courier_pickup" value="pickup">

										{{-- NEXTDAY --}}
										@if ($nextday)
										<select id="select_courier_nextday" class="custom-select select-shoppingguide w-100 select_courier_wrapper selects" style="@if(!$nextDaySelected) display:none; @endif">
											<option value="">Select Courier</option>
											@foreach ($nextday as $next)
												@php
														$selVal = $next['courier'] . '-' . $next['type'];
												@endphp
												<option value='{{ $selVal }}' data-value="{{ $next['cost'] }}" {{ $carts->courier_type_id == $selVal ? 'selected' : '' }}>{{ strtoupper($next['courier']) }}-{{ strtoupper($next['type']) }} ({{ currency_format($next['cost']) }})</option>
											@endforeach
										</select>
										@else
										Mohon perbaiki alamat anda atau buat alamat baru. Terima kasih
										@endif

										{{-- REGULAR --}}
										@if ($regular)
											<select id="select_courier_reguler" class="custom-select select-shoppingguide w-100 select_courier_wrapper selects" style="@if(!$regularDaySelected) display:none; @endif">
												<option value="">Select Courier</option>
												@foreach ($regular as $reg)
														@php
																$selVal = $reg['courier'] . '-' . $reg['type'];
														@endphp
														<option value='{{ $selVal }}' data-value="{{ $reg['cost'] }}" {{ $carts->courier_type_id == $selVal ? 'selected' : '' }}>{{ strtoupper($reg['courier']) }}-{{ strtoupper($reg['type']) }} ({{ $reg['etd'] }} Days) ({{ currency_format($reg['cost']) }})</option>
												@endforeach
											</select>
										@endif
										
										<select id="select_courier_self" class="custom-select select-shoppingguide w-100 select_courier_wrapper selects" style="@if(!$regularDaySelected) display:none; @endif">
											<option value="">Pilih Pengambilan</option>
											
													<option value='ambil-belatera' data-value="0">Ambil Langsung Belatera</option>
											
										</select>

										{{-- GOSEND --}}
										@if ($gosend)
											<select id="select_courier_sameday" class="custom-select select-shoppingguide w-100 select_courier_wrapper selects" style="@if(!$sameDaySelected) display:none; @endif">
												<option value="">Select Courier</option>
												@foreach ($gosend as $gos)
														<option value='{{ $gos['type'] }}' data-value="{{ $gos['price'] }}" title="{{ $gos['pickpoint_address'] }}">GO-SEND {{ $gos['name'] . ' (' . currency_format($gos['price']) . ')' }}</option>
												@endforeach
											</select>
										@else

											@if (!$carts->address->lat)
												<select id="select_courier_sameday" class="custom-select select-shoppingguide w-100 select_courier_wrapper selects" style="display:none;">
														<option value="">Please edit pinpoint for your delivery address first</option>
												</select>
											@else
												{{-- <select id="select_courier_sameday" class="custom-select select-shoppingguide w-100 select_courier_wrapper selects" style="@if(!$regularDaySelected) display:none; @endif">
														<option value="">Please edit pinpoint for your delivery address first</option>
												</select> --}}
											@endif
										@endif
									</div>
								@else
								<div class="col-7 col-md-3 p-auto p-md-0">
									<select id="select-shoppingguide" class="custom-select select-shoppingguide w-100" disabled>
											<option value='0'>Please Select / Create Address first</option>
									</select>
									<div class="form-group mt-2">
										<input type="checkbox" class="form-check-input" id="select-all" name="remember" disabled>
										<label class="form-check-label bold-500"  for="select-all">Shipping Insurance</label>
									</div>
								</div>
								@endif
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="product-line-price text-right mt-3 mt-md-4 mb-md-0 mb-3 d-flex justify-content-between d-md-block"><span>Total : </span><span class="cart_shipping_cost">{{ $carts->courier_cost ? currency_format($carts->courier_cost) : '' }}</span></div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- checkout -->
				<div class="col-md-3 offset-md-1 offset-0">
					<div class="w-85">
						<h3>Summary</h3>
						<div class="row total mt-5 pt-3">
							<div class="col">
								<p class="mb-1 bold-300 float-left">Total Price ({{ $carts->TotalQty }} items)</p>
								<p class="mb-1 bold-700 float-right totals-value" id="cart-total">{{ currency_format($carts->total_price) }}</p>
							</div>
						</div>
						<div class="row total">
							<div class="col">
								<p class="mb-1 bold-300 float-left">Shipping Fee</p>
								<p class="mb-1 bold-700 float-right totals-value cart_shipping_cost">{{ $carts->courier_cost ? currency_format($carts->courier_cost) : '-' }}</p>
							</div>
						</div>

						<div class="row total total_insurance" style="{{ !$carts->insurance ? 'display:none;' : '' }}">
							<div class="col">
								<p class="mb-1 bold-300 float-left">Insurance</p>
								<p class="mb-1 bold-700 float-right totals-value cart_insurance_cost">{{ $carts->insurance ? currency_format($carts->insurance) : '-' }}</p>
							</div>
						</div>
						<div class="row total total_voucher" style="{{ !session()->has('voucher') ? 'display:none;' : '' }}">
							<div class="col">
								<p class="mb-1 bold-300 float-left">Voucher / Promo</p>
								<p class="mb-1 bold-700 float-right totals-value">-
									{{ currency_format($voucherVal) }}
								</p>
							</div>
						</div>

						<div class="row total mt-5">
							<div class="col">
								<p class="mb-1 bold-700 float-left">Total Payment</p>
								<p class="mb-1 bold-700 float-right totals-value total-color cart_grand_total">{{ currency_format($total_payment) }}</p>
							</div>
						</div>
						<button class="checkout btn-send-about w-100 mt-4 mb-3 process_loading" id="continue_checkout">Complete Transaction</button>
					</div>


				</div>

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

$(document).ready(function(){


		$('#edit-pinpoint').click(function(e) {
			e.preventDefault();
			initAutocomplete();
			$('#address_map_type').val('new');
			$('#addAddress').modal('hide');
			$('#editPinpoint').modal('show');
		});

		$('#edit_form_pinpoint').click(function(e) {
			e.preventDefault();
			initEditFormMap();
			$('#address_map_type').val('edit_form');
			$('#editAddress').modal('hide');
			$('#editPinpoint').modal('show');
		});

		@if ($carts->user_address_id)
		$('#edit_pinpoint_current').click(function(e) {
			e.preventDefault();
			initEditMap();
			$('#address_map_type').val('edit');
			$('#editPinpoint').modal('show');
		});
		@endif


		$('#city-state').select2({
				closeOnSelect: true,
				minimumInputLength: 3,

				ajax: {
					url: "{{ route('frontend.rajaongkir.get_city') }}",
					dataType: 'json',
					// delay: 250,
					data: function (params) {
						return {
							query: params,
						};
					},
					results: function (data) {
							var myResults = [];
							$.each(data.cities, function (index, item) {
									myResults.push({
											'id': item.raja_ongkir_id + '-' + item.city_name + ',' + item.province.raja_ongkir_id + '-' + item.province.name,
											'text': item.city_name + ' (' + item.city_type + '), ' + item.province.name
									});
							});
							return {
									results: myResults
							};
					},
					cache: true
				}
		});

		$('body').on('click', '#edit_address_state', function(e){

			$('#edit_address_state').select2({
					closeOnSelect: true,
					minimumInputLength: 3,
    			placeholder: "Choose City / State",

					ajax: {
						url: "{{ route('frontend.rajaongkir.get_city') }}",
						dataType: 'json',
						data: function (params) {
							return {
								query: params,
							};
						},
						results: function (data) {
								var myResults = [];
								$.each(data.cities, function (index, item) {
										myResults.push({
												'id': item.raja_ongkir_id + '-' + item.city_name + ',' + item.province.raja_ongkir_id + '-' + item.province.name,
												'text': item.city_name + ' (' + item.city_type + '), ' + item.province.name
										});
								});
								return {
										results: myResults
								};
						},
						cache: true
					}
			});

			$('#s2id_autogen2_search').focus();
		});

    $("#address_form_modal").parsley({
        errorClass: 'is-invalid text-danger',
        successClass: 'is-valid',
        errorsWrapper: '<span class="form-text text-danger"></span>',
        errorTemplate: '<small></small>',
        trigger: 'change'
    });

    $("body").on('submit', '#address_form_modal', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var form = $(this);
        form.parsley().validate();

        var formData    = $(this).serialize();

        if (form.parsley().isValid()){
            $('#btn_new_address').attr('disabled', true);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                success: function (respond) {
                    var message = respond.message;
                    if (respond.status) {
                        location.reload();
                    } else {
                        swal("Error", respond.message, "error");
                    }
                    $('#btn_new_address').attr('disabled', false);
                }
            });
        }
		});


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

    })

		if ($('#select_shipping_day').val() == 2) {
			$('#select_courier_nextday').attr('name', 'shipping');
			$('#select_courier_reguler').removeAttr('name');
			$('#select_courier_sameday').removeAttr('name');
			$('#select_courier_pickup').removeAttr('name');
		} else if ($('#select_shipping_day').val() == 3) {
			$('#select_courier_reguler').attr('name', 'shipping');
			$('#select_courier_nextday').removeAttr('name');
			$('#select_courier_sameday').removeAttr('name');
			$('#select_courier_pickup').removeAttr('name');
		} else if ($('#select_shipping_day').val() == 4) {
			$('#select_courier_pickup').attr('name', 'shipping');
			$('#select_courier_reguler').removeAttr('name');
			$('#select_courier_nextday').removeAttr('name');
			$('#select_courier_sameday').removeAttr('name');

		} else {
			$('#select_courier_sameday').attr('name', 'shipping');
		}

    $("body").on('change', '#select_shipping_day', function (e) {
			$('.select_courier_wrapper').show();
			$('.selects').removeAttr('name');
			if ($(this).val() == 1) {
				$('#courier_text').show();
				$('#insurance_wrapper').show();
				$('#select_courier_sameday').attr('name', 'shipping');
				$('#select_courier_nextday').hide();
				$('#select_courier_reguler').hide();
				$('#select_courier_sameday').show();
			}
			if ($(this).val() == 2) {
				$('#courier_text').show();
				$('#insurance_wrapper').show();
				$('#select_courier_nextday').attr('name', 'shipping');

				$('#select_courier_nextday').show();
				$('#select_courier_reguler').hide();
				$('#select_courier_sameday').hide();
			}
			if ($(this).val() == 3) {
				$('#select_courier_reguler').attr('name', 'shipping');
				$('#courier_text').show();
				$('#insurance_wrapper').show();
				$('#select_courier_reguler').show();
				$('#select_courier_nextday').hide();
				$('#select_courier_sameday').hide();
			}
			if ($(this).val() == 4) {
				$('#courier_text').hide();
				$('#insurance_wrapper').hide();
				var checked = $("#insurance").is(":checked");
				if(checked){
					$("#insurance").attr('checked',false);
					$('#insurance').trigger('change');
				}
				$('#select_courier_pickup').attr('name', 'shipping');
				$('#select_courier_reguler').hide();
				$('#select_courier_nextday').hide();
				$('#select_courier_sameday').hide();
				$('#cart_shipping').val(0);
				recalculateCart();
			}

			if ($(this).val() == '') {
				$('#select_courier_reguler').hide();
				$('.select_courier_wrapper').hide();
				$('#select_courier_nextday').hide();
				$('#select_courier_sameday').hide();
			}
		});

		$('body').on('change', '#select_courier_nextday', function(e){
			var value = $(this).find(':selected').attr('data-value');
			var subtotal = parseInt($('#cart_subtotal').val());
			var total = subtotal + parseInt(value);
			$('#cart_shipping').val(parseInt(value));
			recalculateCart();
		});
		$('body').on('change', '#select_courier_reguler', function(e){
			var value = $(this).find(':selected').attr('data-value');
			var subtotal = parseInt($('#cart_subtotal').val());
			var total = subtotal + parseInt(value);
			$('#cart_shipping').val(parseInt(value));
			recalculateCart();
		});
		$('body').on('change', '#select_courier_sameday', function(e){
			var value = $(this).find(':selected').attr('data-value');
			var subtotal = parseInt($('#cart_subtotal').val());
			var total = subtotal + parseInt(value);
			$('#cart_shipping').val(parseInt(value));
			recalculateCart();
		});

		$('body').on('change', '#insurance', function() {
			var reg = $('#select_courier_reguler').val();
			var nex = $('#select_courier_nextday').val();
			var gjk = $('#select_courier_sameday').val();
			recalculateCart();
			if (reg !== '' || nex !== '' || gjk !== '') {
					if(this.checked) {
						recalculateCart();
					}
				} else {
					this.checked = false;
					swal('error', 'Please choose courier first', 'error')
					return;
			}

		});

});


function filterAddressList() {
		var input, filter, ul, li, a, i, txtValue;
		input = document.getElementById('search_address');
		filter = input.value.toLowerCase();
		ul = document.getElementById("myAddress");
		li = ul.getElementsByClassName('address_row');

		for (i = 0; i < li.length; i++) {
				txtValue = li[i].dataset.filtername;
				if (txtValue.toLowerCase().includes(filter)) {
				li[i].style.display = "";
				} else {
				li[i].style.display = "none";
				}
		}
}

function useAddress(id) {
	$.ajax({
			type: 'POST',
			url: "{{ route('frontend.cart.use_address') }}",
			data:
			{
					"id": id,
					"_token" : "{{ csrf_token() }}"
			},
			success: function (respond) {
				location.reload();
			}
	});
}

function editAddress(id)
{
	loadingStart();
	$("#address_edit_id").val(id);
	$.ajax
	({
			url: "{{ route('frontend.checkout.address.edit') }}",
			data:
			{
					"addressId": id,
					"_token": "{{ csrf_token() }}"
			},
			type: 'POST',
			dataType: 'json',
			success: function (data, textStatus, jqXHR)
			{
				loadingEnd();
				$('#changeAddress').modal('hide');
				$('#editAddress').modal('show');

				var cityVal = data.address.city + ', ' + data.address.province;

				$("#edit_address_id").val(data.address.id);
				$("#edit_address_label").val(data.address.label);
				$("#edit_address_name").val(data.address.name);
				$("#edit_address_postal").val(data.address.postal_code);
				$("#edit_address_phone").val(data.address.phone_number);
				$("#edit_address_address").val(data.address.address);
				$("#edit_latitude").val(data.address.lat);
				$("#edit_longitude").val(data.address.long);
				$('#edit_address_state').val(cityVal);
				if (data.is_default == 1) {
						$("#address_is_default").attr('disabled', true);
						$("#address_is_default").attr('checked', true);
				} else {
						$("#address_is_default").attr('checked', false);
						$("#address_is_default").attr('disabled', false);
				}
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				loadingEnd();
				$('#userMemberEditText-'+id).html('edit');

				swal({
						title: "Error!",
						icon: "warning",
						dangerMode: true,
						button: "Close",
				});
			},
	});
};

/* Set rates + misc */
var taxRate = 0.05;
var shippingRate = 15.00;
var fadeTime = 300;


/* Assign actions */
$('.input-number').change( function() {
  updateQuantity(this);
});

$('.product-removal').click( function() {
  removeItem(this);
});


/* Recalculate cart */
function recalculateCart()
{
	var ship 			= parseInt($('#cart_shipping').val());
	var subtotal 		= parseInt($('#cart_subtotal').val());
	var total 			= ship + subtotal;
	var voucher 		= {{ session()->has('voucher') ? $voucherVal : 0 }};

	if($('#insurance').is(':checked')){
		var insurance = parseInt((subtotal * 0.003) + parseInt("5000"));

		var newTotal = total + insurance - voucher;
		$('.cart_insurance_cost').html('Rp ' + numberWithCommas(insurance));
		$('.total_insurance').show();
	} else {
		var newTotal = total - voucher;
		$('.total_insurance').hide();
	}
	if ($('#cart_shipping').val() > 0) {
		$('.cart_shipping_cost').html('Rp ' + numberWithCommas(parseInt(ship)));
		$('.cart_grand_total').html('Rp ' + numberWithCommas(newTotal));
	} else {
		$('.cart_shipping_cost').html('-');
		$('.cart_grand_total').html('Rp ' + numberWithCommas(subtotal));
	}
    
        //alert(insurance);
}


/* Update quantity */
function updateQuantity(quantityInput)
{
  /* Calculate line price */
  var productRow = $(quantityInput).parent().parent();
  var price = parseFloat(productRow.children('.product-price').text());
  var quantity = $(quantityInput).val();
  var linePrice = price * quantity;

  /* Update line price display and recalc cart totals */
  productRow.children('.product-line-price').each(function () {
    $(this).fadeOut(fadeTime, function() {
      $(this).text(linePrice.toFixed(2));
      $(this).fadeIn(fadeTime);
    });
  });
}


/* Remove item from cart */
function removeItem(removeButton)
{
  /* Remove row from DOM and recalc cart total */
  var productRow = $(removeButton).parent().parent();
  productRow.slideUp(fadeTime, function() {
    productRow.remove();
  });
}
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
