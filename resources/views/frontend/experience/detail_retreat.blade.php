@extends('frontend/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="section fp-table detret fp-product" id="detret" style="background:url({{ asset($content->image) }})">
	<div class="fp-tableCell">
		<div class="row justify-content-center">

            <div class="col-md-9 col-10 text-white text-left">
                {{-- <h3 class="mb-2 mb-md-5">We Have a Vision to</h3> --}}
                <h1 style="margin-top: 20%;">{{ $content->{'title_' . $language} }}</h1>
                <div class="w-80 mt-md-5 mt-3">
                    <p>{{ $content->{'content_' . $language} }}</p>
                </div>
                <div class="mt-4">
					<a href="{{ route('frontend.experience.list') }}"><button class="btn-border-white px-3 py-2 pointer btn-letsgo mr-3">BACK</button></a>
                    {{-- <a href="#"><button class="btn-border-white px-3 py-2 pointer btn-letsgo mr-3">OUR MENU</button></a>
                    <a href="#"><button class="btn-border-white px-3 py-2 pointer btn-letsgo d-none">EXPLORE TALASI’S SPACE</button></a> --}}
                </div>

            </div>

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
