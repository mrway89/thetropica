@extends('template/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="section fp-table about-area bg-prolog" style="background: url({{asset('assets/img/john-towner-117301-unsplash.jpg')}});">
	<div class="fp-tableCell">
		<div class="row justify-content-center">
	        <div class="col-md-12 text-center text-white">
	            <h3 class="mb-0">At Talasi, We Believe</h3>
	            <h1 class="mb-md-5 mb-2">We Do Better</h1>
	        </div>
	        <div class="col-md-8 text-center text-white p-smaller">

	            <p>Our experience for more than 30 years in the natural products, combined with our utmost integrity in conducting business, make us uniquely qualified to offer the premium honest natural products to our discerning consumers.</p>
                <p>Started In 2016, Talasi embarked a business proposition with a clear mission and purpose.</p>
                <p>We seek to do the following :</p>
	        </div>
	    </div>
	</div>
	<div class="discover discover-product">

        <a href="#2" title="">
        	<img src="{{ asset('assets/img/down-button.png') }}" alt="">
        </a>
    </div>
</div>
<div class="section fp-table fp-product mb-0 pb-0" id="product-2">
	<div class="fp-tableCell">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12 ">

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 mt-0 pl-lg-5 pr-lg-5 pl-md-4 pr-lg-4 pl-3 pr-3 box-brand box-category" id="cate-1">
                            <div class="overlay"></div>
                            <div class="row justify-content-center">
                                <div class="col-md-10 text-center brand">
                                    <div class="img-brand">
                                       <a href="{{url('frontend/product-list')}}"><img src="{{asset('assets/img/watu.jpg')}}"/></a>
                                    </div>
                                    <h5>Introduce You to Nature's Best</h5>
                                    <div class="desc-brand mb-5">
                                        <p>Watu is our curated collection of the best produce the origin has to offer, hand
                                            picked, processed at the origin, by the locals with
                                            leading natural innovation and sustainable reserch and development methods. Our processes
                                            preserves the natural qualities of the produce so you can truly experience nature's
                                            goodness straight from the origin form the hands of the empowered and enriched locals.
                                        </p>
                                    </div>
                                    <div class="share justify-content-center">
                                        <ul>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/twitter-logo-button.png')}}"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/facebook-logo-button.png')}}"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/instagram.png')}}"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/youtube.png')}}"/>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 pl-lg-5 mt-0 pr-lg-5 pl-md-4 pr-lg-4 pl-3 pr-3 box-brand box-category" id="cate-2">
                            <div class="overlay"></div>
                            <div class="row justify-content-center">
                                <div class="col-md-10 text-center brand">
                                    <div class="img-brand">
                                        <a href="{{url('frontend/product-list')}}"><img src="{{asset('assets/img/starling.jpg')}}"/></a>
                                    </div>
                                    <h5>The One and Only Spirit of Bali </h5>
                                    <div class="desc-brand  mb-5">
                                        <p>Starling is our line of fine sotju distilled
                                            at the hills of Bali at our own Wanagiri
                                            Estate Tabanan after years of meticulous search for the perfect
                                            tasting Spirit of Bali from hand picked and natural ingredients.
                                            Our passion for perfection to create The Spirit of Bali is our
                                            homage to showcase the best of nature luxuriously.
                                        </p>
                                    </div>
                                    <div class="share justify-content-center">
                                        <ul>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/twitter-logo-button.png')}}"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/facebook-logo-button.png')}}"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/instagram.png')}}"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/youtube.png')}}"/>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12  mt-0 pl-lg-5 pr-lg-5 pl-md-4 pr-lg-4 pl-3 pr-3 box-brand box-category" id="cate-3">
                            <div class="overlay"></div>
                            <div class="row justify-content-center">
                                <div class="col-md-10 text-center brand">
                                    <div class="img-brand">
                                        <a href="{{url('frontend/product-list')}}"><img src="{{asset('assets/img/toye.jpg')}}"/></a>
                                    </div>
                                    <h5>Feel Nature's Freshness </h5>
                                    <div class="desc-brand  mb-5">
                                        <p>To-ye, sanskrit for water, is our fine of pure liquified natural product for you to
                                            Feel Nature's Freshness from Face Mist, Foot Mist, Traditional Oil and Room Mist.
                                            Our ingredients are extracted from the origin and extracted with state of the art technologies to capture nature's best.
                                             To-ye is a unique way to experience nature's best kept secret.
                                        </p>
                                    </div>
                                    <div class="share justify-content-center">
                                        <ul>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/twitter-logo-button.png')}}"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/facebook-logo-button.png')}}"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/instagram.png')}}"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/youtube.png')}}"/>
                                                </a>
                                            </li>
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
</div>

