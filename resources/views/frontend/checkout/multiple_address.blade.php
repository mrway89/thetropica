@extends('frontend/layouts/main')


@section('content')

<div class="content-area mb-5 pt-4 order-summary">
	<form action="{{ route('frontend.cart.multishipping.store') }}" method="POST">
		{{ csrf_field() }}
		<div class="container container-product pt-md-5 pt-2">
			<div class="row">
				<div class="col-lg-8 col-md-12 col-12">
					<h3>Checkout</h3>
					<div class="cart-list mt-md-5 mt-3">
						<div class="checkout-address border-bottom border-grey mb-5 d-flex justify-content-between">
							<p class="bold-700 mb-4">
								Send to these multiple address:
							</p>

							<a href="{{ route('frontend.cart.shipping') }}" class="bold-700 mb-4">
								Send to single address
							</a>
						</div>
						@foreach ($carts->details as $item)
						<div class="cart-item border-bottom mb-5 pb-mb-5 pb-4 border-grey">
							<div class="row product">
								<div class="col-sm-2 col-3">
									<center>
										<img src="{{asset($item->product->cover_path)}}" class="w-75 img-cart-item" alt="">
									</center>
								</div>
								<div class="col-lg-6 col-md-7 col-sm-9 col-8">
									<p class="mb-0 bold-700">{{ $item->product->full_name }}</p>
									<p class="mb-0"><span class="bold-700">Origin:</span> {{ $item->product->origin->name }}</p>
									<p class="mb-2"><span class="bold-700">Netto:</span> {{ $item->product->weight }} gr</p>

									<p class="mb-0 bold-700 product-line-price">{{ $item->product->discounted_price ? currency_format($item->product->discounted_price) : currency_format($item->product->price) }}</p>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-5 col-8 mt-4 offset-lg-0 offset-sm-2 offset-3 pl-lg-3">
									{{-- <img src="{{ asset('assets/img/trash.png') }}" class="product-removal mr-2" alt=""> --}}
									<span class="fa-stack fa-md ml-2 pointer btn-wishlist @auth {{ \Auth::user()->userWishlisted($item->product->id) ? 'active' : '' }} @endauth" id="heart" data-id="{{ $item->product->id }}">
										<i class="fa fa-circle fa-stack-2x"></i>
										<i class="fa fa-heart fa-stack-1x fa-inverse"></i>
									</span>
									<div class="product-line-price text-right pull-right">
										Total : <span>{{ $item->product->discounted_price ? currency_format($item->product->discounted_price * $item->qty) : currency_format($item->product->price * $item->qty) }}</span>
									</div>
								</div>
								<div id="address_used-{{ $item->product->id }}">

								</div>
								<div class="col-12" id="product_address_wrapper_{{ $item->product->id }}">
									<div class="row mt-4">
										<div class="checkout-address-area col-md-6">
												@if ($carts->address->id)
												<input type="hidden" class="address_id_{{ $item->product->id }}" value="{{ $carts->address->id }}">
												<p class="mb-1"><span class="bold-700">{{ $carts->address->name }}</span> ({{ $carts->address->label }})</p>
												<p class="mb-1">{{ $carts->address->phone_number }}</p>
												<p class="mb-1">{{ $carts->address->address }}</p>
												<p class="mb-1">{{ $carts->address->city }}, {{ $carts->address->province }}, {{ $carts->address->postal_code }}</p>
												@endif
												<a href="#" class="bold-700" title="" data-toggle="modal" data-target="#editAddress">Change Address</a>
												{{-- <span class="mx-2">|</span>
												<a href="#" class="bold-700" title="" data-toggle="modal" id="edit-pinpoint" data-target="#editPinpoint">Edit Pinpoint</a> --}}
											</div>
											<div class="col-md-6 mt-sm-2 d-flex flex-row-reverse align-items-end">
												<div class="row ">
													<div class="col-md-12 mb-4">
															<div class="input-group input-group-number w-100 float-right">
																<div class="d-flex">
																	<div id="field1" class="input-group-btn">
																			<button type="button" id="sub" class="btn btn-default btn-gray btn-number sub">-</button>
																			<input type="number" id="1" value="{{ $item->qty }}" min="1" max="1000" class="form-control input-number input_qty" data-price={{ $item->product->price }} name="address[{{ $carts->address->id }}][{{ $item->product->id }}]['quantity'][]" />
																			<button type="button" id="add" class="btn btn-default btn-number add">+</button>
																	</div>
																</div>
															</div>
													</div>
													<div class="col-md-12 ">
														<a href="#" class="bold-700 delete_current_address" title="" >Delete Address</a>
													</div>
												</div>
											</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="text-center">
								<a href="#" class="bold-700" title="" onclick="addNewShipment({{ $item->product->id }})">Add New Shipment</a>
							</div>
						</div>
						@endforeach
						{{-- <div class="border-top  border-grey pt-3 mb-3 d-none">
							<div class="row">
								<div class="col-12">
									<a href="#" data-toggle="modal" data-target="#addAddress" class="bold-700" title="">Add Address +</a>
								</div>
							</div>
						</div> --}}
					</div>
				</div>
				<div class="col-lg-3 col-12 offset-lg-1">
					<h3>Summary</h3>
					<div class="row  total mt-lg-5 mt-3 pt-4">
						<div class="col">
							<p class="mb-1 bold-300 float-left">Total Price (<span id="multi_total_qty">{{ $carts->total_qty }}</span> items)</p>
							<p class="mb-1 bold-700 float-right totals-value" id="cart-total">{{ currency_format($carts->total_price) }}</p>
						</div>
					</div>
					{{-- <div class="row total">
						<div class="col">
							<p class="mb-1 bold-300 float-left">Shipping Fee</p>
							<p class="mb-1 bold-700 float-right totals-value" id="cart-total">Rp 13.000</p>
						</div>
					</div>

					<div class="row  total mt-5">
						<div class="col">
							<p class="mb-1 bold-700 float-left">Total Payment</p>
							<p class="mb-1 bold-700 float-right totals-value total-color" id="cart-total">Rp 413.000</p>
						</div>
					</div> --}}
					<button class="checkout btn-send-about  w-100 mt-4 mb-3">Pay</button>
					{{-- <div class="text-left-lg text-center"><a href="#" title="">Apply Promo Code or Coupon</a></div> --}}
				</div>
			</div>
		</div>
	</form>
