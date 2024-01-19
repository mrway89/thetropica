@extends('frontend/layouts/main')

@section('custom_css')
<style>
.modal-pinpoint.modal-dialog {
    max-width: 100vw;

}
.modal-content {
    max-width: 100vw;
}
</style>
@endsection

@section('content')
@include('frontend/product/includes/modal_big_img')
<div class="section">
	<div class="content-area product-area">
		<div class="container container-product pt-md-0 pt-5">
			<div class="row justify-content-center align-self-center">				
				<div class="col-md-4 mt-2">
				  	<center>
						<img src="{{ asset($product->cover->url)}}" class="img-fluid w-75 img-product-detail bg_product_list" alt="">
					</center>
				</div>
				<div class="col-md-8">
					<div class="px-3 pb-3">
						<div class="row mb-3">
							<div class="col-md-12 col-6 mt-2">
								<span class="judul_prod">{{ $product->{'title_description_' . $language} }}</span><br />
                                                                <span class="judul_prod">{{ $product->{'title_description_two_' . $language} }}</span><br />
								<span class="judul_prod">{{ $product->{'title_description_three_' . $language} }}</span>
							</div>
						</div>

						<!--<p class="nothing-font">
							{{ strip_tags($product->{'description_' . $language}) }}
						</p>-->
						
						<p class="nothing-font">
						    <label class="sort-by">Size :</label>
						    <select id="select-variant" class="custom-select select-search select-shoppingguide w-auto float-left mb-5 mr-2" onchange="gotoNewpage()">
								<option value='0'>{{ $default_variant }} {{ $default_unit }}</option>
								@foreach ($product_variant as $variant)							
								   <option value='{{ $variant->url }}'>{{ $variant->weight }}</option>
								@endforeach
							</select>
						</p><br />

					</div>
					
					<div class="visible-768">
						<div class="owl-carousel owl-theme owl-product-detail mt-3 mb-4 ">
							@foreach ($product->images as $i => $img)
								<div class="item">
									<a data-toggle="modal" data-target="#thumbnailModal{{ $i }}">
										<img src="{{ $img->thumbnail ? asset($img->thumbnail) : asset('assets/img/circle.png') }}" class="rounded-circle img-carousel mb-2" alt="">
										<p class="text-center nothing-font">
											{{ ucwords($img->{'title_' . $language}) }}
										</p>
									</a>
								</div>
							@endforeach
						</div>
					</div>

					<div class="w-100 float-left px-3">
						<div class="row justify-content-end">
							<div class="col-lg-4 col-md-6 col-6 px-md-0">
								<h5 class="text-right font-weight-bold price-det price-color mt-1">{{ currency_format($product->price) }},-</h5>
							</div>
							
							<div class="col-lg-4 col-md-6 col-6">
								@if($product->hasStock())
								<div class="input-group input-group-number w-100 float-right">
									<form class="d-flex">
										<div id="field1" class="input-group-btn">
										    <button type="button" id="sub" class="btn btn-default btn-gray btn-number sub">-</button>
										    <input type="text" value="1" min="1" max="1000" class="form-control input-number" id="qty_count{{ $product->id }}" />
										    <button type="button" id="add" class="btn btn-default btn-number add">+</button>
										</div>
									</form>
								</div>
								@endif
							</div>
							@if (!empty($product->purchase_limit_days) && !empty($product->purchase_limit_qty))
							<div class="col-lg-4 col-md-6 col-6">
								<p class="text-muted">
								max. purchase {{ $product->purchase_limit_qty }}pcs
								</p>
							</div>
							@else
							<div class="col-lg-4 col-md-5 col-7 pt-mb-0 pt-0">
								@if ($product->stock > 0)
									<button type="button" class="btn btn-tropical float-left-md float-right add_to_cart_many" data-id="{{ $product->id }}">ADD TO CART</button>
								@else
									<a href="mailto:{{ $admin_email}}" class="btn btn-tropical float-left-md float-right">Pre Order <i class="fa fa-long-arrow-right"></i></a>
								@endif
							</div>
							@endif
						</div>
						@if (!empty($product->purchase_limit_days) && !empty($product->purchase_limit_qty))
						<div class="row mb-4 ml-2 mt-3">
							<div class="col-lg-4 col-md-5 col-7 pt-mb-0 pt-0">
								@if ($product->stock > 0)
									<button type="button" class="btn btn-tropical float-left-md float-right add_to_cart_many" data-id="{{ $product->id }}">ADD TO CART</button>
								@else
									<a href="mailto:{{ $admin_email}}" class="btn btn-tropical float-left-md float-right">Pre Order <i class="fa fa-long-arrow-right"></i></a>
								@endif
							</div>
						</div>
						@endif
						
						<!-- origin -->
						
						<br />
						<button class="accordion judul_prod">Description</button>
						<div class="panel">
						  <p class="desc_prod">{!! $product->{'description_' . $language} !!}</p>
						</div>

						<!--<button class="accordion judul_prod">Information</button>
						<div class="panel">
						    <p>
						        @if ($product->specification)
									@foreach ($product->specification as $spec)
									<p class="desc_prod"><span class="bold-700">{{ $spec['name_' . $language . ''] }} </span> {{ $spec['value_' . $language . ''] }}</p>
									@endforeach
								@endif
						    </p>
						</div>

						<button class="accordion judul_prod">Usage</button>
						<div class="panel">
						    <p><br />
								@if ($product->certifications)
									{{-- <p><span class="bold-700">Certification:</span><br></p> --}}
									@foreach ($product->certifications as $cert)
										<img src="{{ asset($cert->url)}}" class="img-stamp" alt="">
									@endforeach
								@endif
							</p>
						</div>-->
					</div>
				</div>
			</div>
		</div>
		
		<!--<div class="discover discover-product position-relative">
			<a href="{{ route('frontend.product.detail', $related->slug) }}" title="">
				<img src="{{ asset('assets/img/down-arrow-black.png') }}" alt="">
			</a>
		</div>-->
	</div>
</div>

@endsection
<!-- Modal -->

@section('footer')
@include('frontend/includes/footer')
@endsection



@section('custom_js')
{{-- <script src="{{ asset('assets/js/fullpage.min.js')}}"></script> --}}
<script>
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
	// $(document).ready(function() {
	// 	$('#fullpage').fullpage({
	// 		//options here
	// 		anchors: ['1', '2', '3', '4', '5', '6'],
	// 		autoScrolling:true,
	// 		scrollHorizontally: true,
	// 		// normalScrollElements: 'footer'
	// 	});

	// 	//methods
	// 	$.fn.fullpage.setAllowScrolling(true);
	// });

	$('.owl-carousel').owlCarousel({
	    loop:false,
	    dots: false,
	    margin:10,
	    nav: true,
		navText: [
			'<img src="{{asset('assets/img/chevron-left.png')}}"/>',
			'<img src="{{asset('assets/img/chevron-right.png')}}"/>'
		],
	    responsive:{
	        0:{
	            items:2
	        },
	        600:{
	            items:3
	        },
	        1000:{
	            items:4
	        }
	    }
	})


$('.btn-number').click(function(e){
    e.preventDefault();

    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {

            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            }
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {

    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());

    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }


});
$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
	
function gotoNewpage(){
	if(document.getElementById('select-variant').value) {
		window.location.href = document.getElementById('select-variant').value;
    }
}

var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}
</script>
@endsection
