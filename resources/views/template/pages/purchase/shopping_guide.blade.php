@extends('template/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-area">
	<div class="container container-product pt-mb-0 pt-3">
		<div class="row">
			<div class="col-md-9 offset-md-3 pt-3 hidden-768">
				<h3 class="bold-300 mb-4 pt-md-5 pt-0">Shopping Guide</h3>
			</div>
			@include('template/pages/purchase/includes/sidebar_purchase')
			<div class="col-sm-6 col-6 visible-768">
                <form>
                    <select id="select-shoppingguide" class="custom-select select-search select-shoppingguide float-left w-100 mb-5 mr-2">
                        <option value='0'>First Time Buyer</option>
				        <option value='1'>Profile</option>
				        <option value='2'>Messages</option>
				        <option value='3'>Settings</option>
                    </select>
                </form>
            </div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12">
				<div class="row ">
                    <div class="col-lg-3 col-md-3 hidden-768">
						<form>
						    <select id="select-shoppingguide" class="custom-select select-shoppingguide w-40 mb-5">
						        <option value='0'>First Time Buyer</option>
						        <option value='1'>Profile</option>
						        <option value='2'>Messages</option>
						        <option value='3'>Settings</option>
						    </select>
						</form>
					</div>
				</div>
				<ul class="nav nav-tabs d-none" id="tab-shoppingguide">
				    <li class="active"><a href="#first-time">First Time Buyer</a></li>
				    <li><a href="#two">Profile</a></li>
				    <li><a href="#three">Messages</a></li>
				    <li><a href="#four">Settings</a></li>
				</ul>
				<div class="tab-content tab-shoppingguide">
				    <div class="tab-pane active" id="first-time">
						<ol>
							<li class="mb-4 pb-2">
								<p class="bold-500">Make sure you are already logged in to talasi.co.id on your desktop or laptop.</p>
								<p>If you are not, here's how:</p>
								<p><a href="#" title="">How to login into my account?</a></p>
								<p><a href="#" title="">How to create new account?</a></p>
							</li>
							<li class="mb-4 pb-2">
								<img src="{{ asset('assets/img/screenshot.png') }}"> <img src="{{ asset('assets/img/screenshot.png') }}">
								<p class="bold-500">Select 'PURCHASE' button on the top of the website, and then go to 'Browse Product' categories on the left side.</p>
							</li>
							<li class="mb-4 pb-2">
								<img src="{{ asset('assets/img/screenshot.png') }}"> <img src="{{ asset('assets/img/screenshot.png') }}"> <img src="{{ asset('assets/img/screenshot.png') }}">
								<p class="bold-500">You can sort the product list by different categories, and click on the product thumbnail or <img src="{{ asset('assets/img/info.png') }}" class="info"> icon to receive more information about specific product</p>
							</li>
							<li class="mb-4 pb-2">
								<img src="{{ asset('assets/img/screenshot.png') }}"> <img src="{{ asset('assets/img/screenshot.png') }}">
							</li>
						</ol>
				    </div>
				    <div class="tab-pane" id="two">Profile content</div>
				    <div class="tab-pane" id="three">Messages content</div>
				    <div class="tab-pane" id="four">Settings content</div>
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

<script>
	$('#select-shoppingguide').on('change', function (e) {
	    $('#tab-shoppingguide li a').eq($(this).val()).tab('show'); 
	});
</script>	

@endsection
