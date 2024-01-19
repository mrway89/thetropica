@extends('frontend/layouts/main')
@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/owl.carousel.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/owl.theme.default.min.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="section section-slider  fp-product h-100 d-flex position-relative">
	<div id="talasi-carousel" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			@foreach ($slideshow as $index=>$slide)
			<li data-target="#talasi-carousel" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
			@endforeach
		</ol>

		{{-- <div class="letsgo">
			<span>Let's Go</span>
		</div> --}}
		<div class="letsgoarrow">
			<a href="#2">
				<img src="{{ asset('assets/img/down-button.png') }}" alt="">
	    	</a>
		</div>
		<div class="carousel-inner home-carousel">

			@foreach ($slideshow as $index=>$slide)
			<div class="carousel-item {{ $index == 0 ? 'active' : '' }} ">

				<img src="{{ asset($slide->url) }}?w=1920" class="d-block w-100" alt="{{ 'talasi ' . $slide->{'title_' . $language} }}">
				<div class="carousel-caption">
					<h1>{{ $slide->{'title_' . $language} }}</h1>
					<p>{{ $slide->{'content_' . $language} }}</p>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>

<div class="section fp-table  fp-product about-home d-flex minh-100vh  position-relative" style="background: url({{ asset($about->url) }});">
	<div class="fp-tableCell px-3 minh-100vh align-items-center">
		<div class="row d-flex minh-100vh justify-content-center align-items-center">
			<div class="col-md-9 text-center text-white">
				<h2 class="mb-5" style="font-size: 3.2rem;">{{ ucwords($about->{'title_' . $language}) }}</h2>				
                                <h1 class="mb-5">{{ $about->{'content_' . $language} }}</h1>
			</div>
		</div>
		<!--<div class="letsgoarrow">
			<a href="#3">
				<img src="{{ asset('assets/img/down-button.png') }}" alt="">
			</a>
		</div>-->
	</div>
	{{-- <div class="discover">
		<div class="discover-text">
			<a href="{{ route('frontend.about') }}" class="text-white" title="">DISCOVER MORE</a>
		</div>
		<a href="#origin" title="">
        	<img src="{{ asset('assets/img/down-button.png') }}" alt="">
        </a>
	</div> --}}
</div>
<!--<div><br /><br /></div>
<div class="section fp-table fp-product  position-relative">
    	<div class="discover prod-browse">
        <a href="{{ route('frontend.product.brand') }}" title="" style="font-family: 'Times New Roman', Times, serif; font-size: 26px; color:#626262;">
        	<b>Natural, Pure, Honest</b>
        </a>
    </div>
</div>
<div><hr /></div>-->
<div class="section fp-table fp-product  position-relative">
		<!--<div class="w-100">
			<div class="row justify-content-center">
				<div class="col-md-8 text-center text-black desc-product-home mt-2 mt-md-5">
					{!! $product->{'content_' . $language} !!}
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-10 banner-product">
					<center>
						<img src="{{asset($product->url)}}" />
					</center>
				</div>
			</div>
		</div>-->
		<div class="container">
			<div class="row">
				<div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
					<div class="MultiCarousel-inner">
					@foreach ($list_slider_produk as $product)
						<div class="item">
							<div class="pad15">
								<a href="{{ route('frontend.product.detail', $product->slug) }}" href="{{ route('frontend.product.detail', $product->slug) }}"><img src="{{ asset($product->cover->url) }}" class="img-fluid" width="80px" /></a>
							</div>
						</div>
					@endforeach
					</div>
					<button class="btn btn-primary leftLst">&#129092;</button>
					<button class="btn btn-primary rightLst">&#129094;</button>
				</div>
			</div>
	</div>
</div>
 <div class="container container-product">
    <div class="row mb-3">
		<div class="col-md-3 col-sm-6 col-6 ">
			
		</div>
		<div class="col-md-4 col-sm-6 col-6 justify-content-center">
			<a href="{{ route('frontend.product.purchase') }}" title="">
				<div class="btn btn-tropical float-left-md float-right">Browse Our Products</div>
			</a>
		</div>
		<div class="col-md-3 col-sm-6 col-6">
			
		</div>
	</div>
</div>
<div class="section fp-table discover-home d-none" style="background: url({{ asset($origin->url) }});">
	<div class="fp-tableCell">
		<div class="row justify-content-center">
	        <div class="col-md-9 text-center text-white">
				<h1 class="mb-5">{{ $origin->{'title_' . $language} }}</h1>

	        </div>
	    </div>
	</div>
	<div class="discover discover-product">
		<a href="{{ route('frontend.origin.index') }}"><button type="button" class="btn btn-go">GO</button></a>
    </div>
</div>

@endsection
@if ($popup)
	@include('frontend/includes/modals/modal_welcoming')
@endif
@section('footer')
	@include('frontend/includes/footer_scrollspy')
@endsection

