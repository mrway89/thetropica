<body>
	<nav class="{{Request::segment(2) != 'about' && Request::segment(2) != 'product' && Request::segment(2) != 'origin' && Request::segment(2) != 'experience' && Request::segment(2) != '' && Request::segment(2) != 'home' ? 'bg-white':'bg-transparent' }} navbar navbar-expand-md fixed-top px-5 d-none d-md-flex">
		<div class="container-fluid">
			<div class="d-flex w-40 order-0">
				<a class="navbar-brand brandlogwhite mr-1" href="#">
					<img src="{{ asset('assets/img/logo-white.png') }}" class="img-logo" alt="">
				</a>
				<a class="navbar-brand brandlogblue mr-1" href="#">
					<img src="{{ asset('assets/img/logo.png') }}" class="img-logo" alt="">
				</a>
		        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
		            <span class="navbar-toggler-icon"></span>
		        </button>
		    </div>
			<div class="navbar-collapse collapse justify-content-center order-2 w-100" id="collapsingNavbar">
		        <ul class="navbar-nav" id="navbar-scroll">
		            <li class="nav-item" data-menuanchor="section-2">
		                <a href="{{url('frontend/about')}}" class="nav-link">About Talasi</a>
		            </li>
		            <li class="nav-item" data-menuanchor="section-3">
		                <a href="{{url('frontend/product')}}" class="nav-link bordered">Product</a>
		            </li>
		            <li class="nav-item" data-menuanchor="section-4">
		                <a href="{{url('frontend/origin')}}" class="nav-link bordered">Origin</a>
		            </li>
		            <li class="nav-item" data-menuanchor="section-6">
		                <a href="{{url('frontend/experience')}}" class="nav-link bordered">EXPERIENCE</a>
		            </li>
		            <li class="nav-item" data-menuanchor="section-5">
		                <a href="{{url('frontend/product-list')}}" class="nav-link">Purchase</a>
		            </li>
		        </ul>
		    </div>
		    <div class="right-nav navbar-text mt-1 w-60 text-right order-1 order-md-last">

				<ul class="list-inline list-header-right pt-3">
					<li class="list-inline-item">
						<form id="search-form">
							<input class="input-search" type="search">
						</form>
						<div class="dropdown open">
							<!-- <button class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Dropdown
							</button> -->
							<img src="{{ asset('assets/img/magnifying-glass.png') }}" class="dropdown-toggle magnifying-search" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<div class="dropdown-menu dropdown-search-md" aria-labelledby="dropdownMenu1">
								<form action="#" method="get" accept-charset="utf-8">
									<!-- <input class="input-search-md" type="text"> -->
									<div class="input-group mb-3">
									  <input type="text" class="form-control" placeholder="" aria-label="Recipient's username" aria-describedby="button-addon2">
									  <div class="input-group-append">
									  <button class="btn btn-search-md" type="button" id="button-addon2"><img src="{{ asset('assets/img/magnifying-glass.png') }}"></button>
									</div>
								</div>
								</form>
							</div>
						</div>
					</li>
					<li class="list-inline-item position-relative drop">
						<div class="basket">1</div>
						<a href="#" title="">
							<i class="fa fa-shopping-cart" aria-hidden="true"></i>
						</a>
						{{-- cart udah diisi --}}
						<div class="dropdown-header">
							<div class="text-left w-100 float-left title-cart mb-2">
								My Shopping Cart
							</div>
							<div class="list-prod w-100 float-left">
								<ul class="list-unstyled list-cart-top">
									@for($i=1;$i<= 2; $i++)
									<li>
										<div class="img-cart-top">
											<img src="{{asset('assets/img/product/img'.$i.'.jpg')}}"/>
										</div>
										<div class="detail-cart desc-cart-top">
											<div class="line-clamp-2">
												Watu Cashew Nuts Original
											</div>
											<div>
												Origin:Sumba, East Nusa Tenggara
											</div>
											<div>
												Netto:475 gr
											</div>
											<div class="mt-2">
												<div class="row">
													<div class="col-6 pr-0">Rp 200.000</div>
													<div class="col-6 pl-2 pr-0"> Amount:2 Piece(s)</div>
												</div>
											</div>
										</div>
									</li>
									@endfor
								</ul>
							</div>
							<div class="w-100 float-left">
								<div class="row">
									<div class="col-6 text-left label-14">Total: <b> 4 Piece(s)</b></div>
									<div class="col-6 text-right label-14 mark-all"><a href="">See All</a></div>
								</div>
							</div>
						</div>
						
					{{-- 	<div class="dropdown-header border">
							<img src="{{asset('assets/img/segitiga-white.png')}}" class="segitiga-putih"/> 
							<div class="border-bottom text-center w-100 float-left title-cart">
									Keranjang Belanja Anda
							</div>
							<div class="list-prod w-100 float-left"> 
								<div class="text-center w-100 float-left non-cart"> tidak ada keranjang belanja</div>
							</div>
							<div class="w-100 float-left text-center link-blanja mb-2">
									<a href="#">Lihat Keranjang Belanja <i class="fa fa-caret-right" aria-hidden="true"></i></a>
							</div>
							<div class="w-100 float-left text-center mb-2">
								<a href="#"><button class="btn btn-oval btn-pink label-14">PERIKSA TRANSAKSI</button></a>
							</div>
						</div>--}}
					</li>
					<li class="list-inline-item position-relative drop">
							<div class="basket">1</div>
						<a href="#" title="">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</a>
						<div class="dropdown-header border">
								<div class="row">
									<div class="col-md-6">
										<div class="text-left w-100 float-left title-cart pb-0">
												Notifications
										</div>
									</div>
									<div class="col-md-6">
										<div class="text-left mark-all w-100 float-left label-12 ">
												<a href="">Mark All as Read</a>
										</div>
									</div>
								</div>
								<div class="w-100 float-left desc-notif">
									<div class="list-notif text-left label-14 position-relative">
											<ul class="w-100 float-left list-unstyled list-notif">
												<li>
													<b>Ali Haliman</b></br>
													Lorem ipsum dolor sit amet, consectetur adipiscing elit.
													 Pellentesque mattis justo sed molestie tristique.</br>
													 <small>2h</small>
												</li>
												<li>
													<b>Ali Haliman</b></br>
													Lorem ipsum dolor sit amet, consectetur adipiscing elit.
													 Pellentesque mattis justo sed molestie tristique.</br>
													 <small>2h</small>
													</li>
											</ul>
									</div>
								</div>
								<div class="w-100 mark-all text-center  float-left label-14">
										<a href="">See All</a>
								</div>
							</div>
					</li>
					<li class="list-inline-item px-1">
						<a href="#" title="">
							Login / Sign Up
						</a>
					</li>
					<li class="list-inline-item">
						<a href="#" title="">
							<i class="fa fa-facebook-square" aria-hidden="true"></i>
						</a>
					</li>
					<li class="list-inline-item">
						<a href="#" title="">
							<i class="fa fa-instagram" aria-hidden="true"></i>
						</a>
					</li>
					<li class="list-inline-item px-1">
						<a href="#" title="">
							ENG
						</a>
					</li>

				</ul>
		    </div>
		</div>
	</nav>

	<nav class="navbar navbar-expand-md header-mobile fixed-top px-2 d-flex d-md-none">
		<div class="container-fluid">
			<div class="row w-100 m-0">
				<div class="col-3">
					<i onclick="openNav()" class="fa fa-bars change-color text-white icon-nav mt-2" aria-hidden="true"></i>
				</div>
				<div class="col-4 d-flex justify-content-center">
					<a class="navbar-brand brandlogwhite mr-1" href="#">
						<img src="{{ asset('assets/img/logo-white.png') }}" class="img-logo-small" alt="">
					</a>
					<a class="navbar-brand brandlogblue mr-1 deactive" href="#">
						<img src="{{ asset('assets/img/logo.png') }}" class="img-logo-small" alt="">
					</a>
				</div>
				<div class="col-5">
						<ul class="list-inline list-header-right float-right">
								<li class="list-inline-item position-relative">
									<div class="basket">1</div>
									<a href="{{url('frontend/cart/order')}}" title="">
										<i class="fa fa-shopping-cart" aria-hidden="true"></i>
									</a>
								</li>
								<li class="list-inline-item position-relative">
									<div class="basket">1</div>
									<a href="{{url('frontend/account/notifications')}}" title="">
										<i class="fa fa-envelope" aria-hidden="true"></i>
									</a>
								</li>
								<li class="list-inline-item">
									<a href="#" class="pull-right change-color text-white mt-3 bold-700" title="">
											ENG
									</a>
								</li>
						</ul>
					{{-- <a href="#" class="pull-right change-color text-white mt-3 bold-700" title="">
						ENG
					</a> --}}
				</div>
			</div>
		</div>
	</nav>

