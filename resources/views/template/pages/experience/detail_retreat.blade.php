@extends('template/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="section fp-table detret" id="detret">
	<div class="fp-tableCell">
		<div class="row justify-content-center">
            
            <div class="col-md-9 text-white text-left">
                {{-- <h3 class="mb-2 mb-md-5">We Have a Vision to</h3> --}}
                <h1>Spoil Yourself with These Talasi Specials </h1>
                <div class="w-50 mt-5">
                    <p>Get a taste of how we convert the natural richness of Bali into nourishments for your body and soul with our factory visit and retreat experience.</p>
                </div>
                <div class="mt-4">             
					<a href="{{url('frontend/experience-list')}}"><button class="btn-border-white px-3 py-2 pointer btn-letsgo mr-3">BACK</button></a>
                    {{-- <a href="#"><button class="btn-border-white px-3 py-2 pointer btn-letsgo mr-3">OUR MENU</button></a>
                    <a href="#"><button class="btn-border-white px-3 py-2 pointer btn-letsgo d-none">EXPLORE TALASI’S SPACE</button></a> --}}
                </div>
                
            </div>
            
	    </div>
	</div>
	{{-- <div class="discover">
		<div class="discover-text">
        	<a href="{{ url('frontend/about') }}" class="text-white" title="">DISCOVER MORE</a>
        </div>
    </div> --}}
</div>
@endsection

@section('footer')
@include('template/includes/footer')
@endsection

@section('custom_js')
<script src="{{ asset('assets/js/fullpage.min.js')}}"></script>
<script>
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
	$(document).ready(function() {
		$('#fullpage').fullpage({
			//options here
			anchors: ['1', '2', '3', '4', '5', '6'],
			autoScrolling:true,
			scrollHorizontally: true,
			// normalScrollElements: 'footer'
		});

		//methods
		$.fn.fullpage.setAllowScrolling(true);
	});
	$(document).on('click', '#moveTo1', function(){
	  fullpage_api.moveTo('page1', 1);
	});

	$(document).on('click', '#moveTo2', function(){
	  fullpage_api.moveTo('page2', 2);
	});
    function change_bg(bg){
        $('#origin-1').css({"background":"url('"+ bg +"')",});
    }
</script>
@endsection
