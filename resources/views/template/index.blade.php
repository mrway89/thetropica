@extends('template/layouts/main_scrollspy')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="section section-slider">
	<div id="talasi-carousel" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
	      <li data-target="#talasi-carousel" data-slide-to="0" class="active"></li>
	      <li data-target="#talasi-carousel" data-slide-to="1"></li>
	      <li data-target="#talasi-carousel" data-slide-to="2"></li>
	    </ol>
	    <div class="letsgo">
	    	<span>Let's Go</span>
	    </div>
	    <div class="letsgoarrow">
	    	<a href="#2">
		    	<img src="{{ asset('assets/img/down-button.png') }}" alt="">
		    </a>
	    </div>
			<div class="carousel-inner home-carousel">
				<div class="carousel-item active">
					<img src="{{ asset('assets/img/andreas-wagner-294322-unsplash.jpg') }}" class="d-block w-100" alt="...">
					<div class="carousel-caption">
					<h1>Hello There</h1>
					<p>For over three decades, the founder of this company has been exploring Indonesia and have discovered, procured, processed natural ingredients for major consumer brands. He has build a very successful company in being an indispensable part of the value chain bridging the farms to consumers by converting raw materials into highly value added natural ingredients.</p>
						
				</div>
			</div>
			<div class="carousel-item">
				<img src="{{ asset('assets/img/artem-bali-660965-unsplash.jpg') }}" class="d-block w-100" alt="...">
				<div class="carousel-caption">
					<h1>Hello There</h1>
					<p>For over three decades, the founder of this company has been exploring Indonesia and have discovered, procured, processed natural ingredients for major consumer brands. He has build a very successful company in being an indispensable part of the value chain bridging the farms to consumers by converting raw materials into highly value added natural ingredients.</p>
				</div>
			</div>
			<div class="carousel-item">
				<img src="{{ asset('assets/img/kilarov-zaneit-622444-unsplash.jpg') }}" class="d-block w-100" alt="...">
				<div class="carousel-caption">
					<h1>Hello There</h1>
					<p>For over three decades, the founder of this company has been exploring Indonesia and have discovered, procured, processed natural ingredients for major consumer brands. He has build a very successful company in being an indispensable part of the value chain bridging the farms to consumers by converting raw materials into highly value added natural ingredients.</p>
				</div>
			</div>
	  </div>
	  <!-- <a class="carousel-control-prev" href="#talasi-carousel" role="button" data-slide="prev">
	    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	  </a>
	  <a class="carousel-control-next" href="#talasi-carousel" role="button" data-slide="next">
	    <span class="carousel-control-next-icon" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	  </a> -->
	</div>
</div>

<div class="section fp-table about-home" id="about-talasi">
	<div class="fp-tableCell">
		<div class="row justify-content-center">
	        <div class="col-md-9 text-center text-white">
	            <h3 class="mb-2 mb-md-5">We Have a Vision to</h3>
	            <h1 class="mb-5">Bring happiness to consumers<br>through enrichment of<br>people and nature at the origin</h1>
				
	        </div>
	    </div>
	</div>
	<div class="discover">
		<div class="discover-text">
        	<a href="{{ url('frontend/about') }}" class="text-white" title="">DISCOVER MORE</a>
        </div>
    </div>
</div>

<div class="section fp-table fp-product">
	<div class="fp-tableCell">
		<div class="row justify-content-center">
	        <div class="col-md-8 text-center text-black desc-product-home mt-2 mt-md-5">
	            <p>Our diverse range of brands and products are the result of thorough exploration, years of experience and passion to enrich
                your life with <b>Naturally Good</b> (Watu), <b>Naturally Fresh</b> (To-ye) and <b>Naturally Luxury</b> (Starling) product range produced at the origin
                 with modern day technologies.</p>
				
	        </div>
	    </div>
	    <div class="row justify-content-center">
            <div class="col-md-10 banner-product">
            	<center>
	                <img src="{{asset('assets/img/product_banner.jpg')}}"/>
	            </center>
            </div>
	    </div>
	</div>
	<div class="discover prod-browse">
		
        <a href="{{url('frontend/product')}}" title="">
        	<div class="browse">BROWSE OUR BRAND</div>
        </a>
    </div>
</div>

<div class="section fp-table discover-home" id="discover-home">
	<div class="fp-tableCell">
		<div class="row justify-content-center">
	        <div class="col-md-9 text-center text-white">
	            <h1 class="mb-5">Discover<br>the Origin</h1>
				
	        </div>
	    </div>
	</div>
	<div class="discover discover-product">
		<button type="button" class="btn btn-go">GO</button>
    </div>
</div>

@endsection

@section('footer')
@include('template/includes/footer')
@endsection

@section('custom_js')
<script src="{{ asset('assets/js/fullpage.min.js')}}"></script>
<script>

// var isPhoneDevice = "ontouchstart" in document.documentElement; 
// $(document).ready(function() {
// 	if(isPhoneDevice){
// 	 //    var myElements = document.querySelectorAll(".fp-section");

// 		// for (var i = 0; i < myElements.length; i++) {
// 		// 	myElements[i].style.height = '50vh';
// 		// }

// 		// var myElementsSlide = document.querySelectorAll(".section-slider");