@section('custom_js')
{{-- <script src="{{ asset('assets/js/fullpage.min.js')}}"></script> --}}
<script src="{{ asset('assets/js/owl.carousel.min.js')}}"></script>
{{-- <script type="text/javascript" src="//downloads.mailchimp.com/js/signup-forms/popup/unique-methods/embed.js" data-dojo-config="usePlainJson: true, isDebug: false"></script><script type="text/javascript">window.dojoRequire(["mojo/signup-forms/Loader"], function(L) { L.start({"baseUrl":"mc.us4.list-manage.com","uuid":"938b45de076d1ef0c2c0bdaab","lid":"63be114cf1","uniqueMethods":true}) })</script> --}}
{{-- <script type="text/javascript" src="//downloads.mailchimp.com/js/signup-forms/popup/unique-methods/embed.js" data-dojo-config="usePlainJson: true, isDebug: false"></script><script type="text/javascript">window.dojoRequire(["mojo/signup-forms/Loader"], function(L) { L.start({"baseUrl":"mc.us4.list-manage.com","uuid":"938b45de076d1ef0c2c0bdaab","lid":"63be114cf1","uniqueMethods":true}) })</script> --}}
<script>

	// function setCookie(cname, cvalue, exdays) {
	// 	var d = new Date();
	// 	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	// 	var expires = "expires="+d.toUTCString();
	// 	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	// }

	// function getCookie(cname) {
	// 	var name = cname + "=";
	// 	var ca = document.cookie.split(';');
	// 	for(var i = 0; i < ca.length; i++) {
	// 		var c = ca[i];
	// 		while (c.charAt(0) == ' ') {
	// 			c = c.substring(1);
	// 		}
	// 		if (c.indexOf(name) == 0) {
	// 			return c.substring(name.length, c.length);
	// 		}
	// 	}
	// 	return "";
	// }

	// function checkPopup() {
	// 	var popup = getCookie("popup");
	// 	if (popup != 1) {
    //     	$('#welcoming').modal('show');
	// 	} else{
    //     	$('#welcoming').modal('hide');
	// 	}
	// }

	// $('#welcoming').on('hidden.bs.modal', function () {
	// 	var value = 1;
	// 	setCookie("popup", value, 1);
	// })

// new fullpage('#fullpage', {
// 	//options here
// 	autoScrolling:true,
// 	anchors: ['intro', 'about', 'product', 'footer'], //, 'origin'
// 	scrollHorizontally: true,
// 	// normalScrollElements: 'footer',
// 	menu: '#navbar-scroll',
// 	scrollHorizontally: true,
// 	scrollOverflow: true,
// 	scrollOverflowReset: true,
// 	scrollOverflowOptions: null,
// });

// fullpage_api.setAllowScrolling(true);

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
$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:3
        }
    }
})

$(document).ready(function() {
    // checkPopup();
	$(window).on('load',function(){
        $('#welcoming').modal('show');
		welcomePopResize()
    });

});

function welcomePopResize()
{
	setTimeout(function(){
		var width = $(".home-welcome-modal-img").width();
		$(".home-welcome-modal").css("max-width", width + "px");
	}, 1000)
}

$(document).ready(function () {
    var itemsMainDiv = ('.MultiCarousel');
    var itemsDiv = ('.MultiCarousel-inner');
    var itemWidth = "";

    $('.leftLst, .rightLst').click(function () {
        var condition = $(this).hasClass("leftLst");
        if (condition)
            click(0, this);
        else
            click(1, this)
    });

    ResCarouselSize();




    $(window).resize(function () {
        ResCarouselSize();
    });

    //this function define the size of the items
    function ResCarouselSize() {
        var incno = 0;
        var dataItems = ("data-items");
        var itemClass = ('.item');
        var id = 0;
        var btnParentSb = '';
        var itemsSplit = '';
        var sampwidth = $(itemsMainDiv).width();
        var bodyWidth = $('body').width();
        $(itemsDiv).each(function () {
            id = id + 1;
            var itemNumbers = $(this).find(itemClass).length;
            btnParentSb = $(this).parent().attr(dataItems);
            itemsSplit = btnParentSb.split(',');
            $(this).parent().attr("id", "MultiCarousel" + id);


            if (bodyWidth >= 1200) {
                incno = itemsSplit[3];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 992) {
                incno = itemsSplit[2];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 768) {
                incno = itemsSplit[1];
                itemWidth = sampwidth / incno;
            }
            else {
                incno = itemsSplit[0];
                itemWidth = sampwidth / incno;
            }
            $(this).css({ 'transform': 'translateX(0px)', 'width': itemWidth * itemNumbers });
            $(this).find(itemClass).each(function () {
                $(this).outerWidth(itemWidth);
            });

            $(".leftLst").addClass("over");
            $(".rightLst").removeClass("over");

        });
    }


    //this function used to move the items
    function ResCarousel(e, el, s) {
        var leftBtn = ('.leftLst');
        var rightBtn = ('.rightLst');
        var translateXval = '';
        var divStyle = $(el + ' ' + itemsDiv).css('transform');
        var values = divStyle.match(/-?[\d\.]+/g);
        var xds = Math.abs(values[4]);
        if (e == 0) {
            translateXval = parseInt(xds) - parseInt(itemWidth * s);
            $(el + ' ' + rightBtn).removeClass("over");

            if (translateXval <= itemWidth / 2) {
                translateXval = 0;
                $(el + ' ' + leftBtn).addClass("over");
            }
        }
        else if (e == 1) {
            var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
            translateXval = parseInt(xds) + parseInt(itemWidth * s);
            $(el + ' ' + leftBtn).removeClass("over");

            if (translateXval >= itemsCondition - itemWidth / 2) {
                translateXval = itemsCondition;
                $(el + ' ' + rightBtn).addClass("over");
            }
        }
        $(el + ' ' + itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
    }

    //It is used to get some elements from btn
    function click(ell, ee) {
        var Parent = "#" + $(ee).parent().attr("id");
        var slide = $(Parent).attr("data-slide");
        ResCarousel(ell, Parent, slide);
    }

});

</script>

@endsection
