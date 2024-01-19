@extends('template/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-area">
	<div class="container container-product mb-5">
		<div class="row">
			<div class="col-md-9 offset-3 pt-3 hidden-768">
				<h3 class="bold-300 mb-4 pt-md-5 pt-0">Compare Product</h3>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-6">
				<ul class="list-unstyled list-shoppingguide">
					<li>
						<a href="#">Browse Product</a>
					</li>
					<li class="active">
						<a href="#">Compare Product</a>
					</li>
					<li>
						<a href="#">FAQ</a>
					</li>
					<li>
						<a href="#">Shopping Guide</a>
					</li>
					<li>
						<a href="#">Payment Guide</a>
					</li>
				</ul>
			</div>
			<div class="col-sm-6 col-6 visible-768">
                <form>
                    <select id="select-shoppingguide" class="custom-select select-search select-shoppingguide float-left w-100 mb-5 mr-2">
                        <option value='0'>Watu Honey</option>
				        <option value='1'>Profile</option>
				        <option value='2'>Messages</option>
				        <option value='3'>Settings</option>
                    </select>
                </form>
            </div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12">
				<div class="row">
					<div class="col-lg-3 col-md-3 hidden-768">
						<form>
							<select id="select-shoppingguide" class="custom-select select-shoppingguide w-100 mb-5">
						        <option value='0'>Watu Honey</option>
						        <option value='1'>Profile</option>
						        <option value='2'>Messages</option>
						        <option value='3'>Settings</option>
						    </select>
						</form>
					</div>
					<div class="col-8 hidden-768">
						<p class="pt-2">Pick product category then pick up to 3 products to compare</p>
					</div>
				</div>
				<div class="row">
					<div class="col-12 visible-768">
						<p class="pt-2">Pick product category then pick up to 3 products to compare</p>
					</div>
				</div>
				<div class="row" id="product-list">
					<div class="col-md-4 product-compare">
						<div class="row">
							<div class="col-md-9">
								<div class="outDiv"></div>
									<div class="divOne">
									<center>
										<img src="{{ asset('assets/img/watu-jar.png')}}" class="mb-5 reflect" alt="">
									</center>

									<div class="row justify-content-md-center">
										
										<div class="col-6 pr-0">
											<div class="input-group input-group-number">
												<form class="d-flex">
													<div id="field1" class="input-group-btn">
													    <button type="button" id="sub" class="btn btn-default btn-number btn-gray sub">-</button>
													    <input type="text" id="1" value="1" min="1" max="1000" class="form-control input-number" />
													    <button type="button" id="add" class="btn btn-default btn-number add">+</button>
													</div>
												</form>
								            </div>
										</div>
										<div class="col-6 pr-0">
											<button type="button" class="btn btn-addtocart-small">ADD TO CART</button>
										</div>
									
									</div>

									<div class="product-detail-compare mt-5">
										<img src="{{ asset('assets/img/logo-watu-detail.png')}}" class="w-50 compare-logo" alt="">
										<h3 class="mb-2">multifloral honey</h3>

										<p><span class="bold-700">Price: 10.000</span></p>
										<p><span class="bold-700">Origin: </span>Kapuas Hulu, Kalimantan</p>
										<p><span class="bold-700">Bees: </span>APIS DORSATA</p>
										<p><span class="bold-700">Health Benefit:</span><br>Rich in Vitamins & minerals, such as vitamin C, calcium, and iron. It has anti-bacterial and anti-fungal properties</p>
										<p><span class="bold-700">Taste Profile:</span><br>Sweet, slighty sour, slighty woody, caramelized, slighty acid.</p>
										<p><span class="bold-700">Certification:</span><br></p>
										<img src="{{ asset('assets/img/stamp.png')}}" class="img-stamp" alt="">
										<img src="{{ asset('assets/img/stamp.png')}}" class="img-stamp" alt="">
										<img src="{{ asset('assets/img/stamp.png')}}" class="img-stamp" alt="">
									</div>
								</div>
								<div class="divTwo w-100">
									<div class="row justify-content-md-center mt-5 pt-5">
										<div class="col-8">
											<select class="custom-select w-100">
												<option selected>Choose product</option>
												<option value="Caliandra Honey">Caliandra Honey</option>
												<option value="Organic Forest Honey">Organic Forest Honey</option>
												<option value="Multifloral Honey">Multifloral Honey</option>
												<option value="Trigona Honey">Trigona Honey</option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-4 product-compare">
						<div class="row">
							<div class="col-md-9">
								<div class="outDiv"></div>
									<div class="divOne">
									<center>
										<img src="{{ asset('assets/img/watu-jar.png')}}" class="mb-5 reflect" alt="">
									</center>

									<div class="row justify-content-md-center">
										
										<div class="col-6 pr-0">
											<div class="input-group input-group-number">
												<form class="d-flex">
													<div id="field1" class="input-group-btn">
													    <button type="button" id="sub" class="btn btn-default btn-number btn-gray sub">-</button>
													    <input type="text" id="1" value="1" min="1" max="1000" class="form-control input-number" />
													    <button type="button" id="add" class="btn btn-default btn-number add">+</button>
													</div>
												</form>
								            </div>
										</div>
										<div class="col-6 pr-0">
											<button type="button" class="btn btn-addtocart-small">ADD TO CART</button>
										</div>
									
									</div>

									<div class="product-detail-compare mt-5">
										<img src="{{ asset('assets/img/logo-watu-detail.png')}}" class="w-50 compare-logo" alt="">
										<h3 class="mb-2">multifloral honey</h3>

										<p><span class="bold-700">Price: 10.000</span></p>
										<p><span class="bold-700">Origin: </span>Kapuas Hulu, Kalimantan</p>
										<p><span class="bold-700">Bees: </span>APIS DORSATA</p>
										<p><span class="bold-700">Health Benefit:</span><br>Rich in Vitamins & minerals, such as vitamin C, calcium, and iron. It has anti-bacterial and anti-fungal properties</p>
										<p><span class="bold-700">Taste Profile:</span><br>Sweet, slighty sour, slighty woody, caramelized, slighty acid.</p>
										<p><span class="bold-700">Certification:</span><br></p>
										<img src="{{ asset('assets/img/stamp.png')}}" class="img-stamp" alt="">
										<img src="{{ asset('assets/img/stamp.png')}}" class="img-stamp" alt="">
										<img src="{{ asset('assets/img/stamp.png')}}" class="img-stamp" alt="">
									</div>
								</div>
								<div class="divTwo w-100">
									<div class="row justify-content-md-center mt-5 pt-5">
										<div class="col-8">
											<select class="custom-select w-100">
												<option selected>Choose product</option>
												<option value="Caliandra Honey">Caliandra Honey</option>
												<option value="Organic Forest Honey">Organic Forest Honey</option>
												<option value="Multifloral Honey">Multifloral Honey</option>
												<option value="Trigona Honey">Trigona Honey</option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-4 product-compare">
						<div class="row">
							<div class="col-md-9">
								<div class="outDiv"></div>
									<div class="divOne">
									<center>
										<img src="{{ asset('assets/img/watu-jar-grey.png')}}" class="mb-5" alt="">
									</center>
								</div>
								<div class="divTwo w-100">
									<div class="row justify-content-md-center mt-5 pt-5">
										<div class="col-8">
											<select class="custom-select w-100">
												<option selected>Choose product</option>
												<option value="Caliandra Honey">Caliandra Honey</option>
												<option value="Organic Forest Honey">Organic Forest Honey</option>
												<option value="Multifloral Honey">Multifloral Honey</option>
												<option value="Trigona Honey">Trigona Honey</option>
											</select>
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
	</div>
</div>			

@endsection

@section('footer')
@include('template/includes/footer')
@endsection

@section('custom_js')

<script>

$(document).on('mouseover', '#product-list .outDiv', function() { 
        test=$(this).parent("div");
        test.children(".divOne").addClass("fadeOut")
        test.children(".divTwo").addClass("fadeIn");
    });
    $(document).on('mouseout', '#product-list .outDiv', function() {
        test.children(".divOne").removeClass("fadeOut")
        test.children(".divTwo").removeClass("fadeIn");
    });
    $(document).on('mouseover', '#product-list .divTwo', function() {
        test.children(".divOne").addClass("fadeOut")
        test.children(".divTwo").addClass("fadeIn");
    });
    $(document).on('mouseout', '#product-list .divTwo', function() {
        test.children(".divOne").removeClass("fadeOut")
        test.children(".divTwo").removeClass("fadeIn");
    });

$('.add').click(function () {
		if ($(this).prev().val() < 1000) {
    	$(this).prev().val(+$(this).prev().val() + 1);
		}

});
$('.sub').click(function () {
		if ($(this).next().val() > 1) {
    	if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
		}
});
</script>	

@endsection