// 		// for (var i = 0; i < myElementsSlide.length; i++) {
// 		// 	myElementsSlide[i].style.height = '100vh';
// 		// }
// 		// $(window).bind('mousewheel DOMMouseScroll', function(event){
// 		// 	if($('.discover-home').hasClass('active')){
// 		// 		console.log('tes active');
// 		// 		$('.brandlogblue').addClass('active');
// 		// 		$('.brandlogwhite').addClass('deactive');
// 		// 		$('.change-color').addClass('text-dark');
// 		// 		$('.change-color').removeClass('text-white');
// 		// 	}else{
// 		// 		console.log('tes deactive');
// 		// 		$('.brandlogblue').removeClass('active');
// 		// 		$('.brandlogwhite').removeClass('deactive');
// 		// 		$('.change-color').removeClass('text-dark');
// 		// 		$('.change-color').addClass('text-white');
// 		// 	}
// 		// });
// 	}
//     else{
//     	$(window).bind('mousewheel DOMMouseScroll', function(event){
// 		if($('.fp-product').hasClass('active')){
// 			console.log('tes active');
// 			$('.brandlogblue').removeClass('deactive');
// 			$('.brandlogblue').addClass('active');
// 			$('.brandlogwhite').addClass('deactive');
// 			$('.change-color').addClass('text-dark');
// 			$('.change-color').removeClass('text-white');
// 		}else{
// 			console.log('tes deactive');
// 			$('.brandlogblue').removeClass('active');
// 			$('.brandlogblue').addClass('deactive');
// 			$('.brandlogwhite').removeClass('deactive');
// 			$('.change-color').removeClass('text-dark');
// 			$('.change-color').addClass('text-white');
// 		}
// 		});
//     }
// });

$(window).bind('mousewheel DOMMouseScroll', function(event){
	if($('.fp-product').hasClass('active') ||  $('.fp-footer').hasClass('active')){
		// console.log('tes active');
		$('.brandlogblue').removeClass('deactive');
		$('.brandlogblue').addClass('active');
		$('.brandlogwhite').addClass('deactive');
		$('.change-color').addClass('text-dark');
		$('.change-color').removeClass('text-white');
	}else{
		// console.log('tes deactive');
		$('.brandlogblue').removeClass('active');
		$('.brandlogblue').addClass('deactive');
		$('.brandlogwhite').removeClass('deactive');
		$('.change-color').removeClass('text-dark');
		$('.change-color').addClass('text-white');
	}
});

// $(window).resize(function () {
//     autoHeightMobile();
//   });
//   autoHeightMobile();

// function autoHeightMobile() {
//   var windowWidth = $(window).width();
//   if (windowWidth < 500) {
//     // $('div.section').addClass('fp-auto-height');
//     $('footer').addClass('fp-auto-height');
//     $('footer').removeClass('h-50vh');
//     $('div.section-slider').addClass('h-100vh');
//     $('div.section').addClass('h-50vh');
//     $('div.section-slider').removeClass('h-50vh');
//     $(window).bind('mousewheel DOMMouseScroll', function(event){
// 		if($('.discover-more').hasClass('active')){
// 			console.log('tes active');
// 			$('.brandlogblue').removeClass('deactive');
// 			$('.brandlogblue').addClass('active');
// 			$('.brandlogwhite').addClass('deactive');
// 			$('.change-color').addClass('text-dark');
// 			$('.change-color').removeClass('text-white');
// 		}else{
// 			console.log('tes deactive');
// 			$('.brandlogblue').removeClass('active');
// 			$('.brandlogblue').addClass('deactive');
// 			$('.brandlogwhite').removeClass('deactive');
// 			$('.change-color').removeClass('text-dark');
// 			$('.change-color').addClass('text-white');
// 		}
// 	});
//   } else {
//     $('div.section').removeClass('fp-auto-height');
//     $('div.section-slider').removeClass('h-100vh');
//     $('div.section').removeClass('h-50vh');
//     $(window).bind('mousewheel DOMMouseScroll', function(event){
// 		if($('.fp-product').hasClass('active')){
// 			console.log('tes active');
// 			$('.brandlogblue').removeClass('deactive');
// 			$('.brandlogblue').addClass('active');
// 			$('.brandlogwhite').addClass('deactive');
// 			$('.change-color').addClass('text-dark');
// 			$('.change-color').removeClass('text-white');
// 		}else{
// 			console.log('tes deactive');
// 			$('.brandlogblue').removeClass('active');
// 			$('.brandlogblue').addClass('deactive');
// 			$('.brandlogwhite').removeClass('deactive');
// 			$('.change-color').removeClass('text-dark');
// 			$('.change-color').addClass('text-white');
// 		}
// 	});
    
//   }
// }
	
new fullpage('#fullpage', {
	//options here
	autoScrolling:true,
	anchors: ['section-1', 'section-2', 'section-3', 'section-4', 'section-5', 'section-6'],
	scrollHorizontally: true,
	// normalScrollElements: 'footer',
	scrollOverflow:true,
	menu: '#navbar-scroll',
	afterLoad: function(anchorLink, index){
	   if($('.fp-product.active')) {
	      $('.nav-link').addClass('border-extra');
	   }
	},
	onLeave: function(anchorLink, index){
	   if($('.fp-product.active')) {
	      $('.nav-link').removeClass('border-extra');
	   }
	}
});

//methods
fullpage_api.setAllowScrolling(true);

	// $(document).ready(function() {
	// 	$('#fullpage').fullpage({
	// 		//options here
	// 		autoScrolling:true,
	// 		anchors: ['section-1', 'section-2', 'section-3', 'section-4', 'section-5', 'section-6'],
	// 		scrollHorizontally: true,
	// 		normalScrollElements: 'footer',
	// 		menu: '#navbar-scroll'
	// 	});

	// 	//methods
	// 	$.fn.fullpage.setAllowScrolling(true);
	// });
	
</script>
@endsection
