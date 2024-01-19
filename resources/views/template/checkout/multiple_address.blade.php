@extends('template/layouts/main')

@section('custom_css')
@endsection

@section('content')

<div class="content-area mb-5 pt-4 order-summary">
	<div class="container container-product pt-md-5 pt-2">
		<div class="row">
			<div class="col-lg-8 col-md-12 col-12">
				<h3>Checkout</h3>
				<div class="cart-list mt-md-5 mt-3">
					<div class="checkout-address border-bottom border-grey mb-5 d-flex justify-content-between">
					    	<p class="bold-700 mb-4">
					    		Send to these multiple address:
					    	</p>

					    	<a href="#" class="bold-700 mb-4">
					    		Send to single address
					    	</a>
					    										
					</div>
					<div class="cart-item border-bottom mb-5 pb-mb-5 pb-4 border-grey">
						<div class="row product">
							<div class="col-sm-2 col-3">
								<center>
									<img src="{{ asset('assets/img/watu-jar.png') }}" class="w-75 img-cart-item" alt="">
								</center>
							</div>
							<div class="col-lg-6 col-md-7 col-sm-9 col-8">
								<p class="mb-0 bold-700">Watu Cashew nuts Original</p>
								<p class="mb-0"><span class="bold-700">Origin:</span> Sumba, East Nusa Tenggara</p>
								<p class="mb-2"><span class="bold-700">Netto:</span> 475 gr</p>

								<p class="mb-0 bold-700 product-line-price">Rp 200.000</p>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-5 col-8 mt-4 offset-lg-0 offset-sm-2 offset-3 pl-lg-3">
								<img src="{{ asset('assets/img/trash.png') }}" class="product-removal mr-2" alt="">
								<span class="fa-stack fa-md heart" id="heart">
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
					      <div class="product-line-price text-right mt-4">Total : <span>Rp 600.000</span></div>
							</div>
							<div class="col-12 d-flex justify-content-between align-items-end mt-4">
								<div class="row"> 
									<div class="checkout-address-area col-md-6">
											<p class="mb-1"><span class="bold-700">Joseph Nathaniel</span> (Alamat Kos)<span class="badge badge-address">MAIN ADDRESS</span></p>
											<p class="mb-1">087888866444</p>
											<p class="mb-1">Jalan Bacang 8A </p>
											<p class="mb-1">Kebayoran Baru, Kota Administrasi Jakarta Selatan, 12160</p>
											<a href="#" class="bold-700" title="" data-toggle="modal" data-target="#editAddress">Edit Address</a>
											<span class="mx-2">|</span>
											<a href="#" class="bold-700" title="" data-toggle="modal" id="edit-pinpoint" data-target="#editPinpoint">Edit Pinpoint</a>
										</div>	
										<div class="col-md-6 d-flex  align-items-end mt-sm-2">
											<a href="#" data-toggle="modal" data-target="#changeAddress" class="bold-700" title="">Change Address</a>
											<span class="mx-2">|</span>
											<a href="#" class="bold-700" title="" data-toggle="modal" data-target="#addAddress">Delete Address</a>
										</div>
									</div>
							</div>		
						</div>
					</div>

					<div class="cart-item border-bottom mb-5 pb-mb-5 pb-4 border-grey">
						<div class="row product">
							<div class="col-sm-2 col-3">
								<center>
									<img src="{{ asset('assets/img/watu-jar.png') }}" class="w-75 img-cart-item" alt="">
								</center>
							</div>
							<div class="col-lg-6 col-md-7 col-sm-9 col-8">
								<p class="mb-0 bold-700">Watu Cashew nuts Original</p>
								<p class="mb-0"><span class="bold-700">Origin:</span> Sumba, East Nusa Tenggara</p>
								<p class="mb-2"><span class="bold-700">Netto:</span> 475 gr</p>

								<p class="mb-0 bold-700 product-line-price">Rp 200.000</p>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-5 col-8 mt-4 offset-lg-0 offset-sm-2 offset-3 pl-lg-3">
								<img src="{{ asset('assets/img/trash.png') }}" class="product-removal mr-2" alt="">
								<span class="fa-stack fa-md heart" id="heart">
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
					      <div class="product-line-price text-right mt-4">Total : <span>Rp 600.000</span></div>
							</div>
							<div class="col-12 d-flex justify-content-between align-items-end mt-4">
								<div class="row"> 
									<div class="checkout-address-area col-md-6">
											<p class="mb-1"><span class="bold-700">Joseph Nathaniel</span> (Alamat Kos)<span class="badge badge-address">MAIN ADDRESS</span></p>
											<p class="mb-1">087888866444</p>
											<p class="mb-1">Jalan Bacang 8A </p>
											<p class="mb-1">Kebayoran Baru, Kota Administrasi Jakarta Selatan, 12160</p>
											<a href="#" class="bold-700" title="" data-toggle="modal" data-target="#editAddress">Edit Address</a>
											<span class="mx-2">|</span>
											<a href="#" class="bold-700" title="" data-toggle="modal" id="edit-pinpoint" data-target="#editPinpoint">Edit Pinpoint</a>
										</div>	
										<div class="col-md-6 d-flex  align-items-end mt-sm-2">
											<a href="#" data-toggle="modal" data-target="#changeAddress" class="bold-700" title="">Change Address</a>
											<span class="mx-2">|</span>
											<a href="#" class="bold-700" title="" data-toggle="modal" data-target="#addAddress">Delete Address</a>
										</div>
									</div>
							</div>		
						</div>
					</div>
					{{-- <div class="border-top  border-grey pt-3 mb-3 d-none">
						<div class="row">
							<div class="col-12">
								<a href="#" data-toggle="modal" data-target="#addAddress" class="bold-700" title="">Add Address +</a>
							</div>
						</div>
					</div> --}}
					<div class="border-top  border-grey">
						<div class="row mt-3">
							<div class="col-5 col-md-3 pt-2 pr-0">
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
			<div class="col-lg-3 col-12 offset-lg-1">
				<h3>Summary</h3>
				<div class="row  total mt-lg-5 mt-3 pt-4">
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

				<div class="row  total mt-5">
					<div class="col">
						<p class="mb-1 bold-700 float-left">Total Payment</p>
						<p class="mb-1 bold-700 float-right totals-value total-color" id="cart-total">Rp 413.000</p>
					</div>
				</div>
				<button class="checkout btn-send-about  w-100 mt-4 mb-3">Pay</button>
				<div class="text-left-lg text-center"><a href="#" title="">Apply Promo Code or Coupon</a></div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('footer')
@include('template/includes/footer')
@include('template/checkout/includes/addaddress')
@include('template/checkout/includes/editaddress')
@include('template/checkout/includes/changeaddress')
@include('template/checkout/includes/editpinpoint')
@endsection

@section('custom_js')

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
	$('#select-courier').hide();
    $('#changelink').click(function() {
      $('#changelink').hide();
      $('#couriername').hide();
      $('#select-courier').show();
      $('#showhide').removeClass("col-md-4");
      $('#showhide').addClass("col-md-1");
    });
});
// (function() {
//   const heart = document.getElementById('heart');
//   heart.addEventListener('click', function() {
//     heart.classList.toggle('red');
//   });
// })();

$(document).ready(function() {
  $('.heart').click(function() {
    $(this).toggleClass('red');
  });
});

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
