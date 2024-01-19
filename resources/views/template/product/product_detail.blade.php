@extends('template/layouts/main')

@section('custom_css')
@endsection

@section('content')

<div class="section">
	<div class="content-area">
		<div class="container container-product pt-md-0 pt-3">
			<div class="row justify-content-center align-self-center">
				<div class="col-md-3 product-area-1 product-desc">
					<img src="{{ asset('assets/img/logo-watu-detail.png')}}" alt="">
					<h3 class="mb-5">multifloral honey</h3>
					<div class="hidden-768">
						<p><span class="bold-700">Origin: </span>Kapuas Hulu, Kalimantan</p>
						<p><span class="bold-700">Bees: </span>APIS DORSATA</p>
						<p><span class="bold-700">Health Benefit:</span><br>Rich in Vitamins & minerals, such as vitamin C, calcium, and iron. It has anti-bacterial and anti-fungal properties</p>
						<p><span class="bold-700">Taste Profile:</span><br>Sweet, slighty sour, slighty woody, caramelized, slighty acid.</p>
						<p><span class="bold-700">Certification:</span><br></p>
						<img src="{{ asset('assets/img/stamp.png')}}" class="img-stamp" alt="">
						<img src="{{ asset('assets/img/stamp.png')}}" class="img-stamp" alt="">
						<img src="{{ asset('assets/img/stamp.png')}}" class="img-stamp" alt="">
						<img src="{{ asset('assets/img/stamp.png')}}" class="img-stamp" alt="">
					</div>
				</div>
				<div class="col-md-4">
				  	<center>
					  	<img src="{{ asset('assets/img/watu-jar.png')}}" class="img-fluid w-75 img-product-detail" alt="">
					</center>
				</div>
				<div class="col-md-5 product-area-3">
					<div class="px-3 pb-mb-3 pb-2">
						<div class="row mb-3">
							<div class="col-md-7 col-6 ">
								<h3 class="nothing-font pt-mb-0 pt-3">Kapuas Hulu's Delicacy</h3>
							</div>
							<div class="col-md-5 col-6">
								<ul class="nav nav-pills float-right mb-3">
								  <li class="">
								    <a href="#" class="float-left pointer active">
										<img src="{{ asset('assets/img/bottle-200.png')}}" class="img-inside-tab">
										<p class="weight">
											200 gr
										</p>
								    </a>
								  </li>
								  <li class="">
								    <a href="#" class="float-left pointer">
								    	<img src="{{ asset('assets/img/bottle-400.png')}}" class="img-inside-tab">
								    	<p class="weight">
											400 gr
										</p>
								    </a>
								  </li>
								</ul>
								<!-- <div class="img" style="-webkit-mask-image: url('{{ asset('assets/img/watu-jar.png')}}');"></div>
								<img src="{{ asset('assets/img/watu-jar.png')}}" class="img-size" alt=""> -->
							</div>
						</div>

						<p class="nothing-font">
							Harvested traditionally by the local communities of Kapuas Hulu through the Tikung method on trees that are up to 30-40m high. With our commitment for sustainable nature, we apply The Lestari harvest process to ensure preservation of natural wealth and empowerment of the local communities.
						</p>

					</div>

					<div class="owl-carousel owl-theme owl-product-detail mt-3 mb-4">
					    <div class="item">
					    	<a data-toggle="modal" data-target="#exampleModal">
						    	<img src="{{ asset('assets/img/circle1.png') }}" class="img-fluid rounded-circle img-carousel" alt="">
						    	<p class="text-center nothing-font">
						    		Honey Quality
						    	</p>
						    </a>
					    </div>

					    <div class="item">
					    	<a data-toggle="modal" data-target="#exampleModal">
						    	<img src="{{ asset('assets/img/circle1.png') }}" class="img-fluid rounded-circle img-carousel" alt="">
						    	<p class="text-center nothing-font">
						    		Honey Quality
						    	</p>
						    </a>
					    </div>

					    <div class="item">
					    	<a data-toggle="modal" data-target="#exampleModal">
						    	<img src="{{ asset('assets/img/circle1.png') }}" class="img-fluid rounded-circle img-carousel" alt="">
						    	<p class="text-center nothing-font">
						    		Honey Quality
						    	</p>
						    </a>
					    </div>

					    <div class="item">
					    	<a data-toggle="modal" data-target="#exampleModal">
						    	<img src="{{ asset('assets/img/circle1.png') }}" class="img-fluid rounded-circle img-carousel" alt="">
						    	<p class="text-center nothing-font">
						    		Honey Quality
						    	</p>
						    </a>
					    </div>

					    <div class="item">
					    	<a data-toggle="modal" data-target="#exampleModal">
						    	<img src="{{ asset('assets/img/circle1.png') }}" class="img-fluid rounded-circle img-carousel" alt="">
						    	<p class="text-center nothing-font">
						    		Honey Quality
						    	</p>
						    </a>
					    </div>

					    <div class="item">
					    	<a data-toggle="modal" data-target="#exampleModal">
						    	<img src="{{ asset('assets/img/circle1.png') }}" class="img-fluid rounded-circle img-carousel" alt="">
						    	<p class="text-center nothing-font">
						    		Honey Quality
						    	</p>
						    </a>
					    </div>

					    <div class="item">
					    	<a data-toggle="modal" data-target="#exampleModal">
						    	<img src="{{ asset('assets/img/circle1.png') }}" class="img-fluid rounded-circle img-carousel" alt="">
						    	<p class="text-center nothing-font">
						    		Honey Quality
						    	</p>
						    </a>
					    </div>

					    <div class="item">
					    	<a data-toggle="modal" data-target="#exampleModal">
						    	<img src="{{ asset('assets/img/circle1.png') }}" class="img-fluid rounded-circle img-carousel" alt="">
						    	<p class="text-center nothing-font">
						    		Honey Quality
						    	</p>
						    </a>
					    </div>
					</div>
					<div class="w-100 float-left product-area-1 mb-3 visible-768">
						<p><span class="bold-700">Origin: </span>Kapuas Hulu, Kalimantan</p>
						<p><span class="bold-700">Bees: </span>APIS DORSATA</p>
						<p><span class="bold-700">Health Benefit:</span><br>Rich in Vitamins & minerals, such as vitamin C, calcium, and iron. It has anti-bacterial and anti-fungal properties</p>
						<p><span class="bold-700">Taste Profile:</span><br>Sweet, slighty sour, slighty woody, caramelized, slighty acid.</p>
						<p><span class="bold-700">Certification:</span><br></p>
						<img src="{{ asset('assets/img/stamp.png')}}" class="img-stamp" alt="">
						<img src="{{ asset('assets/img/stamp.png')}}" class="img-stamp" alt="">
						<img src="{{ asset('assets/img/stamp.png')}}" class="img-stamp" alt="">
						<img src="{{ asset('assets/img/stamp.png')}}" class="img-stamp" alt="">
					</div>

					<div class="w-100 float-left px-3">
						<div class="row justify-content-end">
							<div class="col-md-5 col-6">
								<h5 class="text-right font-weight-bold price-color mt-1">Rp 55.000,-</h5>
							</div>
							<div class="col-lg-3 col-md-4 col-6 ">
								<div class="input-group input-group-number w-100 float-right">
									<form class="d-flex">
										<div id="field1" class="input-group-btn">
										    <button type="button" id="sub" class="btn btn-default btn-gray btn-number sub">-</button>
										    <input type="text" id="1" value="3" min="1" max="1000" class="form-control input-number" />
										    <button type="button" id="add" class="btn btn-default btn-number add">+</button>
										</div>
									</form>
					            </div>
							</div>

							<div class="col-lg-4 col-md-5 col-7 pt-mb-0 pt-2">
								<button type="button" class="btn btn-send-about float-left-md float-right">ADD TO CART</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="discover discover-product">

        <a href="#2" title="">
        	<img src="{{ asset('assets/img/down-arrow-black.png') }}" alt="">
        </a>
    </div>
	</div>
</div>

<!-- Modal -->
@include('template/product/includes/modal_big_img');
@endsection

@section('footer')
@include('template/includes/footer')
@endsection


@section('custom_js')
<script src="{{ asset('assets/js/fullpage.min.js')}}"></script>
<script>
	$('.add').click(function () {
		if ($(this).prev().val() < 1000) {
    	$(this).prev().val(+$(this).prev().val() + 1);
		}

});
$('.sub').click(function () {
		if ($(this).next().val() > 1) {
    	if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
		}
});
	$(document).ready(function() {
		$('#fullpage').fullpage({
			//options here
			autoScrolling:false,
			scrollHorizontally: true,
			normalScrollElements: 'footer'
		});

		//methods
		$.fn.fullpage.setAllowScrolling(true);
	});

	$('.owl-carousel').owlCarousel({
	    loop:false,
	    dots: false,
	    margin:10,
	    nav:false,
	    responsive:{
	        0:{
	            items:4,
				margin:20,
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
</script>
@endsection
