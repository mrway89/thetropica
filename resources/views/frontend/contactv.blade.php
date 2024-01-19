@extends('frontend/layouts/main')

@section('custom_css')
<style>
.address p>a {
	color: white;
}
#form_contact .dropdown-toggle::after {
    display:none;
}
.despro p a {
	border-radius: 35px;
    padding: 3px 10px;
    background: #fff;
    margin-left: 10px;
    margin-right: 10px;
}

.despro div a {
	border-radius: 35px;
    padding: 3px 10px;
    background: #fff;
    margin-left: 10px;
    margin-right: 10px;
}
</style>
@endsection

@section('content')

<div class="section fp-table contact-about-area" id="about-{{ $posts->count() + 1 }}" style="background: url({{ asset($bgContact->url) }}?w=1920);">
	<div class="fp-tableCell px-3 align-items-center pb-5">
		<div class="container container-product">
			<div class="row justify-content-center pt-5">
		        <div class="col-md-5 text-white pt-mb-0 pt-5">
		        	<h1 class="mb-3">{{ $trans['about_contact_title'] }}</h1>
		        	<div class="address">
						{!! $other->address !!}
						<br>
						<table style="width:100%">
							<tr>
								<td width='120'><p>Phone</p></td>
								<td><p>{!! $other->phone !!}</p></td>
							</tr>
							<tr>
								<td width='120'><p>Whatsapp</td>
								<td><p>{!! $other->whatsapp !!}</p></td>
							</tr>
						</table>
		        		
		        	</div>

		        	<div class="social-about mt-3">
							@if ($company_twitter)
									<a href="{{ $company_twitter }}">
										<span class="fa-stack fa-larger">
									<i class="fa fa-circle fa-circle-about fa-stack-2x"></i>
									<i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
								</span>
									</a>
							@endif

							@if ($company_facebook)
									<a href="{{ $company_facebook }}">
										<span class="fa-stack fa-larger">
									<i class="fa fa-circle fa-circle-about fa-stack-2x"></i>
									<i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
								</span>
									</a>
							@endif

						@if ($company_instagram)
								<a href="{{ $company_instagram }}">
									<span class="fa-stack fa-larger">
								<i class="fa fa-circle fa-circle-about fa-stack-2x"></i>
								<i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
							</span>
								</a>
						@endif

						@if ($company_youtube)
								<a href="{{ $company_youtube }}">
									<span class="fa-stack fa-larger">
								<i class="fa fa-circle fa-circle-about fa-stack-2x"></i>
								<i class="fa fa-youtube-play fa-stack-1x fa-inverse"></i>
							</span>
								</a>
						@endif
		        	</div>

		        </div>

		        <div class="col-md-5 offset-md-2 mt-4 mt-md-0 offset-0">
					<form class="form-about" id="form_contact" action="{{ route('frontend.about.contact.post') }}" method="POST">
						{{ csrf_field() }}
			        	<input type="text" class="form-control" required id="name" placeholder="{{ $trans['about_form_name_placeholder'] }}" name="name">
			        	<input type="text" class="form-control" id="company" placeholder="{{ $trans['about_form_company_placeholder'] }}" name="company">
			        	<input type="email" class="form-control" required pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" id="email" placeholder="{{ $trans['about_form_email_placeholder'] }}" name="email">
			        	<input type="text" class="form-control" id="address" placeholder="{{ $trans['about_form_address_placeholder'] }}" name="address" required>
			        	<select class="custom-select" required id="select_country" placeholder="Country" name="country">
							@foreach ($countries as $country)
								<option value="{{ $country->id }}" {{ $country->id == 102 ? 'selected' : '' }}>{{ $country->name }}</option>
							@endforeach
			        	</select>
			        	<select class="custom-select" required id="select_city" placeholder="City" name="city">
							@foreach ($cities as $city)
								<option value="{{ $city->id }}">{{ $city->name }}</option>
							@endforeach
			        	</select>
			        	<input type="text" class="form-control" id="tel" placeholder="{{ $trans['about_form_tel_placeholder'] }}" name="phone" required>
			        	<textarea name="comment" required placeholder="{{ $trans['about_form_comment_placeholder'] }}" class="form-control pt-2" rows="4"></textarea>
                        <input type="hidden" name="recaptcha" id="recaptchaResponse">
						<button type="submit" class="btn btn-send-about pull-right mt-3">SEND</button>
			        </form>
					<div class="w-100 float-left text-white visible-768 mb-3">
						<h1 class="join">{{ $trans['about_join_title'] }}</h1>
						<div class="address mt-1">
								<p>{!! $trans['about_join_content'] !!}</p>
						</div>
					</div>
		        </div>
				
		    </div>
		</div>
	</div>
</div>

@endsection

@section('footer')
@include('frontend/includes/footer_scrollspy')
@endsection

