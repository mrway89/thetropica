@extends('frontend/layouts/main')

@section('custom_css')
<style>
.closebox,
.delete_compare {
	z-index: 8;
}
.delete_compare {
	cursor: pointer;
}
</style>

@endsection

@section('content')

<div class="content-area">
	<div class="container container-product pt-mb-0 pt-3 mb-5">
		<div class="row pt-md-0 pt-4">
			<div class="col-md-9 offset-md-3 pt-3">
				<h3 class="bold-300 mb-4 pt-md-5 pt-0 visible-768" >{{ $trans['compare_product_title'] }}</h3>
				<h3 class="bold-300 mb-4 pt-lg-5 pt-0 hidden-768 " >{{ $trans['compare_product_title'] }}</h3>
			</div>
			{{-- <div class="box-browse float-left border-bottom visible-768 pt-3">
				@include('frontend.purchase.includes.side_menu')
			</div> --}}
			<div class="col-lg-3 col-md-3 col-sm-6 col-6 pt-md-0">
				@include('frontend.purchase.includes.side_menu')
			</div>
			<div class="col-sm-6 col-6 visible-768 pt-md-0">
                <form>
                    <select id="select-shoppingguide" class="custom-select select-search select-shoppingguide float-left w-100 mb-5 mr-2 select_category">
						<option selected>Choose Category</option>
						@foreach ($brands as $brand)
							<option value='{{ $brand->id }}'>{{ $brand->{'title_' . $language} }}</option>
						@endforeach
                    </select>
                </form>
            </div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12">
				<div class="row">
					<div class="col-lg-3 col-md-3 hidden-768">
						<form>
							<select id="select-shoppingguide" class="custom-select select-shoppingguide w-100 mb-5 select_category">
								<option selected>Choose Category</option>
								@foreach ($brands as $brand)
						        	<option value='{{ $brand->id }}'>{{ $brand->{'title_' . $language} }}</option>
								@endforeach
						    </select>
						</form>
					</div>
					<div class="col-8 hidden-768">
						<p class="pt-2">{{ $trans['compare_product_helper'] }}</p>
					</div>
				</div>
				<div class="row">
					<div class="col-12 visible-768">
						<p class="pt-2">{{ $trans['compare_product_helper'] }}</p>
					</div>
				</div>
				<div class="row" id="product-list">
					<div class="col-md-4 product-compare  mb-4">
						<div class="row">
							<div class="col-md-9 col-sm-12 col-12 position-relative" id="select_1_wrapper">
								@if (session()->has('compare_1'))
									@php
										$detail = session()->get('compare_1')['product'];
									@endphp
									<div class="outDiv"></div>

									<a href="" class="delete_compare" data-id="1">
										<img class="closebox" src="{{asset('assets/img/closebox.png')}}"/>
									</a>

									<div class="divOne">
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-6 col-6 position-relative">
												<center>
													<img src="{{ asset($detail->cover->url) }}" class="mb-5 reflect" alt="">
												</center>
												<div class="w-100 float-left">
													<div class="row justify-content-md-center">
														<div class="col-lg-6 col-md-6 col-sm-12 col-12 pr-md-0 mb-md-0 mb-2">
															<div class="input-group input-group-number">
																<form class="d-flex">
																	<div id="field1" class="input-group-btn">
																		<button type="button" id="sub" class="btn btn-default btn-gray btn-number sub">-</button>
																		<input type="text" value="1" min="1" max="1000" class="form-control input-number" id="qty_count{{ $detail->id }}" />
																		<button type="button" id="add" class="btn btn-default btn-number add">+</button>
																	</div>
																</form>
															</div>
														</div>
														<div class="col-lg-6 col-md-6 col-sm-12 col-12 pr-md-0">
															<button type="button" class="btn btn-addtocart-small add_to_cart_many" data-id="{{ $detail->id }}">ADD TO CART</button>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-12 col-md-12 col-sm-6 col-6">
												<div class="product-detail-compare mt-md-5 mt-0">
													<img src="{{ asset($detail->brand->logo)}}" class="w-50 compare-logo" alt="">
													<h3 class="mb-2">{{ ucwords($detail->name) }}</h3>
													<p><span class="bold-700">Price : </span>{{ currency_format($detail->price) }}</p>

													@if ($detail->specification)
														@foreach ($detail->specification as $spec)
														<p><span class="bold-700">{{ $spec['name_' . $language . ''] }} : </span>{{ $spec['value_' . $language . ''] }}</p>
														@endforeach
													@endif

													{{-- <br><span class="bold-700">Certification:</span><br></br> --}}

													@foreach ($detail->certifications as $cert)
														<img src="{{ asset($cert->url)}}" class="img-stamp" alt="">
													@endforeach
												</div>
											</div>
										</div>
									</div>
									<div class="divTwo">
										<div class="w-100 float-left justify-content-md-center mt-5 pt-5">
											<div class="w-100 float-left">
												<select id="select_1" class="custom-select w-100">
													<option selected>Choose Category First</option>
												</select>
											</div>
										</div>
									</div>
								@else
									<div class="outDiv"></div>
									<div class="divOne">
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-6 col-6 position-relative">
												<center>
													<img src="{{ asset('assets/img/watu-jar-grey.png')}}" class="mb-5" alt="">
												</center>
											</div>
										</div>
									</div>
									<div class="divTwo w-100">
										<div class="w-100 float-left justify-content-md-center mt-5 pt-5">
											<div class="col-8 offset-md-2">
												<select id="select_1" class="custom-select w-100">
													<option selected>Choose Category First</option>
												</select>
											</div>
										</div>
									</div>
								@endif
							</div>
						</div>
					</div>

					<div class="col-md-4 product-compare  mb-4">
						<div class="row">
							<div class="col-md-9" id="select_2_wrapper">
								@if (session()->has('compare_2'))
									@php
										$detail = session()->get('compare_2')['product'];
									@endphp
									<div class="outDiv"></div>

									<a href="" class="delete_compare" data-id="2">
										<img class="closebox" src="{{asset('assets/img/closebox.png')}}"/>
									</a>

									<div class="divOne">
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-6 col-6 position-relative">
												<center>
													<img src="{{ asset($detail->cover->url) }}" class="mb-5 reflect" alt="">
												</center>
												<div class="w-100 float-left">
													<div class="row justify-content-md-center">
														<div class="col-lg-6 col-md-6 col-sm-12 col-12 pr-md-0 mb-md-0 mb-2">
															<div class="input-group input-group-number">
																<form class="d-flex">
																	<div id="field1" class="input-group-btn">
																		<button type="button" id="sub" class="btn btn-default btn-gray btn-number sub">-</button>
																		<input type="text" value="1" min="1" max="1000" class="form-control input-number" id="qty_count{{ $detail->id }}" />
																		<button type="button" id="add" class="btn btn-default btn-number add">+</button>
																	</div>
																</form>
															</div>
														</div>
														<div class="col-lg-6 col-md-6 col-sm-12 col-12 pr-md-0">
															<button type="button" class="btn btn-addtocart-small add_to_cart_many" data-id="{{ $detail->id }}">ADD TO CART</button>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-12 col-md-12 col-sm-6 col-6">
												<div class="product-detail-compare mt-md-5 mt-0">
													<img src="{{ asset($detail->brand->logo)}}" class="w-50 compare-logo" alt="">
													<h3 class="mb-2">{{ ucwords($detail->name) }}</h3>
													<p><span class="bold-700">Price : </span>{{ currency_format($detail->price) }}</p>

													@if ($detail->specification)
														@foreach ($detail->specification as $spec)
														<p><span class="bold-700">{{ $spec['name_' . $language . ''] }} : </span>{{ $spec['value_' . $language . ''] }}</p>
														@endforeach
													@endif

													{{-- <p><span class="bold-700">Certification:</span><br></p> --}}

													@foreach ($detail->certifications as $cert)
														<img src="{{ asset($cert->url)}}" class="img-stamp" alt="">
													@endforeach
												</div>
											</div>
										</div>
									</div>
									<div class="divTwo">
										<div class="w-100 float-left justify-content-md-center mt-5 pt-5">
											<div class="w-100 float-left">
												<select id="select_2" class="custom-select w-100">
													<option selected>Choose Category First</option>
												</select>
											</div>
										</div>
									</div>
								@else
									<div class="outDiv"></div>
									<div class="divOne">
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-6 col-6 position-relative">
												<center>
													<img src="{{ asset('assets/img/watu-jar-grey.png')}}" class="mb-5" alt="">
												</center>
											</div>
										</div>
									</div>
									<div class="divTwo w-100">
										<div class="w-100 float-left justify-content-md-center mt-5 pt-5">
											<div class="col-8 offset-md-2">
												<select id="select_2" class="custom-select w-100">
													<option selected>Choose Category First</option>
												</select>
											</div>
										</div>
									</div>
								@endif
							</div>
						</div>
					</div>

					<div class="col-md-4 product-compare  mb-4">
						<div class="row">
							<div class="col-md-9" id="select_3_wrapper">

								@if (session()->has('compare_3'))
								@php
									$detail = session()->get('compare_3')['product'];
								@endphp
								<div class="outDiv"></div>

								<a href="" class="delete_compare" data-id="3">
									<img class="closebox" src="{{asset('assets/img/closebox.png')}}"/>
								</a>

								<div class="divOne">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-6 col-6 position-relative">
											<center>
												<img src="{{ asset($detail->cover->url) }}" class="mb-5 reflect" alt="">
											</center>
											<div class="w-100 float-left">
												<div class="row justify-content-md-center">
													<div class="col-lg-6 col-md-6 col-sm-12 col-12 pr-md-0 mb-md-0 mb-2">
														<div class="input-group input-group-number">
															<form class="d-flex">
																<div id="field1" class="input-group-btn">
																	<button type="button" id="sub" class="btn btn-default btn-gray btn-number sub">-</button>
																	<input type="text" value="1" min="1" max="1000" class="form-control input-number" id="qty_count{{ $detail->id }}" />
																	<button type="button" id="add" class="btn btn-default btn-number add">+</button>
																</div>
															</form>
														</div>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-12 col-12 pr-md-0">
														<button type="button" class="btn btn-addtocart-small add_to_cart_many" data-id="{{ $detail->id }}">ADD TO CART</button>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-6 col-6">
											<div class="product-detail-compare mt-md-5 mt-0">
												<img src="{{ asset($detail->brand->logo)}}" class="w-50 compare-logo" alt="">
												<h3 class="mb-2">{{ ucwords($detail->name) }}</h3>
												<p><span class="bold-700">Price : </span>{{ currency_format($detail->price) }}</p>

												@if ($detail->specification)
													@foreach ($detail->specification as $spec)
													<p><span class="bold-700">{{ $spec['name_' . $language . ''] }} : </span>{{ $spec['value_' . $language . ''] }}</p>
													@endforeach
												@endif

												{{-- <p><span class="bold-700">Certification:</span><br></p> --}}

												@foreach ($detail->certifications as $cert)
													<img src="{{ asset($cert->url)}}" class="img-stamp" alt="">
												@endforeach
											</div>
										</div>
									</div>
								</div>

								<div class="divTwo">
									<div class="w-100 float-left justify-content-md-center mt-5 pt-5">
										<div class="w-100 float-left">
											<select id="select_3" class="custom-select w-100">
												<option selected>Choose Category First</option>
											</select>
										</div>
									</div>
								</div>
							@else
								<div class="outDiv"></div>
								<div class="divOne">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-6 col-6 position-relative">
											<center>
												<img src="{{ asset('assets/img/watu-jar-grey.png')}}" class="mb-5" alt="">
											</center>
										</div>
									</div>
								</div>
								<div class="divTwo w-100">
									<div class="w-100 float-left justify-content-md-center mt-5 pt-5">
										<div class="col-8 offset-md-2">
											<select id="select_3" class="custom-select w-100">
												<option selected>Choose Category First</option>
											</select>
										</div>
									</div>
								</div>
							@endif
							</div>
						</div>
					</div>
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
function browse(){
    $(".box-browse").toggleClass('active');
}
$(document).on('mouseover', '#product-list .outDiv', function() {
	test = $(this).parent("div");
	test.children(".divOne").addClass("fadeOut")
	test.children(".divTwo").addClass("fadeIn");
});

