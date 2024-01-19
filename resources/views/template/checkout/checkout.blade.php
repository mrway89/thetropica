@extends('template/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-area mb-5 pt-md-4 pt-3 order-summary">
	<div class="container container-product pt-md-5 pt-0">
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
					    	<a href="{{url('frontend/cart/checkout/multiple-address')}}" class="bold-700" title="">Send to multiple address</a>
					    	<span class="mx-2">|</span>
					    	<a href="#" class="bold-700" title="" data-toggle="modal" data-target="#changeAddress">Change Addreess</a>
					    </div>
					    <div class="clearfix"></div>
					    <div class="checkout-address-area">
					    	<p class="mb-1"><span class="bold-700">Joseph Nathaniel</span> (Alamat Kos)</p>
							<p class="mb-1">087888866444</p>
							<p class="mb-1">Jalan Bacang 8A </p>
							<p class="mb-1">Kebayoran Baru, Kota Administrasi Jakarta Selatan, 12160</p>
							<a href="#" class="bold-700" title="" data-toggle="modal" data-target="#editAddress">Edit Address</a>
					    	<span class="mx-2">|</span>
					    	<a href="#" class="bold-700" title="" data-toggle="modal" data-target="#editPinpoint">Edit Pinpoint</a>
					    </div>

					    <div class="float-right d-block d-md-none mt-3">
					    	<a href="{{url('frontend/cart/checkout/multiple-address')}}" class="bold-700" title="">Send to multiple address</a>
					    	<span class="mx-2">|</span>
					    	<a href="#" class="bold-700" title="" data-toggle="modal" data-target="#addAddress">Add new address +</a>
					    </div>											
					</div>
					<div class="cart-item pt-3">
						<div class="row product">
							<div class="col-5 col-md-2">
								<center>
									<img src="{{ asset('assets/img/watu-jar.png') }}" class="w-75 img-cart-item" alt="">
								</center>
							</div>
							<div class="col-7 col-md-6">
								<p class="mb-0 bold-700">Watu Cashew nuts Original</p>
								<p class="mb-0"><span class="bold-700">Origin:</span> Sumba, East Nusa Tenggara</p>
								<p class="mb-2"><span class="bold-700">Netto:</span> 475 gr</p>

								<p class="mb-0 bold-700 product-line-price">Rp 200.000</p>
							</div>
							<div class="col-md-4 col-7 offset-5 offset-md-0 mt-4">
								<img src="{{ asset('assets/img/trash.png') }}" class="product-removal" alt="">
								<span class="fa-stack fa-md ml-2" id="heart">
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
					            <div class="product-line-price text-right mt-4 d-none d-md-flex">Total : <span>Rp 600.000</span></div>
							</div>
							<div class="col-5 d-flex d-md-none mt-4"><p class="bold-500 ml-2">Total Price</p></div>
							<div class="col-7 d-flex d-md-none mt-4"><p class="bold-500 total-color">Rp 400.000</p></div>
						</div>
					</div>

					<div class="border-top mt-5 border-grey">
						<div class="row mt-3">
							<div class="col-5 col-md-2 pt-2 pr-0">
								<p class="bold-700">
									Shipping Method:
								</p>
							</div>
							<div class="col-7 col-md-3 p-auto p-md-0">
								<form>
									<select id="select-shoppingguide" class="custom-select select-shoppingguide w-100">
								        <option value='0'>Next Day (1 Day)</option>
								        <option value='1'>Profile</option>
								        <option value='2'>Messages</option>
								        <option value='3'>Settings</option>
								    </select>
								    <div class="form-group mt-2">
					    				<input type="checkbox" class="form-check-input" id="select-all" name="remember">
					    				<label class="form-check-label bold-500" for="select-all">Shipping Insurance</label>
									</div>
								</form>
							</div>
							<div class="col-md-6 pt-2" id="showhide">
								<p><span class="bold-700">Courier:</span> <span id="couriername">SiCepat (Rp 13000)</span> <span href="#" id="changelink" class="bold-700 changelink ml-3" title="">Change</span></p>
							</div>
							<div class="col-md-4">
								<select id="select-courier" class="custom-select select-shoppingguide w-100">
							        <option value='0'>SiCepat (Rp 13.000)</option>
							        <option value='1'>GO-JEK (Rp 20.000)</option>
							        <option value='2'>JNE (Rp 25.000)</option>
							    </select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 offset-md-2">
								<div id="dvShipping" class="ml-2" style="display: none">
									<p class="font-italic">
										This Shipment is covered by JNE Insurance<br>
										with Rp 10.000 as an additional cost.
									</p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="product-line-price text-right mt-3 mt-md-4 mb-md-0 mb-3 d-flex justify-content-between d-md-block"><span class="text-dark">Total : </span><span>Rp 13.000</span></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- checkout -->
			<div class="col-md-3 offset-md-1 offset-0">
				<div class="w-85">
					<h3>Summary</h3>
					<div class="row total mt-2 pt-0 mt-md-5 pt-md-3">
						<div class="col">
							<p class="mb-1 bold-300 float-left">Total Price (2 items)</p>
							<p class="mb-1 bold-700 float-right totals-value" id="cart-total">Rp 600.000</p>
						</div>
					</div>
					<div class="row total">
						<div class="col">
							<p class="mb-1 bold-300 float-left">Shipping Fee</p>
							<p class="mb-1 bold-700 float-right totals-value" id="cart-total">Rp 13.000</p>
						</div>
					</div>

					<div class="row total mt-5">
						<div class="col">
							<p class="mb-1 bold-700 float-left">Total Payment</p>
							<p class="mb-1 bold-700 float-right totals-value total-color" id="cart-total">Rp 413.000</p>
						</div>
					</div>
					<button class="checkout btn-send-about w-100 mt-4 mb-3">Pay</button>
				</div>
				<div class="apply-promo">
					<a title="" data-toggle="collapse" href="#promo-coupon" role="button" aria-expanded="false" aria-controls="promo-coupon" class="d-md-block d-flex justify-content-center">Apply Promo Code or Coupon</a>
				</div>
				<div class="collapse" id="promo-coupon">
				  <div class="mt-5">
				   	<p class="bold-700">Promo Code</p>
				   	<form class="form-inline">
					  <label class="sr-only" for="inlineFormInputName2">Name</label>
					  <input type="text" class="form-control promo-input w-80 mb-2 mr-sm-2 pl-0" id="inlineFormInputName2" placeholder="Insert Promo Code">
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


			</div>

			<!-- end -->
		</div>
	</div>
</div>

@endsection

@section('footer')
@include('template/includes/footer')
@include('template/checkout/includes/addaddress')
@include('template/checkout/includes/editaddress')
@include('template/checkout/includes/editpinpoint')
@include('template/checkout/includes/changeaddress')
@endsection

@section('custom_js')

<script>
$(function () {
    $("#select-all").click(function () {
        if ($(this).is(":checked")) {
            $("#dvShipping").show(100);
        } else {
            $("#dvShipping").hide(100);
        }
    });
});
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
	$('#select-courier').hide();
    $('#changelink').click(function() {
      $('#changelink').hide();
      $('#couriername').hide();
      $('#select-courier').show();
      $('#showhide').removeClass("col-md-6");
      $('#showhide').addClass("col-md-1");
    });
});
(function() {
  const heart = document.getElementById('heart');
  heart.addEventListener('click', function() {
    heart.classList.toggle('red');
  });
})();

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
