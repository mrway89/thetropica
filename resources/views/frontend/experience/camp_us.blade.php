@extends('frontend/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="section fp-table fp-product detret" style="background: url({{asset($item->image)}});
background-size: cover !important;
background-position: center;
background-repeat:no-repeat !important;">
	<div class="fp-tableCell">
		<div class="row justify-content-center">

            <div class="col-md-9 col-10 text-white text-left">
                {{-- <h3 class="mb-2 mb-md-5">We Have a Vision to</h3> --}}
                <h1 style="margin-top: 20%;">{{ $item->{'title_' . $language} }}</h1>
                <div class="w-80 mt-mb-5 mt-3 mb-4">
                    <p>{{ $item->{'content_' . $language} }}</p>
                </div>
                <div class="row mt-4 justify-content-start">
					@foreach ($contents as $content)

						<div class="col-md-3 col-sm-6 col-12 mb-3">
							<a href="{{ route('frontend.experience.camps.detail', $content->slug) }}"><button class="btn-border-white w-100 px-3 py-2 pointer btn-letsgo mr-3">{{ $content->title_id }}</button></a>
						</div>

					@endforeach
					<div class="col-md-3 col-6 mb-3">
						<a href="{{ route('frontend.experience.index') }}#2"><button class="btn-border-white px-3 py-2 pointer btn-letsgo mr-3">BACK</button></a>
					</div>
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