<div id="mySidenav" class="sidenav">
  <!-- <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a> -->
  <div class="searchbox-head w-80 mx-auto my-0">
  	<form action="#" method="get" accept-charset="utf-8">
		<div class="input-group mb-3">
		  <div class="input-group-append">
		  <button class="btn btn-search-md-x" type="button" id="button-addon2"><img src="{{ asset('assets/img/magnifying-glass.png') }}"></button>
		</div>
		<input type="text" class="form-control input-search-x pl-0 pt-2" placeholder="Search talasi.co.id" aria-label="Recipient's username" aria-describedby="button-addon2">

		</div>
	</form>
  </div>

	<a href="#" class="">About Talasi</a>
	<a href="#" class="">Product</a>
	<a href="#" class="">Origin</a>
	<a href="#" class="">Purchase</a>
	<a href="#" class="">Login/Sign Up</a>
	<a href="#" class="logout-mb">Log Out</a>
	<ul class="list-unstyled sosmed-mb mx-auto">
		<li>	
			<a href="#" title="" class="border-bottom-0">
				<i class="fa fa-facebook-square" aria-hidden="true"></i>
			</a>
		</li>
		<li>
			<a href="#" title="" class="border-bottom-0">
				<i class="fa fa-instagram" aria-hidden="true"></i>
			</a>
		</li>
		<div class="clearfix"></div>
	</ul>
	</div>

	<div id="fullpage">
