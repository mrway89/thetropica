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
	      <li data-target="#talasi-carousel" data-slide-to="3"></li>
	      <li data-target="#talasi-carousel" data-slide-to="4"></li>
	      <li data-target="#talasi-carousel" data-slide-to="5"></li>
	    </ol>
	    {{-- <div class="letsgo">
	    	<span>Let's Go</span>
	    </div>
	    <div class="letsgoarrow">
	    	<a href="#2">
		    	<img src="{{ asset('assets/img/down-button.png') }}" alt="">
		    </a>
	    </div> --}}
        <div class="carousel-inner home-carousel">
            <div class="carousel-item active">
                <img src="{{ asset('assets/img/bali-tangguntitivilla-22-800x530.png') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption caption-experience-slide text-left">
                    <h1>Experience True Sustainable Food</h1>
                    <p>Get a taste of how we convert the natural richness of Bali into nourishments for your body and soul with our factory visit and retreat experience.</p>
                    <div class="mt-4">             
                        <a href="{{url('frontend/experience/camp-us')}}"><button class="btn-border-white px-3 py-2 pointer btn-letsgo mr-3">EXPLORE OTHER CAMP</button></a>
                        {{-- <a href="#"><button class="btn-border-white px-3 py-2 pointer btn-letsgo d-none">EXPLORE TALASI’S SPACE</button></a> --}}
                    </div>
                </div>
            </div>
            
			<div class="carousel-item">
                <img src="{{ asset('assets/img/a-pair-of-mountain-bikers-riding-in-the-dolomites-range-in-north-eastern-italy.png') }}" class="d-block w-100" alt="...">
				<div class="carousel-caption caption-experience-slide text-left">
                    <h1>Mountain Biking</h1>
                    <h4>Spend The Day Exploring Our Tabanan Factory </h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis varius, nunc tincidunt iaculis dictum, orci urna scelerisque eros, vitae eleifend nunc elit et dui. Suspendisse varius tempor ullamcorper. Phasellus</p>
                    <div class="mt-4">             
                        <a href="{{url('frontend/experience/camp-us')}}"><button class="btn-border-white px-3 py-2 pointer btn-letsgo mr-3">EXPLORE OTHER CAMP</button></a>
                        {{-- <a href="#"><button class="btn-border-white px-3 py-2 pointer btn-letsgo d-none">EXPLORE TALASI’S SPACE</button></a> --}}
                    </div>
				</div>
            </div>
            
			<div class="carousel-item">
                <img src="{{ asset('assets/img/Hiking-2___Super_Portrait.png') }}" class="d-block w-100" alt="...">
				<div class="carousel-caption caption-experience-slide text-left">
                    <h1>Mountain Hiking</h1>
                    <h4>Spend The Day Exploring Our Tabanan Factory </h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis varius, nunc tincidunt iaculis dictum, orci urna scelerisque eros, vitae eleifend nunc elit et dui. Suspendisse varius tempor ullamcorper. Phasellus</p>
                    <div class="mt-4">             
                        <a href="{{url('frontend/experience/camp-us')}}"><button class="btn-border-white px-3 py-2 pointer btn-letsgo mr-3">EXPLORE OTHER CAMP</button></a>
                        {{-- <a href="#"><button class="btn-border-white px-3 py-2 pointer btn-letsgo d-none">EXPLORE TALASI’S SPACE</button></a> --}}
                    </div>
				</div>
            </div>

			<div class="carousel-item">
                <img src="{{ asset('assets/img/45069699-couple-in-camping-with-campfire-at-night.png') }}" class="d-block w-100" alt="...">
				<div class="carousel-caption caption-experience-slide text-left">
                    <h1>Night Camp</h1>
                    <h4>Spend The Day Exploring Our Tabanan Factory </h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis varius, nunc tincidunt iaculis dictum, orci urna scelerisque eros, vitae eleifend nunc elit et dui. Suspendisse varius tempor ullamcorper. Phasellus</p>
                    <div class="mt-4">             
                        <a href="{{url('frontend/experience/camp-us')}}"><button class="btn-border-white px-3 py-2 pointer btn-letsgo mr-3">EXPLORE OTHER CAMP</button></a>
                        {{-- <a href="#"><button class="btn-border-white px-3 py-2 pointer btn-letsgo d-none">EXPLORE TALASI’S SPACE</button></a> --}}
                    </div>
				</div>
            </div>

			<div class="carousel-item">
                <img src="{{ asset('assets/img/air-terjun-tanggedu-sumba_20181006_162723.png') }}" class="d-block w-100" alt="...">
				<div class="carousel-caption caption-experience-slide text-left">
                    <h1>Waterfall Tanggedu</h1>
                    <h4>Spend The Day Exploring Our Tabanan Factory </h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis varius, nunc tincidunt iaculis dictum, orci urna scelerisque eros, vitae eleifend nunc elit et dui. Suspendisse varius tempor ullamcorper. Phasellus</p>
                    <div class="mt-4">             
                        <a href="{{url('frontend/experience/camp-us')}}"><button class="btn-border-white px-3 py-2 pointer btn-letsgo mr-3">EXPLORE OTHER CAMP</button></a>
                        {{-- <a href="#"><button class="btn-border-white px-3 py-2 pointer btn-letsgo d-none">EXPLORE TALASI’S SPACE</button></a> --}}
                    </div>
				</div>
            </div>

			<div class="carousel-item">
                <img src="{{ asset('assets/img/Villa.png') }}" class="d-block w-100" alt="...">
				<div class="carousel-caption caption-experience-slide text-left">
                    <h1>Enjoy the</h1>
                    <h4>Spend The Day Exploring Our Tabanan Factory </h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis varius, nunc tincidunt iaculis dictum, orci urna scelerisque eros, vitae eleifend nunc elit et dui. Suspendisse varius tempor ullamcorper. Phasellus</p>
                    <div class="mt-4">             
                        <a href="{{url('frontend/experience/camp-us')}}"><button class="btn-border-white px-3 py-2 pointer btn-letsgo mr-3">EXPLORE OTHER CAMP</button></a>
                        {{-- <a href="#"><button class="btn-border-white px-3 py-2 pointer btn-letsgo d-none">EXPLORE TALASI’S SPACE</button></a> --}}
                    </div>
				</div>
            </div>
            
		</div>
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
		console.log('tes active');
		$('.brandlogblue').removeClass('deactive');
		$('.brandlogblue').addClass('active');
		$('.brandlogwhite').addClass('deactive');
		$('.change-color').addClass('text-dark');
		$('.change-color').removeClass('text-white');
	}else{
		console.log('tes deactive');
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
