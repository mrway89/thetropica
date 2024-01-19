@extends('frontend/layouts/main')

@section('custom_css')

@endsection

@section('content')
<div class="section fp-table fp-product about-area bg-prolog" style="background: url({{asset($content->url)}});">
	<div class="fp-tableCell">
		<div class="row justify-content-center pt-mb-0 pt-5">
	        <div class="col-md-12  text-center text-white">
	            <h3 class="mb-0">{{ $content->{'title_' . $language} }}</h3>
	            <h1 class="mb-md-5 mb-2">{{ $content->{'subtitle_' . $language} }}</h1>
	        </div>
	        <div class="col-md-8 text-center text-white despro p-smaller">
	            {!! $content->{'content_' . $language} !!}
            </div>
	    </div>
	</div>
	<div class="discover discover-product">

        <a href="#2" title="">
        	<img src="{{ asset('assets/img/down-button.png') }}" alt="">
        </a>
    </div>
</div>
@foreach ($brands as $j => $brand)
<div class="section fp-table fp-product mb-0 pb-0 d-md-none d-flex mobilepro">
    <div class="fp-tableCell">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12 ">
                    <div class="mt-0 pl-lg-5 pr-lg-5 pl-md-4 pr-lg-4 pl-3 pr-3 box-brand box-category" id="catemb-{{ $j +1 }}">
                        <div class="overlay"></div>
                        <div class="row justify-content-center">
                            <div class="col-md-10 text-center brand">
                                <div class="img-brand">
                                    @php
                                        $myproduct = \App\Product::where('brand_id', $brand->id)->where('is_active', 1)->orderBy('created_at', 'ASC')->first();
                                    @endphp
                                    @if ($myproduct)
                                    <a href="{{ route('frontend.product.detail', $myproduct->slug) }}">
                                        @if ($brand->logo)
                                        <img src="{{asset($brand->logo)}}" alt="Talasi-{{ $brand->name }}" title="Talasi {{ $brand->name }}" />
                                        @endif
                                    </a>
                                    @else
                                        @if ($brand->logo)
                                        <img src="{{asset($brand->logo)}}" alt="Talasi-{{ $brand->name }}" title="Talasi {{ $brand->name }}" />
                                        @endif
                                    @endif
                                </div>
                                <h5>{{ $brand->{'title_' . $language} }}</h5>
                                <div class="desc-brand mb-5">
                                    <p>
                                        {{ $brand->{'description_' . $language} }}
                                    </p>
                                </div>
                                <div class="share justify-content-center">
                                    <ul>
                                        @if ($brand->twitter)
                                        <li>
                                            <a href="{{ $brand->twitter }}" target="_blank">
                                                <img src="{{asset('assets/img/twitter-logo-button.png')}}"/>
                                            </a>
                                        </li>
                                        @endif
                                        @if ($brand->facebook)
                                        <li>
                                            <a href="{{ $brand->facebook }}" target="_blank">
                                                <img src="{{asset('assets/img/facebook-logo-button.png')}}"/>
                                            </a>
                                        </li>

                                        @endif
                                        @if ($brand->instagram)
                                        <li>
                                            <a href="{{ $brand->instagram }}" target="_blank">
                                                <img src="{{asset('assets/img/instagram.png')}}"/>
                                            </a>
                                        </li>
                                        @endif
                                        @if ($brand->youtube)
                                        <li>
                                            <a href="{{ $brand->youtube }}" target="_blank">
                                                <img src="{{asset('assets/img/youtube.png')}}"/>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach ($brands->chunk(3) as $chunk)
    <div class="section fp-table fp-product d-md-flex d-sm-none d-none desktop">
        <div class="fp-tableCell">

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12 ">

                        <div class="row">
                            @foreach ($chunk as $i => $brand)
                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 mt-0 pl-lg-5 pr-lg-5 pl-md-4 pr-lg-4 pl-3 pr-3 box-brand box-category" id="cate-{{ $i +1 }}">
                                    <div class="overlay"></div>
                                    <div class="row justify-content-center">
                                        <div class="col-md-10 text-center brand">
                                            <div class="img-brand">
                                                @php
                                                    $myproduct = \App\Product::where('brand_id', $brand->id)->where('is_active', 1)->orderBy('created_at', 'ASC')->first();
                                                @endphp
                                                @if ($myproduct)
                                                <a href="{{ route('frontend.product.detail', $myproduct->slug) }}">
                                                    @if ($brand->logo)
                                                    <img src="{{asset($brand->logo)}}" alt="Talasi-{{ $brand->name }}" title="Talasi {{ $brand->name }}" />
                                                    @endif
                                                </a>
                                                @else
                                                    @if ($brand->logo)
                                                    <img src="{{asset($brand->logo)}}" alt="Talasi-{{ $brand->name }}" title="Talasi {{ $brand->name }}" />
                                                    @endif
                                                @endif
                                            </div>
                                            <h5>{{ $brand->{'title_' . $language} }}</h5>
                                            <div class="desc-brand mb-5">
                                                <p>
                                                    {{ $brand->{'description_' . $language} }}
                                                </p>
                                            </div>
                                            <div class="share justify-content-center">
                                                <ul>
                                                    @if ($brand->twitter)
                                                    <li>
                                                        <a href="{{ $brand->twitter }}" target="_blank">
                                                            <img src="{{asset('assets/img/twitter-logo-button.png')}}"/>
                                                        </a>
                                                    </li>
                                                    @endif
                                                    @if ($brand->facebook)
                                                    <li>
                                                        <a href="{{ $brand->facebook }}" target="_blank">
                                                            <img src="{{asset('assets/img/facebook-logo-button.png')}}"/>
                                                        </a>
                                                    </li>

                                                    @endif
                                                    @if ($brand->instagram)
                                                    <li>
                                                        <a href="{{ $brand->instagram }}" target="_blank">
                                                            <img src="{{asset('assets/img/instagram.png')}}"/>
                                                        </a>
                                                    </li>
                                                    @endif
                                                    @if ($brand->youtube)
                                                    <li>
                                                        <a href="{{ $brand->youtube }}" target="_blank">
                                                            <img src="{{asset('assets/img/youtube.png')}}"/>
                                                        </a>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endforeach