</div>

@endsection

@section('footer')
@include('frontend/includes/footer')
@include('frontend/checkout/includes/address_multi_add')
@include('frontend/checkout/includes/editaddress')
@include('frontend/checkout/includes/address_multi')
@include('frontend/checkout/includes/editpinpoint')
@endsection

@section('custom_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.8.1/parsley.min.js"></script>
<script src="https://cdn.jsdelivr.net/select2/3.4.8/select2.js"></script>
<script>
$('body').on('click', '.add', function () {
		if ($(this).prev().val() < 1000) {
			$(this).prev().val(+$(this).prev().val() + 1);
			$(this).prev('.input-number').trigger('change');
			recalculateCart();
		}

});
$("body").on('change','.input-number',function () {
    if ($(this).val() > 1){
        $(this).prev('.sub').addClass('active');
    } else {
        $(this).prev('.sub').removeClass('active');
    }
});
$('body').on('click', '.sub', function () {
		if ($(this).next().val() > 1) {
			if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
			$(this).next('.input-number').trigger('change');
			recalculateCart();
		}
});

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function addNewShipment(id) {
	$('#product_address').val(id);
	$('#changeAddress').modal('show');

	var addressArr = $('.address_id_' + id).map(function() {
		return this.value;
	}).get();

	$.ajax({
		type: 'POST',
		url: '{{ route("frontend.ajax.multi.get.address") }}',
		data: {
			'product': id,
			'data': addressArr
		},
		success: function (respond) {
			var message = respond.message;
			if (respond.status) {
				$('#myAddress').html(message);
			} else {
			}
		}
	});
	recalculateCart();
}

function useAddress(id) {
	var prod = $('#product_address').val();
	$.ajax({
			type: 'POST',
			url: '{{ route("frontend.ajax.multi.set.address") }}',
			data: {
				'address': id,
				'product': prod,
			},
			success: function (respond) {
				var message = respond.message;
				if (respond.status) {
					$('#product_address_wrapper_' + prod).append(respond.message);
					$('#changeAddress').modal('hide');
				} else {
				}
			}
	});
}

function recalculateCart() {
	var qty = $('.input_qty');
	var total = 0;
	var totalQty = 0;
	qty.each(function(){
		var val = parseInt($(this).val());
		if (!isNaN(val)) {
			var price = $(this).data('price');
			total += val * price;
			totalQty += val;
		}
	});

	$('#cart-total').html("Rp " + numberWithCommas(total));
	$('#multi_total_qty').html(totalQty);
}

$(document).ready(function(){
	$('body').on('click', '.delete_current_address', function() {
       var $this = $(this);
	   $this.parent().parent().parent().parent().remove();
	});

	$('body').on('click', '#add_multi_address', function(e) {
        e.preventDefault();
        e.stopPropagation();
		var prod = $('#product_address').val();
		$('#product_id_form').val(prod);
		$('#changeAddress').modal('hide');
		$('#addAddress').modal('show');
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
						var id = $('#product_address').val();
						$('#addAddress').modal('hide');
						$('#product_address_wrapper_' + id).append(respond.message);
                    } else {
                        // swal("Error", respond.message, "error");
                    }
                    $('#btn_new_address').attr('disabled', false);
                }
            });
        }
	});


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
