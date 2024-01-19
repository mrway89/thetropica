@extends('frontend/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="section section-slider fp-product">
	<div id="talasi-carousel" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			@foreach ($contents as $i => $content)
			  <li data-target="#talasi-carousel" data-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}"></li>
			@endforeach
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

			@foreach ($contents as $i => $content)

				<div class="carousel-item carousel-item-experience {{ $i == 0 ? 'active' : '' }}">
					<img src="{{ asset($content->image) }}" class="d-block w-100" alt="...">
					<div class="carousel-caption caption-experience-slide text-left">
						<h1>{{ $content->{'title_' . $language} }}</h1>
						<div class="d-flex mb-1"><p>{{ $content->{'content_' . $language} }}</p></div>
						<div class="mt-md-4 mt-5">
							<a href="{{ route('frontend.experience.retreat.detail', $content->slug)}}"><button class="btn-border-white px-3 py-2 pointer btn-letsgo mr-3">OUR MENU</button></a>
							<a href="#"><button class="btn-border-white px-3 py-2 pointer btn-letsgo d-none">EXPLORE TALASI’S SPACE</button></a>
							<a href="{{ route('frontend.experience.index') }}#2"><button class="btn-border-white px-3 py-2 pointer btn-letsgo mr-3">BACK</button></a>
						</div>
					</div>
				</div>

			@endforeach

		</div>
	</div>
	<div class="letsgoarrow">
		<a href="#2">
			<img src="{{ asset('assets/img/down-button.png') }}" alt="">
		</a>
	</div>
</div>

@endsection

@section('footer')
@include('frontend/includes/footer')
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