@endsection

@section('footer')
@include('frontend/includes/footer')
@endsection

@section('custom_js')
<script src="{{ asset('assets/js/fullpage.min.js')}}"></script>
<script>
	$(document).ready(function() {
        var isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;

        if (isMobile) {
            $('.desktop').remove();
        }

        var isDesktop = window.matchMedia("only screen and (min-width: 760px)").matches;

        if (isDesktop) {
            $('.mobilepro').remove();
        }
		$('#fullpage').fullpage({
			//options here
			anchors: ['1', '2', '3', '4', '5', '6'],
			autoScrolling:true,
			scrollHorizontally: true,
			// normalScrollElements: 'footer'
		});

	// 	//methods
		$.fn.fullpage.setAllowScrolling(true);
        var textLength = $('.despro').html().length;
        // console.log(textLength);
        if (textLength < 100) {
        $('.despro').addClass('desprolog-kurangdari100');
            $('.despro').removeClass('desprolog-100-200');
            $('.despro').removeClass('desprolog-200-300');
            $('.despro').removeClass('desprolog-300-400');
            $('.despro').removeClass('desprolog-lebihdari400');
            $('.despro').removeClass('desprolog-lebihdari500');
        }else if(textLength > 100 && textLength < 200){
            $('.despro').removeClass('desprolog-kurangdari100');
            $('.despro').addClass('desprolog-100-200');
            $('.despro').removeClass('desprolog-200-300');
            $('.despro').removeClass('desprolog-300-400');
            $('.despro').removeClass('desprolog-lebihdari400');
            $('.despro').removeClass('desprolog-lebihdari500');
        }else if(textLength > 200 && textLength < 300){
            $('.despro').removeClass('desprolog-kurangdari100');
            $('.despro').removeClass('desprolog-100-200');
            $('.despro').addClass('desprolog-200-300');
            $('.despro').removeClass('desprolog-300-400');
            $('.despro').removeClass('desprolog-lebihdari400');
            $('.despro').removeClass('desprolog-lebihdari500');
        }else if(textLength > 300 && textLength < 400){
            $('.despro').removeClass('desprolog-kurangdari100');
            $('.despro').removeClass('desprolog-100-200');
            $('.despro').removeClass('desprolog-200-300');
            $('.despro').addClass('desprolog-300-400');
            $('.despro').removeClass('desprolog-lebihdari400');
            $('.despro').removeClass('desprolog-lebihdari500');
        }else if(textLength > 400 && textLength < 500){
            $('.despro').removeClass('desprolog-kurangdari100');
            $('.despro').removeClass('desprolog-100-200');
            $('.despro').removeClass('desprolog-200-300');
            $('.despro').removeClass('desprolog-300-400');
            $('.despro').addClass('desprolog-400-500');
        }else if(textLength > 500){
            $('.despro').removeClass('desprolog-kurangdari100');
            $('.despro').removeClass('desprolog-100-200');
            $('.despro').removeClass('desprolog-200-300');
            $('.despro').removeClass('desprolog-300-400');
            $('.despro').removeClass('desprolog-400-500');
            $('.despro').addClass('desprolog-lebihdari500');
        }
	});
	$(document).on('click', '#moveTo1', function(){
	  fullpage_api.moveTo('page1', 1);
	});

	$(document).on('click', '#moveTo2', function(){
	  fullpage_api.moveTo('page2', 2);
	});
    $(window).bind('mousewheel DOMMouseScroll', function(event){
		if($('.fp-product').hasClass('active') ||  $('.fp-footer').hasClass('active')){
			$('.brandlogblue').removeClass('deactive');
			$('.brandlogblue').addClass('active');
			$('.brandlogwhite').addClass('deactive');
			$('.change-color').addClass('text-dark');
			$('.change-color').removeClass('text-white');
		}else{
			$('.brandlogblue').removeClass('active');
			$('.brandlogblue').addClass('deactive');
			$('.brandlogwhite').removeClass('deactive');
			$('.change-color').removeClass('text-dark');
			$('.change-color').addClass('text-white');
		}
	});
    $("#cate-1").mouseenter(function() {
        $('.box-category').find(".overlay").addClass('active');
        $('#cate-1').find(".overlay").removeClass('active');
        $('.headerzindex').addClass('active');
    });
    $("#cate-1").mouseleave(function() {
        $('.box-category').find(".overlay").removeClass('active');
        $('#cate-1').find(".overlay").removeClass('active');
        $('.headerzindex').removeClass('active');
    });

    $("#cate-2").mouseenter(function() {
        $('.box-category').find(".overlay").addClass('active');
        $('#cate-2').find(".overlay").removeClass('active');
        $('.headerzindex').addClass('active');
    });
    $("#cate-2").mouseleave(function() {
        $('.box-category').find(".overlay").removeClass('active');
        $('#cate-2').find(".overlay").removeClass('active');
        $('.headerzindex').removeClass('active');
    });

    $("#cate-3").mouseenter(function() {
        $('.box-category').find(".overlay").addClass('active');
        $('#cate-3').find(".overlay").removeClass('active');
        $('.headerzindex').addClass('active');
    });
    $("#cate-3").mouseleave(function() {
        $('.box-category').find(".overlay").removeClass('active');
        $('#cate-3').find(".overlay").removeClass('active');
        $('.headerzindex').removeClass('active');
    });

    $("#cate-4").mouseenter(function() {
        $('.box-category').find(".overlay").addClass('active');
        $('#cate-4').find(".overlay").removeClass('active');
        $('.headerzindex').addClass('active');
    });
    $("#cate-4").mouseleave(function() {
        $('.box-category').find(".overlay").removeClass('active');
        $('#cate-4').find(".overlay").removeClass('active');
        $('.headerzindex').removeClass('active');
    });

    $("#cate-5").mouseenter(function() {
        $('.box-category').find(".overlay").addClass('active');
        $('#cate-5').find(".overlay").removeClass('active');
        $('.headerzindex').addClass('active');
    });
    $("#cate-5").mouseleave(function() {
        $('.box-category').find(".overlay").removeClass('active');
        $('#cate-5').find(".overlay").removeClass('active');
        $('.headerzindex').removeClass('active');
    });

    $("#cate-6").mouseenter(function() {
        $('.box-category').find(".overlay").addClass('active');
        $('#cate-6').find(".overlay").removeClass('active');
        $('.headerzindex').addClass('active');
    });
    $("#cate-6").mouseleave(function() {
        $('.box-category').find(".overlay").removeClass('active');
        $('#cate-6').find(".overlay").removeClass('active');
        $('.headerzindex').removeClass('active');
    });
    // mobile
    $("#catemb-1").mouseenter(function() {
        $('.box-category').find(".overlay").addClass('active');
        $('#catemb-1').find(".overlay").removeClass('active');
        $('.headerzindex').addClass('active');
    });
    $("#catemb-1").mouseleave(function() {
        $('.box-category').find(".overlay").removeClass('active');
        $('#catemb-1').find(".overlay").removeClass('active');
        $('.headerzindex').removeClass('active');
    });

    $("#catemb-2").mouseenter(function() {
        $('.box-category').find(".overlay").addClass('active');
        $('#catemb-2').find(".overlay").removeClass('active');
        $('.headerzindex').addClass('active');
    });
    $("#catemb-2").mouseleave(function() {
        $('.box-category').find(".overlay").removeClass('active');
        $('#catemb-2').find(".overlay").removeClass('active');
        $('.headerzindex').removeClass('active');
    });

    $("#catemb-3").mouseenter(function() {
        $('.box-category').find(".overlay").addClass('active');
        $('#catemb-3').find(".overlay").removeClass('active');
        $('.headerzindex').addClass('active');
    });
    $("#catemb-3").mouseleave(function() {
        $('.box-category').find(".overlay").removeClass('active');
        $('#catemb-3').find(".overlay").removeClass('active');
        $('.headerzindex').removeClass('active');
    });

    $("#catemb-4").mouseenter(function() {
        $('.box-category').find(".overlay").addClass('active');
        $('#catemb-4').find(".overlay").removeClass('active');
        $('.headerzindex').addClass('active');
    });
    $("#catemb-4").mouseleave(function() {
        $('.box-category').find(".overlay").removeClass('active');
        $('#catemb-4').find(".overlay").removeClass('active');
        $('.headerzindex').removeClass('active');
    });

    $("#catemb-5").mouseenter(function() {
        $('.box-category').find(".overlay").addClass('active');
        $('#catemb-5').find(".overlay").removeClass('active');
        $('.headerzindex').addClass('active');
    });
    $("#catemb-5").mouseleave(function() {
        $('.box-category').find(".overlay").removeClass('active');
        $('#catemb-5').find(".overlay").removeClass('active');
        $('.headerzindex').removeClass('active');
    });

    $("#catemb-6").mouseenter(function() {
        $('.box-category').find(".overlay").addClass('active');
        $('#catemb-6').find(".overlay").removeClass('active');
        $('.headerzindex').addClass('active');
    });
    $("#catemb-6").mouseleave(function() {
        $('.box-category').find(".overlay").removeClass('active');
        $('#catemb-6').find(".overlay").removeClass('active');
        $('.headerzindex').removeClass('active');
    });
</script>
@endsection
