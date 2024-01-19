@extends('frontend/layouts/main')

@section('custom_css')

@endsection

@section('content')

<div class="content-area mb-5 pt-4 order-summary" id="shopping_cart_wrapper">
	<div class="container container-product container-small pt-0" id="shopping_cart_content">
		<div class="row">
			<div class="col-md-7">
                @if (!empty($error_message = session('error_message')))
                    @foreach ($error_message as $err)
                    <div class="alert alert-danger">
                        {{ $err }}
                    </div>
                    @endforeach
                @endif
                <h3>{{ \Auth::user()->name }}'s Shopping Cart</h3>
                <div class="w-100 float-left border-bottom mb-3">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 mb-3">
                            <label class="container-checkmark">
                                <div class="label-14"><span class="">Select all</span><span> | </span><span><a href="" class="text-dark" id="cart_remove_product">Delete</a></span></div>
                                <input type="checkbox" value="" class="cekall" onchange="checkAll(this)" name="address_list[]">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                </div>
				<div class="w-100 float-left">
                    @if ($shoppingCartLists)
                    @if ($shoppingCartLists->details->count())
                        @foreach ($shoppingCartLists->details as $item)
                            <div class="w-100 float-left mb-4 pb-3">
                                <div class="row product pl-3">
                                    <label class="container-checkmark col-md-8 col-12">
                                        <div class="row">

                                            <div class="col-md-3 col-4 pr-0">
                                                <center>
                                                    <img src="{{asset($item->product->cover_path)}}" class="w-75 img-cart-item" alt="">
                                                </center>
                                            </div>
                                            <div class="col-md-9 col-8">
                                                <p class="mb-0 bold-700">{{ $item->product->full_name }}</p>
                                                <p class="mb-0"><span class="bold-700">Origin:</span> {{ $item->product->origin->name }}</p>
                                                <p class="mb-2"><span class="bold-700">Netto:</span> {{ $item->product->product_weight }} gr</p>

                                                <p class="mb-2 bold-700 product-line-price">{{ $item->product->discounted_price ? currency_format($item->product->discounted_price) : currency_format($item->product->price) }}</p>

                                            </div>
                                        </div>

                                        <input type="checkbox" value="" onclick="uncheckAll()" name="address_list" class="cart_product_check" data-rand="{{ $item->id }}">
                                        <span class="checkmark"></span>
                                    </label>
                                    <div class="col-md-4 col-12 mt-3">
                                        <div class="row">
                                            <div class="col-8 offset-4 offset-md-0 col-md-12">
                                                <img src="{{ asset('assets/img/trash.png') }}" class="product-removal delete_cart_item pointer" data-rand="{{ $item->id }}" alt="">
                                                <span class="fa-stack fa-md pointer btn-wishlist @auth {{ \Auth::user()->userWishlisted($item->product->id) ? 'active' : '' }} @endauth" id="heart" data-id="{{ $item->product->id }}">
                                                    <i class="fa fa-circle fa-stack-2x"></i>
                                                    <i class="fa fa-heart fa-stack-1x fa-inverse"></i>
                                                </span>
                                                <div class="input-group input-group-number w-60 float-right">
                                                    <form class="d-flex">
                                                        <div id="field1" class="input-group-btn">
                                                            <button type="button" id="sub" class="btn btn-default btn-number sub btn_change_qty">-</button>
                                                            <input type="text" id="1" value="{{ $item->qty }}" min="1" max="1000" class="form-control input-number p_qty" data-rand="{{ $item->id }}" />
                                                            <button type="button" id="add" class="btn btn-default btn-number add btn_change_qty">+</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="product-line-price d-md-block d-none text-right mt-4">Total <span>{{ $item->product->discounted_price ? currency_format($item->product->discounted_price * $item->qty) : currency_format($item->product->price * $item->qty) }}</span></div>
                                            </div>
                                        </div>

                                        {{-- <div class="row d-md-none d-flex mt-3">
                                            <div class="col-3 offset-1 p-0 ">
                                                <div class="product-line-price text-left">Total Price</div>
                                            </div>
                                            <div class="col-8">
                                                <div class="product-line-price text-left"><span>Rp 600.000</span></div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        Cart is Empty
                    @endif
                    @endif
				</div>
			</div>


			<!-- <div class="col-md-7">
				<h3>Alli Haliman's Shopping Cart</h3>
				<div class="cart-list mt-5">
					<div class="form-group border-bottom border-grey pb-2 mb-3">
					    <input type="checkbox" class="form-check-input" id="select-all" name="remember">
					    <label class="form-check-label bold-500" for="select-all">Select All</label>
					    <span class="mx-2">|</span>
					    <span><a href="#" class="text-dark">Delete</a></span>
					</div>
					<div class="cart-item pt-5">
						<div class="row product">
							<div class="col-2">
								<center>
									<img src="{{ asset('assets/img/watu-jar.png') }}" class="w-75 img-cart-item" alt="">
								</center>
							</div>
							<div class="col-6">
								<p class="mb-0 bold-700">Watu Cashew nuts Original</p>
								<p class="mb-0"><span class="bold-700">Origin:</span> Sumba, East Nusa Tenggara</p>
								<p class="mb-2"><span class="bold-700">Netto:</span> 475 gr</p>

								<p class="mb-0 bold-700 product-line-price">Rp 200.000</p>
							</div>
							<div class="col-4 mt-4">
								<img src="{{ asset('assets/img/trash.png') }}" class="product-removal" alt="">
								<span class="fa-stack fa-md" id="heart">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-heart fa-stack-1x fa-inverse"></i>
								</span>
								<div class="input-group input-group-number w-60 float-right">
									<form class="d-flex">
										<div id="field1" class="input-group-btn">
										    <button type="button" id="sub" class="btn btn-default btn-number sub">-</button>
										    <input type="text" id="1" value="3" min="1" max="1000" class="form-control input-number" />
										    <button type="button" id="add" class="btn btn-default btn-number add">+</button>
										</div>
									</form>
					            </div>
					            <div class="product-line-price text-right mt-4">Total <span>Rp 600.000</span></div>
							</div>
						</div>
					</div>
				</div>
			</div> -->

			<!-- checkout -->
			<div class="col-md-3 offset-md-1 offset-0">
				<div class="w-85">
					<h3>Summary</h3>
					<div class="row total mt-5">
						<div class="col">
							<p class="mb-1 bold-700 float-left">Total Payment</p>
							<p class="mb-1 bold-700 float-right totals-value total-color" id="cart-total">{{ currency_format($shoppingCartLists->total_price) }}</p>
						</div>
                    </div>

                    @if($shoppingCartLists->details->count())
                        <a href="{{ route('frontend.cart.shipping') }}" class="process_loading"><button class="checkout btn-send-about w-100 mt-4 mb-3">CHECKOUT ({{ $shoppingCartLists->TotalQty }})</button></a>
                    @else
                        <button class="checkout btn-send-about w-100 mt-4 mb-3">CHECKOUT ({{ $shoppingCartLists->TotalQty }})</button>
                    @endif

					<div class="coupon-success mb-3 mt-3">
                        {{-- <p class="bold-700 mb-3">Promo Code Applied!</p>

                        <p class="mb-1">Promo #1000121</p>

                        <div class="d-flex justify-content-between">
                            <p class="bold-700 mb-1">First Buy Discount</p>
                            <p class="bold-700 mb-1 total-color">- Rp 50.000</p>
                        </div> --}}
				    </div>
				</div>


			</div>

			<!-- end -->


		</div>
	</div>
</div>

@endsection

@section('footer')
@include('frontend/includes/footer')
@endsection

@section('custom_js')
<script src="{{ asset('assets/js/check_all.js') }}"></script>
<script>
// (function() {
//   const heart = document.getElementById('heart');
//   heart.addEventListener('click', function() {
//     heart.classList.toggle('red');
//   });
// })();

$("body").on('click', '.add', function () {
    if ($(this).prev().val() < 1000) {
        $(this).prev().val(+$(this).prev().val() + 1);
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
    }
    if ($(this).next().val() <= 1) {
        $(this).addClass('btn-gray');
    }
});

$('document').ready(function(){
    subCheck();
});
</script>

@endsection
