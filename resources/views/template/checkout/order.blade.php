@extends('template/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-area mb-5 pt-4 order-summary">
	<div class="container container-product container-small pt-0">
		<div class="row">
			<div class="col-md-7">
                <h3>Alli Haliman's Shopping Cart</h3>
                <div class="w-100 float-left border-bottom mb-3">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 mb-3">
                            <label class="container-checkmark">
                                <div class="label-14"><span class="">Select all</span><span> | </span><span><a href="" class="text-dark">Delete</a></span></div>
                                <input type="checkbox" value="" class="cekall" onchange="checkAll(this)" name="address_list[]">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                </div>
				<div class="w-100 float-left">

                    <div class="w-100 float-left mb-4 pb-3">
                        <div class="row product pl-3">
                            <label class="container-checkmark col-md-8 col-12">
                                <div class="row">

                                    <div class="col-md-3 col-4 pr-0">
                                        <center>
                                            <img src="{{ asset('assets/img/watu-jar.png') }}" class="w-75 img-cart-item" alt="">
                                        </center>
                                    </div>
                                    <div class="col-md-9 col-8">
                                        <p class="mb-0 bold-700">Watu Cashew nuts Original</p>
                                        <p class="mb-0"><span class="bold-700">Origin:</span> Sumba, East Nusa Tenggara</p>
                                        <p class="mb-2"><span class="bold-700">Netto:</span> 475 gr</p>

                                        <p class="mb-2 bold-700 product-line-price">Rp 200.000</p>
                                        
                                    </div>
                                </div>

                                <input type="checkbox" value="" onclick="uncheckAll()" name="address_list">
                                <span class="checkmark"></span>
                            </label>
                            <div class="col-md-4 col-12 mt-3">
                            	<div class="row">
                            		<div class="col-8 offset-4 offset-md-0 col-md-12">
										<img src="{{ asset('assets/img/trash.png') }}" class="product-removal" alt="">
										<span class="fa-stack fa-md heart1" id="heart">
										  <i class="fa fa-circle fa-stack-2x"></i>
										  <i class="fa fa-heart fa-stack-1x fa-inverse"></i>
										</span>
										<div class="input-group input-group-number w-60 float-right">
											<form class="d-flex">
												<div id="field1" class="input-group-btn">
												    <button type="button" id="sub" class="btn btn-default btn-gray btn-number sub">-</button>
												    <input type="text" id="1" value="3" min="1" max="1000" class="form-control input-number" />
												    <button type="button" id="add" class="btn btn-default btn-number add">+</button>
												</div>
											</form>
							            </div>
							            <div class="product-line-price d-md-block d-none text-right mt-4">Total <span>Rp 600.000</span></div>
							        </div>
						        </div>

						        <div class="row d-md-none d-flex mt-3">
						        	<div class="col-3 offset-1 p-0 ">
										<div class="product-line-price text-left">Total Price</div>
                            		</div>
                            		<div class="col-8">
                            			<div class="product-line-price text-left"><span>Rp 600.000</span></div>
                            		</div>
						        </div>
							</div>
                        </div>
                    </div>

                    <div class="w-100 float-left mb-4 pb-3">
                        <div class="row product pl-3">
                            <label class="container-checkmark col-md-8 col-12">
                                <div class="row">

                                    <div class="col-md-3 col-4 pr-0">
                                        <center>
                                            <img src="{{ asset('assets/img/watu-jar.png') }}" class="w-75 img-cart-item" alt="">
                                        </center>
                                    </div>
                                    <div class="col-md-9 col-8">
                                        <p class="mb-0 bold-700">Watu Cashew nuts Original</p>
                                        <p class="mb-0"><span class="bold-700">Origin:</span> Sumba, East Nusa Tenggara</p>
                                        <p class="mb-2"><span class="bold-700">Netto:</span> 475 gr</p>

                                        <p class="mb-2 bold-700 product-line-price">Rp 200.000</p>
                                        
                                    </div>
                                </div>

                                <input type="checkbox" value="" onclick="uncheckAll()" name="address_list">
                                <span class="checkmark"></span>
                            </label>
                            <div class="col-md-4 col-12 mt-3">
                            	<div class="row">
                            		<div class="col-8 offset-4 offset-md-0 col-md-12">
										<img src="{{ asset('assets/img/trash.png') }}" class="product-removal" alt="">
										<span class="fa-stack fa-md heart2" id="heart">
										  <i class="fa fa-circle fa-stack-2x"></i>
										  <i class="fa fa-heart fa-stack-1x fa-inverse"></i>
										</span>
										<div class="input-group input-group-number w-60 float-right">
											<form class="d-flex">
												<div id="field1" class="input-group-btn">
												    <button type="button" id="sub" class="btn btn-default btn-gray btn-number sub">-</button>
												    <input type="text" id="1" value="3" min="1" max="1000" class="form-control input-number" />
												    <button type="button" id="add" class="btn btn-default btn-number add">+</button>
												</div>
											</form>
							            </div>
							            <div class="product-line-price d-md-block d-none text-right mt-4">Total <span>Rp 600.000</span></div>
							        </div>
						        </div>

						        <div class="row d-md-none d-flex mt-3">
						        	<div class="col-3 offset-1 p-0 ">
										<div class="product-line-price text-left">Total Price</div>
                            		</div>
                            		<div class="col-8">
                            			<div class="product-line-price text-left"><span>Rp 600.000</span></div>
                            		</div>
						        </div>
							</div>
                        </div>
                    </div>

                    
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
							<p class="mb-1 bold-700 float-right totals-value total-color" id="cart-total">Rp 413.000</p>
						</div>
					</div>
					<button class="checkout btn-send-about w-100 mt-4 mb-3">CHECKOUT (2)</button>

					<!-- apply -->
				<div class="apply-promo">
					<a title="" data-toggle="collapse" href="#promo-coupon" role="button" aria-expanded="false" aria-controls="promo-coupon">Apply Promo Code or Coupon</a>
				</div>
				<div class="collapse" id="promo-coupon">
				  <div class="mt-5">
				   	<p class="bold-700">Promo Code</p>
				   	<form class="form-inline">
					  <label class="sr-only" for="inlineFormInputName2">Name</label>
					  <input type="text" class="form-control promo-input w-79 mb-2 mr-sm-2 pl-0" id="inlineFormInputName2" placeholder="Insert Promo Code">
					  <button type="submit" class="btn btn-send-about mb-2 px-2 text-small">USE</button>
					  <p class="line-height12"><small class="text-red">Promo code not found, please insert another promo code.</small></p>
					</form>

					<!-- <p class="bold-700 mt-5">Select Coupon</p>
					<select id="" class="custom-select mt-3 select-shoppingguide w-100">
				        <option value='0'>Select Coupon</option>
				        <option value='1'>Profile</option>
				        <option value='2'>Messages</option>
				        <option value='3'>Settings</option>
				    </select>
				    <p class="line-height12"><small class="text-red">Selected coupon cannot be used at the moment, please select another coupon.</small></p> -->


				  </div>
				</div>

				<!-- end apply -->

					<div class="coupon-success mb-3 mt-3">
					<p class="bold-700 mb-3">Promo Code Applied!</p>

					<p class="mb-1">Promo #1000121</p>
					<!-- <p class="bold-700 mb-1">Talasi 1st Anniversary</p> -->
					<div class="d-flex justify-content-between">
						<p class="bold-700 mb-1">First Buy Discount</p>
						<p class="bold-700 mb-1 total-color">- Rp 50.000</p>
					</div>
					
				</div>	
				</div>
				


			</div>

			<!-- end -->
			
			
		</div>
	</div>
</div>

@endsection

@section('footer')
@include('template/includes/footer')
@endsection

@section('custom_js')
<script src="{{ asset('assets/js/check_all.js') }}"></script>
<script>
// (function() {
//   const heart = document.getElementsByClassName('heart');
//   heart.addEventListener('click', function() {
//     heart.classList.toggle('red');
//   });
// })();

$('.heart1').click(function(){
	$('.heart1').toggleClass('red');
})

$('.heart2').click(function(){
	$('.heart2').toggleClass('red');
})
$('.add').click(function () {
		if ($(this).prev().val() < 1000) {
    	$(this).prev().val(+$(this).prev().val() + 1);
			$(this).prev('.input-number').trigger('change');
		}

});
$('.input-number').change(function () {
    if ($(this).val() > 1){
        $(this).prev('.sub').addClass('active');
    } else {
        $(this).prev('.sub').removeClass('active');
    }
});
$('.sub').click(function () {
		if ($(this).next().val() > 1) {
    	if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
			$(this).next('.input-number').trigger('change');
		}
});

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
  var subtotal = 0;
  
  /* Sum up row totals */
  $('.product > .col-7').each(function () {
    subtotal += parseFloat($(this).children('.product-line-price').text());
  });
  
  /* Calculate totals */
  // var tax = subtotal * taxRate;
  // var shipping = (subtotal > 0 ? shippingRate : 0);
  // var total = subtotal + tax + shipping;
  var total = "";
  
  /* Update totals display */
  $('.totals-value').fadeOut(fadeTime, function() {
    // $('#cart-subtotal').html(subtotal.toFixed(2));
    // $('#cart-tax').html(tax.toFixed(2));
    // $('#cart-shipping').html(shipping.toFixed(2));
    $('#cart-total').html(total.toFixed(2));
    if(total == 0){
      $('.checkout').fadeOut(fadeTime);
    }else{
      $('.checkout').fadeIn(fadeTime);
    }
    $('.totals-value').fadeIn(fadeTime);
  });
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
      recalculateCart();
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
    recalculateCart();
  });
}
</script>

@endsection