@section('custom_js')
<?php /*
<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHAV3_SITEKEY') }}"></script>
  <script>
  grecaptcha.ready(function() {
      grecaptcha.execute('{{ env('RECAPTCHAV3_SITEKEY') }}', {action: 'contact'}).then(function(token) {
		var recaptchaResponse = document.getElementById('recaptchaResponse');
		recaptchaResponse.value = token;
      });
  });
</script>*/ ?>
{{-- <script src="{{ asset('assets/js/fullpage.min.js')}}"></script> --}}
<script>
	function readmore(){
		$('.desc-our').addClass('active');
		$('.readmore').addClass('d-none');
	}
	function validate(evt) {
		var theEvent = evt || window.event;

		// Handle paste
		if (theEvent.type === 'paste') {
			key = event.clipboardData.getData('text/plain');
		} else {
		// Handle key press
			var key = theEvent.keyCode || theEvent.which;
			key = String.fromCharCode(key);
		}
		var regex = /[0-9]|\./;
		if( !regex.test(key) ) {
		theEvent.returnValue = false;
		if(theEvent.preventDefault) theEvent.preventDefault();
		}
	}

    	$(document).ready(function() {
				var syncedSecondary = true;

				@foreach ($news as $i=>$post)
					var bigimage{{ $i }} = $("#big_carousel_{{ $i }}");
					var thumbs{{ $i }} = $("#thumbs_carousel_{{ $i }}");

					bigimage{{ $i }}
						.owlCarousel({
						items: 1,
						slideSpeed: 2000,
						nav: false,
						autoplay: false,
						dots: false,
						loop: false,
						responsiveRefreshRate: 200,
						navText: [
							'<img src="{{ asset('assets/img/arrow-left.png') }}" class="arrow-left" alt="">',
							'<img src="{{ asset('assets/img/arrow-right.png') }}" class="arrow-right" alt="">'
						]
					}).on("changed.owl.carousel", syncPosition{{ $i }});

					thumbs{{ $i }}
						.on("initialized.owl.carousel", function() {
						thumbs{{ $i }}
							.find(".owl-item")
							.eq(0)
							.addClass("current");
					})
						.owlCarousel({
						items: 7,
						dots: false,
						nav: false,
						navText: [
							'<i class="fa fa-arrow-left" aria-hidden="true"></i>',
							'<i class="fa fa-arrow-right" aria-hidden="true"></i>'
						],
						smartSpeed: 200,
						slideSpeed: 500,
						slideBy: 7,
						responsiveRefreshRate: 100
					})
						.on("changed.owl.carousel", syncPosition2{{ $i }});

					thumbs{{ $i }}.on("click", ".owl-item", function(e) {
						e.preventDefault();
						var number = $(this).index();
						bigimage{{ $i }}.data("owl.carousel").to(number, 300, true);
					});

					function syncPosition{{ $i }}(el) {
						//if loop is set to false, then you have to uncomment the next line
						//var current = el.item.index;

						//to disable loop, comment this block
						var count = el.item.count - 1;
						var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

						if (current < 0) {
							current = count;
						}
						if (current > count) {
							current = 0;
						}
						//to this
						thumbs{{ $i }}
							.find(".owl-item")
							.removeClass("current")
							.eq(current)
							.addClass("current");
						var onscreen = thumbs{{ $i }}.find(".owl-item.active").length - 1;
						var start = thumbs{{ $i }}
						.find(".owl-item.active")
						.first()
						.index();
						var end = thumbs{{ $i }}
						.find(".owl-item.active")
						.last()
						.index();

						if (current > end) {
							thumbs{{ $i }}.data("owl.carousel").to(current, 100, true);
						}
						if (current < start) {
							thumbs{{ $i }}.data("owl.carousel").to(current - onscreen, 100, true);
						}
					}

					function syncPosition2{{ $i }}(el) {
						if (syncedSecondary) {
							var number = el.item.index;
							bigimage{{ $i }}.data("owl.carousel").to(number, 100, true);
						}
					}
				@endforeach


			});


    	$(document).ready(function() {
    		// $('#fullpage').fullpage({
    		// 	//options here
    		// 	anchors: ['1', '2', '3', '4', '5', '6', '7'],
			// 	autoScrolling:true,
			// 	// normalScrollElements: 'footer',
			// 	scrollHorizontally: true,
			// 	scrollOverflow: true,
			// 	scrollOverflowReset: true,
			// 	scrollOverflowOptions: null,

    		// });

    		//methods
    		// $.fn.fullpage.setAllowScrolling(true);
			var textLength = $('.despro').html().length;
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



    	$("#select_country").change(function() {
    			var country    = $(this).val();
    			$('#select_city').attr('disabled', true);
    			$('#select_city').empty();

    			@if ($lang == 'en')
    			$('#select_city').append('<option selected>Loading...</option>');
    			@else
    			$('#select_city').append('<option selected>Memuat...</option>');
    			@endif

    			$.ajax({
    					url: "{{ route('frontend.get.country_city') }}",
    					data:
    					{
    							"country": country,
    							"_token" : "{{ csrf_token() }}"
    					},
    					type: 'POST',
    					dataType: 'json',
    					success: function (respond) {
    							$('#select_city').attr('disabled', false);
    							$('#select_city').empty();
    							var cities = respond.cities;
    							for (var i = 0; i < cities.length; i++) {
    								$('#select_city').append('<option value=\"' + cities[i].id + '\">' + cities[i].name + '</option>');
    							}
    					},

    					error: function (jqXHR, textStatus, errorThrown)
    					{
    							swal({
    									title: "Error!",
    									icon: "warning",
    									dangerMode: true,
    									button: "Close",
    							});
    					},
    			});
    	});

    	// slides
    	@foreach($posts as $post)
    	$(document).on('click', '#moveTo1', function(){
    	  fullpage_api.moveTo('page1', 1);
    	});
    	@endforeach
</script>
@endsection