<div class="section fp-table fp-product" id="product-3">
	<div class="fp-tableCell">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12 ">

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 mt-0 pl-lg-5 pr-lg-5 pl-md-4 pr-lg-4 pl-3 pr-3 box-brand box-category" id="cate-4">
                            <div class="overlay"></div>
                            <div class="row justify-content-center">
                                <div class="col-md-10 text-center brand">
                                    <div class="img-brand">
                                       <a href="{{url('frontend/product-list')}}"><img src="{{asset('assets/img/watu.jpg')}}"/></a>
                                    </div>
                                    <h5>Introduce You to Nature's Best</h5>
                                    <div class="desc-brand mb-5">
                                        <p>Watu is our curated collection of the best produce the origin has to offer, hand
                                            picked, processed at the origin, by the locals with
                                            leading natural innovation and sustainable reserch and development methods. Our processes
                                            preserves the natural qualities of the produce so you can truly experience nature's
                                            goodness straight from the origin form the hands of the empowered and enriched locals.
                                        </p>
                                    </div>
                                    <div class="share justify-content-center">
                                        <ul>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/twitter-logo-button.png')}}"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/facebook-logo-button.png')}}"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/instagram.png')}}"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/youtube.png')}}"/>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 mt-0 pl-lg-5 pr-lg-5 pl-md-4 pr-lg-4 pl-3 pr-3 box-brand box-category" id="cate-5">
                            <div class="overlay"></div>
                            <div class="row justify-content-center">
                                <div class="col-md-10 text-center brand">
                                    <div class="img-brand">
                                        <a href="{{url('frontend/product-list')}}"><img src="{{asset('assets/img/starling.jpg')}}"/></a>
                                    </div>
                                    <h5>The One and Only Spirit of Bali </h5>
                                    <div class="desc-brand  mb-5">
                                        <p>Starling is our line of fine sotju distilled
                                            at the hills of Bali at our own Wanagiri
                                            Estate Tabanan after years of meticulous search for the perfect
                                            tasting Spirit of Bali from hand picked and natural ingredients.
                                            Our passion for perfection to create The Spirit of Bali is our
                                            homage to showcase the best of nature luxuriously.
                                        </p>
                                    </div>
                                    <div class="share justify-content-center">
                                        <ul>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/twitter-logo-button.png')}}"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/facebook-logo-button.png')}}"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/instagram.png')}}"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/youtube.png')}}"/>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 mt-0 pl-lg-5 pr-lg-5 pl-md-4 pr-lg-4 pl-3 pr-3 box-brand box-category" id="cate-6">
                            <div class="overlay"></div>
                            <div class="row justify-content-center">
                                <div class="col-md-10 text-center brand">
                                    <div class="img-brand">
                                        <a href="{{url('frontend/product-list')}}"><img src="{{asset('assets/img/toye.jpg')}}"/></a>
                                    </div>
                                    <h5>Feel Nature's Freshness </h5>
                                    <div class="desc-brand  mb-5">
                                        <p>To-ye, sanskrit for water, is our fine of pure liquified natural product for you to
                                            Feel Nature's Freshness from Face Mist, Foot Mist, Traditional Oil and Room Mist.
                                            Our ingredients are extracted from the origin and extracted with state of the art technologies to capture nature's best.
                                             To-ye is a unique way to experience nature's best kept secret.
                                        </p>
                                    </div>
                                    <div class="share justify-content-center">
                                        <ul>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/twitter-logo-button.png')}}"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/facebook-logo-button.png')}}"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/instagram.png')}}"/>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="{{asset('assets/img/youtube.png')}}"/>
                                                </a>
                                            </li>
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
</div>
@endsection

@section('footer')
@include('template/includes/footer')
@endsection

@section('custom_js')
<script src="{{ asset('assets/js/fullpage.min.js')}}"></script>
<script>
	$(document).ready(function() {
		$('#fullpage').fullpage({
			//options here
			anchors: ['1', '2', '3', '4', '5', '6'],
			autoScrolling:true,
			scrollHorizontally: true,
			normalScrollElements: 'footer'
		});

	// 	//methods
		$.fn.fullpage.setAllowScrolling(true);
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
</script>
@endsection