$(document).on('mouseout', '#product-list .outDiv', function() {
	test=$(this).parent("div");
	test.children(".divOne").removeClass("fadeOut")
	test.children(".divTwo").removeClass("fadeIn");
});

$(document).on('mouseover', '#product-list .divTwo', function() {
	test = $(this).parent("div");
	test.children(".divOne").addClass("fadeOut")
	test.children(".divTwo").addClass("fadeIn");
});

$(document).on('mouseout', '#product-list .divTwo', function() {
	test = $(this).parent("div");
	test.children(".divOne").removeClass("fadeOut")
	test.children(".divTwo").removeClass("fadeIn");
});

$("body").on('click', '.add', function () {
	if ($(this).prev().val() < 1000) {
		$(this).prev().val(+$(this).prev().val() + 1);
		$(this).prev('.input-number').trigger('change');
	}
});
$("body").on('change','.input-number',function () {
    if ($(this).val() > 1){
        $(this).prev('.sub').addClass('active');
    } else {
        $(this).prev('.sub').removeClass('active');
    }
});

$("body").on('click', '.sub', function () {
	if ($(this).next().val() > 1) {
		if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
		$(this).next('.input-number').trigger('change');
	}
});

$(document).ready(function() {

	$('.select_category').on('change', function() {
		var cat = $(this).val();
		loadingStart();
        $.ajax({
            type: 'POST',
            url: "{{ route('frontend.ajax.compare.product') }}",
			data:
			{
				"category": cat,
				"_token" : "{{ csrf_token() }}"
			},
            success: function (respond) {
				loadingEnd();
				$('#select_1').html(respond.products);
				$('#select_2').html(respond.products);
				$('#select_3').html(respond.products);
            }
        });
	});

    $("body").on('change', '#select_1', function () {
		var product = $(this).val();
		var cat 	= $('.select_category').val();

		loadingStart();

        $.ajax({
            type: 'POST',
            url: "{{ route('frontend.ajax.compare.product.detail') }}",
			data:
			{
				"category": cat,
				"product": product,
				"select": 1,
				"_token" : "{{ csrf_token() }}"
			},
            success: function (respond) {
				loadingEnd();
				$('#select_1_wrapper').html(respond.view);
            }
        });
	});

    $("body").on('change', '#select_2', function () {
		var product = $(this).val();
		var cat 	= $('.select_category').val();
		loadingStart();

        $.ajax({
            type: 'POST',
            url: "{{ route('frontend.ajax.compare.product.detail') }}",
			data:
			{
				"category": cat,
				"product": product,
				"select": 2,
				"_token" : "{{ csrf_token() }}"
			},
            success: function (respond) {
				loadingEnd();
				$('#select_2_wrapper').html(respond.view);
            }
        });
	});

    $("body").on('change', '#select_3', function () {
		var product = $(this).val();
		var cat 	= $('.select_category').val();
		loadingStart();

        $.ajax({
            type: 'POST',
            url: "{{ route('frontend.ajax.compare.product.detail') }}",
			data:
			{
				"category": cat,
				"product": product,
				"select": 3,
				"_token" : "{{ csrf_token() }}"
			},
            success: function (respond) {
				loadingEnd();
				$('#select_3_wrapper').html(respond.view);
            }
        });
	});

    $("body").on('click', '.delete_compare', function (e) {
		e.preventDefault();
		var id = $(this).attr('data-id');
		loadingStart();

        $.ajax({
            type: 'POST',
            url: "{{ route('frontend.ajax.compare.product.remove') }}",
			data:
			{
				"id": id,
				"_token" : "{{ csrf_token() }}"
			},
            success: function (respond) {
				loadingEnd();
				if (respond.status) {
					location.reload();
				}
            }
        });
	});
});
</script>

@endsection
