@extends('template/layouts/main_scrollspy')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="section fp-table experience" id="experience-talasi">
	<div class="fp-tableCell">
		<div class="row justify-content-center">
            <div class="col-md-9 text-center prolog prologue-lebihdari100 text-white">
                {{-- <h3 class="mb-2 mb-md-5">We Have a Vision to</h3> --}}
								<h1 class="mb-5">Experience the origins of Talasi’s 100% organic, sustainable ingredients while taking part in empowerment and preservation of local communities with Talasi’s experiences made for you.</h1>
				{{-- <a href="{{url('frontend/experience-list')}}"><button class="btn-border-white px-3 py-2 pointer btn-letsgo mr-3">START</button></a> --}}
            </div>
	    </div>
	</div>
	<div class="letsgoarrow">
		<a href="#2">
			<img src="{{ asset('assets/img/down-button.png') }}" alt="">
		</a>
	</div>
</div>

<div class="section fp-table fp-product mb-0 pb-0" id="product-1">
	<div class="fp-tableCell">
		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-md-12 ">

					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-12 col-12 pl-lg-5 pr-lg-5 pl-md-4 pr-lg-4 pl-3 pr-3 mt-0 box-brand box-category" id="cate-1">
							<div class="overlaybg" style="background-image: url({{asset('assets/img/bence-balla-schottner-k3PN_7R3FcA-unsplash.png')}})"></div>
							<div class="overlay"></div>
							<div class="row justify-content-center ">
								<div class="col-md-10 text-center brand">
									<h1>Retreat</h1>
									<h5>Introduce You to Nature's Best</h5>
									<div class="desc-brand mb-3">
										<p>Watu is our curated collection of the best produce the origin has to offer, hand
											picked, processed at the origin, by the locals with
											leading natural innovation and sustainable reserch and development methods. Our processes
											preserves the natural qualities of the produce so you can truly experience nature's
											goodness straight from the origin form the hands of the empowered and enriched locals.
										</p>
									</div>
									<a href="{{url('frontend/experience/retreat')}}"><button class="btn-border-white px-3 py-2 pointer btn-letsgo d-none">Let's Go</button></a>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12 col-12 pl-lg-5 pr-lg-5 pl-md-4 pr-lg-4 pl-3 pr-3 mt-0  box-brand box-category" id="cate-2">
							<div class="overlaybg" style="background-image: url({{asset('assets/img/bence-balla-schottner-k3PN_7R3FcA-unsplash.png')}})"></div>
							<div class="overlay"></div>
							<div class="row justify-content-center">
								<div class="col-md-10 text-center brand">
									<h1>Factory Visit</h1>
									<h5>The One and Only Spirit of Bali </h5>
									<div class="desc-brand mb-3">
										<p>Starling is our line of fine sotju distilled
											at the hills of Bali at our own Wanagiri
											Estate Tabanan after years of meticulous search for the perfect
											tasting Spirit of Bali from hand picked and natural ingredients.
											Our passion for perfection to create The Spirit of Bali is our
											homage to showcase the best of nature luxuriously.
										</p>
									</div>
									<a href="{{url('frontend/experience/factory-visit')}}"><button class="btn-border-white px-3 py-2 pointer btn-letsgo d-none">Let's Go</button></a>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12 col-12 pl-lg-5 pr-lg-5 pl-md-4 pr-lg-4 pl-3 pr-3 mt-0  box-brand box-category" id="cate-3">
							<div class="overlaybg" style="background-image: url({{asset('assets/img/bence-balla-schottner-k3PN_7R3FcA-unsplash.png')}})"></div>
							<div class="overlay"></div>
							<div class="row justify-content-center">
								<div class="col-md-10 text-center brand">
									<h1>Camp with Us</h1>
									<h5>Feel Nature's Freshness </h5>
									<div class="desc-brand mb-3">
										<p>To-ye, sanskrit for water, is our fine of pure liquified natural product for you to
											Feel Nature's Freshness from Face Mist, Foot Mist, Traditional Oil and Room Mist.
											Our ingredients are extracted from the origin and extracted with state of the art technologies to capture nature's best.
												To-ye is a unique way to experience nature's best kept secret.
										</p>
									</div>
									<a href="{{url('frontend/experience/camp-us')}}"><button class="btn-border-white px-3 py-2 pointer btn-letsgo d-none">Let's Go</button></a>
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
	$("#cate-1").mouseenter(function() {
		$('.box-category').find(".overlaybg").removeClass('active');
		$('.box-category').find(".overlay").addClass('active');
		$('#cate-1').find(".overlaybg").addClass('active');
		$('#cate-1').find(".overlay").removeClass('active');
		$('#cate-1').find(".brand").css({'color':'#fff'});
		$('#cate-1').find(".btn-letsgo").removeClass('d-none');
		$('.headerzindex').addClass('active');
		$('.headerzindex').addClass('navbg-transparent');
		$('.headerzindex').addClass('border-bottom-0');
	});
	$("#cate-1").mouseleave(function() {
		$('.box-category').find(".overlaybg").removeClass('active');
		$('.box-category').find(".overlay").removeClass('active');
		$('#cate-1').find(".overlaybg").removeClass('active');
		$('#cate-1').find(".brand").css({'color':'#212529'});
		$('#cate-1').find(".btn-letsgo").addClass('d-none');
		$('.headerzindex').removeClass('active');
		$('.headerzindex').removeClass('navbg-transparent');
		$('.headerzindex').removeClass('border-bottom-0');
	});

	$("#cate-2").mouseenter(function() {
		$('.box-category').find(".overlaybg").removeClass('active');
		$('.box-category').find(".overlay").addClass('active');
		$('#cate-2').find(".overlaybg").addClass('active');
		$('#cate-2').find(".overlay").removeClass('active');
		$('#cate-2').find(".brand").css({'color':'#fff'});
		$('#cate-2').find(".btn-letsgo").removeClass('d-none');
		$('.headerzindex').addClass('active');
		$('.headerzindex').addClass('navbg-transparent');
		$('.headerzindex').addClass('border-bottom-0');
	});
	$("#cate-2").mouseleave(function() {
		$('.box-category').find(".overlaybg").removeClass('active');
		$('.box-category').find(".overlay").removeClass('active');
		$('#cate-2').find(".overlaybg").removeClass('active');
		$('#cate-2').find(".brand").css({'color':'#212529'});
		$('#cate-2').find(".btn-letsgo").addClass('d-none');
		$('.headerzindex').removeClass('active');
		$('.headerzindex').removeClass('navbg-transparent');
		$('.headerzindex').removeClass('border-bottom-0');
	});

	$("#cate-3").mouseenter(function() {
		$('.box-category').find(".overlaybg").removeClass('active');
		$('.box-category').find(".overlay").addClass('active');
		$('#cate-3').find(".overlaybg").addClass('active');
		$('#cate-3').find(".overlay").removeClass('active');
		$('#cate-3').find(".brand").css({'color':'#fff'});
		$('#cate-3').find(".btn-letsgo").removeClass('d-none');
		$('.headerzindex').addClass('active');
		$('.headerzindex').addClass('navbg-transparent');
		$('.headerzindex').addClass('border-bottom-0');
	});
	$("#cate-3").mouseleave(function() {
		$('.box-category').find(".overlaybg").removeClass('active');
		$('#cate-3').find(".overlaybg").removeClass('active');
		$('#cate-3').find(".overlaybg").removeClass('active');
		$('#cate-3').find(".brand").css({'color':'#212529'});
		$('#cate-3').find(".btn-letsgo").addClass('d-none');
		$('.headerzindex').removeClass('active');
		$('.headerzindex').removeClass('navbg-transparent');
		$('.headerzindex').removeClass('border-bottom-0');
	});

	$(document).ready(function() {
		$('#fullpage').fullpage({
			//options here
			anchors: ['1', '2', '3', '4', '5', '6'],
			autoScrolling:true,
			scrollHorizontally: true,
			// normalScrollElements: 'footer'
		});

		$(window).bind('mousewheel DOMMouseScroll', function(event){
			if (event.originalEvent.wheelDelta > 0 || event.originalEvent.detail < 0) {
				// scroll up
				$('.box-category').find(".overlaybg").removeClass('active');
				$('.box-category').find(".overlay").removeClass('active');
				$('.box-category').find(".brand").css({'color':'#212529'});
				// alert('x');
			}
		});
			var textLength = 	$('.prolog h1').html().length;
			if (textLength < 50) {
					$('.prolog').addClass('prologue-kurangdari50');
					$('.prolog').removeClass('prologue-kurangdari100');
					$('.prolog').removeClass('prologue-lebihdari100');
					$('.prolog').removeClass('prologue-lebihdari200')
			}else if(textLength < 100){
					$('.prolog').removeClass('prologue-kurangdari50');
					$('.prolog').addClass('prologue-kurangdari100');
					$('.prolog').removeClass('prologue-lebihdari100');
					$('.prolog').removeClass('prologue-lebihdari200');
			}else if(textLength > 100 || textLength < 200){
				$('.prolog').removeClass('prologue-kurangdari50');
					$('.prolog').removeClass('prologue-kurangdari100');
					$('.prolog').addClass('prologue-lebihdari100');
					$('.prolog').removeClass('prologue-lebihdari200');
			}else if(textLength > 200){
				$('.prolog').removeClass('prologue-kurangdari50');
					$('.prolog').removeClass('prologue-kurangdari100');
					$('.prolog').removeClass('prologue-lebihdari100');
					$('.prolog').addClass('prologue-lebihdari200');
			}
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
