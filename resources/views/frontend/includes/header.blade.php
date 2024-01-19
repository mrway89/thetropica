<body onload="initialize()">
	<nav class="bg-white border-bottom navbar navbar-expand-md fixed-top px-5 headerzindex hidden-992">
		<div class="container-fluid">
			<div class="d-flex w-40 order-0">
				<a class="navbar-brand mr-1" href="{{ route('frontend.home') }}">
				   <img src="{{ asset($company_logo_footer) }}" class="img-logo" alt="">
				</a>			
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
		            <span class="navbar-toggler-icon"></span>
		        </button>
			</div>
			<div class="navbar-collapse collapse justify-content-center order-2 w-100" id="collapsingNavbar">
				<ul class="navbar-nav">
                                        <li class="nav-item {{Request::segment(1) == 'purchase'? 'active':'' }}">
						<a class="nav-link" href="{{ route('frontend.product.purchase') }}">{{ $trans['navigation_purchase'] }}</a>
					</li>

                                        <!--<li class="nav-item">
						<a class="nav-link" href="{{ route('frontend.product.purchase_oil') }}">Massage Oil</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('frontend.product.purchase_aromatherapy') }}">Aromatherapy</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('frontend.product.purchase_beauty_and_wellness') }}">Beauty And Wellness</a>
					</li>-->

                                        <li class="nav-item">
						<a class="nav-link" href="{{ route('frontend.product.athome') }}">at HOME</a>
					</li>

                                        <li class="nav-item">
						<a class="nav-link" href="{{ route('frontend.product.gift') }}">GIFT</a>
					</li>
                                        
					<li class="nav-item {{Request::segment(1) == 'about'? 'active':'' }}">
						<a class="nav-link" href="{{ route('frontend.home') }}">{{ $trans['navigation_about'] }}</a>
					</li>

                                        <li class="nav-item">
						<a class="nav-link" href="{{ route('frontend.news') }}">NEWS</a>
					</li>				
                                        
                                        <li class="nav-item">
						<a class="nav-link" href="{{ route('frontend.contactus') }}"> CONTACT </a>
					</li> 
                                        
					<!--<li class="nav-item {{Request::segment(1) == 'product'? 'active':'' }}">
						<a class="nav-link" href="{{ route('frontend.product.brand') }}">{{ $trans['navigation_product'] }}</a>
					</li>
					<li class="nav-item {{Request::segment(1) == 'origin'? 'active':'' }}">
						<a class="nav-link" href="{{ route('frontend.origin.index') }}">{{ $trans['navigation_origin'] }}</a>
					</li>
					<li class="nav-item {{Request::segment(1) == 'experience'? 'active':'' }}">
						<a class="nav-link" href="{{ route('frontend.experience.index') }}">Experience</a>
					</li>-->
					
				</ul>
			</div>
			<div class="right-nav navbar-text mt-1 w-60 text-right order-1 order-md-last">

				<ul class="list-inline list-header-right pt-3">
					<li class="list-inline-item">
						<form action="{{ route('frontend.product.search') }}" method="get" accept-charset="utf-8" id="search-form">
							<input class="input-search" name="search" type="search">
						</form>
						<div class="dropdown open">
							<!-- <button class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Dropdown
							</button> -->
							<a href="javascript;" class="dropdown-toggle d-toggledrop" aria-haspopup="true" aria-expanded="false"  id="dropdownMenu1" data-toggle="dropdown"><i class="fa fa-search" aria-hidden="true"></i></a>
							{{-- <img src="{{ asset('assets/img/magnifying-glass.png') }}" class="dropdown-toggle magnifying-search" id="dropdownMenu1" data-toggle="dropdown"
							 aria-haspopup="true" aria-expanded="false"> --}}
							<div class="dropdown-menu dropdown-search-md" aria-labelledby="dropdownMenu1">
								<form  action="{{ route('frontend.product.search') }}"  accept-charset="utf-8">
									<!-- <input class="input-search-md" type="text"> -->
									<div class="input-group mb-3">
										<input type="text" class="form-control" placeholder="" aria-label="Recipient's username" aria-describedby="button-addon2" name="search">
										<div class="input-group-append">
											<button class="btn btn-search-md" type="submit" id="button-addon2"><img src="{{ asset('assets/img/magnifying-glass.png') }}"></button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</li>

					<li class="list-inline-item position-relative drop" id="drop-cart">
						<div id="cart_top_wrapper">
							@include('frontend.includes.header_cart')
						</div>
					</li>
					<li class="list-inline-item position-relative drop">
						@auth
							@if (\Auth::user()->unreadNotifications->count() > 0 )
							<div class="basket">{{ Auth::user()->unreadNotifications->count() }}</div>
							@endif
						@endauth
						<a href="#" title="Notifications" class="notif_header">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</a>
						@auth

						<div class="dropdown-header border">
							<div class="row">
								<div class="col-md-6">
									<div class="text-left w-100 float-left title-cart pb-0">
										Notifications
									</div>
								</div>
								<div class="col-md-6">
									<div class="text-left mark-all w-100 float-left label-12 ">
										<a href="#" id="mark_read_all_header">Mark All as Read</a>
									</div>
								</div>
							</div>
							<div class="w-100 float-left desc-notif">
								<div class="list-notif text-left label-14 position-relative">
									<ul class="w-100 float-left list-unstyled list-notif">
										@foreach (\Auth::user()->unreadNotifications()->take(4)->get() as $notification)
											@if ($notification->type == "App\Notifications\OrderNotification")
												@php
												$order = \Auth::user()->orderCheck($notification->data['order_id']);
												@endphp
												<li>
													<b>Talasi</b></br>
													@switch($notification->data['status'])
														@case('pending')
															#{{ $order->order_code }} Pending Order
															@break
														@case('paid')
															#{{ $order->order_code }} Paid
															@break
														@case('sent')
															#{{ $order->order_code }} on Delivery
															@break
														@case('completed')
															#{{ $order->order_code }} is Completed
															@break
														@case('failed')
															#{{ $order->order_code }} is failed
															@break
														@default

													@endswitch
													</br>
													<small>{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
												</li>
											@else
												<li>
													<b>Talasi</b></br>
													Anda mendapatkan {{ numbering_format($notification->data['points']) }} Talasi Point
													</br>
													<small>{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
												</li>
											@endif
										@endforeach
									</ul>
								</div>
							</div>
							<div class="w-100 mark-all text-center  float-left label-14">
								<a href="{{ route('frontend.user.notification') }}">See All</a>
							</div>
						</div>
						@endauth
					</li>
					@guest
					<li class="list-inline-item px-1">
						<a href="{{ route('frontend.login') }}" title="">
							{{ $trans['navigation_login'] }}
						</a>
					</li>
					@endguest
					@auth
					<li class="list-inline-item px-1">
						<a href="{{ route('frontend.user.profile') }}" title="Profile">
							{{ ucwords(\Auth::user()->name) }}
						</a>
					</li>
					@endauth
                                        
                                        <?php /*
					@if ($company_facebook)
					<li class="list-inline-item">
						<a href="{{ $company_facebook }}" target="_blank" title="Talasi Facebook">
							<i class="fa fa-facebook-square" aria-hidden="true"></i>
						</a>
					</li>
					@endif
					@if ($company_instagram)
					<li class="list-inline-item">
						<a href="{{ $company_instagram }}" target="_blank" title="Talasi Instagram">
							<i class="fa fa-instagram" aria-hidden="true"></i>
						</a>
					</li>
					@endif
					@if ($company_twitter)
					<li class="list-inline-item">
						<a href="{{ $company_twitter }}" class="border-bottom-0" target="_blank" title="Talasi Instagram">
							<i class="fa fa-twitter" aria-hidden="true"></i>
						</a>
					</li>
					@endif*/ ?>
                                     
				       <li class="list-inline-item px-1">
						<form class="" action="{{ route('frontend.language') }}" method="post">
							{{ csrf_field() }}
							<select class="" name="locale" onchange="this.form.submit()" style="border:none; background: none; color:#A9A9A9; font-size: 14px;-moz-appearance: none;-webkit-appearance: none;appearance: none; cursor: pointer;margin-right: 10px;background-color: transparent;margin: 0;outline: none !important;">
								<option value="en" {{ \App::getLocale() == 'en' ? 'selected' : '' }} style="background: #fff; padding: 5px;">ENG</option>
								<option value="id" {{ \App::getLocale() == 'id' ? 'selected' : '' }} style="background: #fff; padding: 5px;">ID</option>
							</select>
						</form>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<nav class="navbar navbar-expand-md header-mobile fixed-top px-2 visible-992 bg-white">
			{{-- {{Request::segment(1) == 'about' || Request::segment(1) == 'origin'  || Request::segment(1) == '' || Request::segment(1) == 'home'? 'bg-transparent':'bg-white' }}   --}}
		<div class="container-fluid d-flex flex-column">
			<div class="row w-100 m-0 d-flex justify-content-center">
				<div class="col-3">
				<i onclick="openNav()" class="fa fa-bars change-color text-grey icon-nav mt-2" aria-hidden="true"></i>
				{{-- {{Request::segment(1) == 'about' ? 'text-white':'text-grey' }} --}}
				</div>
				<div class="col-6 d-flex justify-content-center">
					<a class="navbar-brand brandlogwhite mr-1" href="{{ route('frontend.home') }}">
						<img src="{{ asset($company_logo_header) }}" class="img-logo-small" alt="">
					</a>
					<a class="navbar-brand brandlogblue mr-1" href="{{ route('frontend.home') }}">
						<img src="{{ asset($company_logo_footer) }}" class="img-logo-small" alt="">
					</a>
				</div>
				<div class="col-3 d-flex align-items-center justify-content-end">
					<ul class="list-inline list-header-right float-right mb-0">
						<li class="list-inline-item position-relative">
							@auth
								@if (\Auth::user()->userCart())
									<div class="basket">
										{{ \Auth::user()->userCart()->details->sum('qty') }}
									</div>
								@endif
							@endauth
							<a href="{{ route('frontend.cart.index')}}" title="">
								<i class="fa fa-shopping-cart" aria-hidden="true"></i>
							</a>
						</li>
						<li class="list-inline-item position-relative">
							@auth
								@if (\Auth::user()->unreadNotifications->count() > 0 )
								<div class="basket">{{ Auth::user()->unreadNotifications->count() }}</div>
								@endif
							@endauth
							<a href="{{ route('frontend.user.notification') }}" title="Notifications" class="notif_header">
								<i class="fa fa-envelope" aria-hidden="true"></i>
							</a>
						</li>
						{{-- <li class="list-inline-item">
							<a href="#" class="pull-right change-color
							{{ Request::segment(1) == 'product' || Request::segment(2) == 'account' || Request::segment(2) == 'compare-product'
							|| Request::segment(2) == 'faq'|| Request::segment(2) == 'product-list'
							|| Request::segment(2) == 'shopping-guide' || Request::segment(2) == 'payment-guide'
							|| Request::segment(2) == 'product' || Request::segment(2) == 'login'
							|| Request::segment(2) == 'forgot'
							|| Request::segment(2) == 'reset' ? 'text-dark':'text-white'}}  mt-3 bold-700" title="">
								ENG
							</a>
						</li> --}}
					</ul>
					{{-- <a href="#" class="pull-right change-color {{Request::segment(1) == 'about'? 'text-white':'text-grey' }} mt-3 bold-700" title="">
						ENG
					</a> --}}
				</div>
			</div>
			<div class="searchbox-head w-100 mx-auto my-0">
				<form action="{{ route('frontend.product.search') }}" class="mb-0" method="get" accept-charset="utf-8">
					<div class="input-group">
						<div class="input-group-append">
							<button class="btn btn-search-md-x" type="button" id="button-addon2"><img src="{{ asset('assets/img/magnifying-glass.png') }}"></button>
						</div>
						<input name="search" type="text" class="form-control input-search-x pl-0 pt-2" placeholder="Search talasi.co.id" aria-label="Recipient's username"
							aria-describedby="button-addon2" name="search">

					</div>
				</form>
			</div>
		</div>
	</nav>
	<div id="mySidenav" class="sidenav">
		<!-- <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a> -->
                <a href="{{ route('frontend.product.purchase') }}" class="">{{ $trans['navigation_purchase'] }}</a>
		<!--<a href="{{ route('frontend.about') }}" class="">{{ $trans['navigation_about'] }}</a>-->
		<a href="#" class="">Event</a>
		<a href="#" class="">Idea</a>
		<a href="{{ route('frontend.contactus') }}" class="">Contact</a>
		
		@auth
			<a href="{{ route('frontend.user.profile') }}" class="">{{ ucwords(\Auth::user()->name) }}</a>
			<a href="{{ route('frontend.logout') }}" class="logout-mb">Log Out</a>
		@else
			<a href="{{ route('frontend.login') }}" class="">Login/Sign Up</a>
		@endauth
	   </div>
	<div id="fullpage">
