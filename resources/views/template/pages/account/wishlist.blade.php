@extends('template/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-area">
	<div class="container container-product">
		<div class="row">
			<div class="col-md-9 col-sm-12 col-12 offset-md-3 offset-0 pt-3">
				<h3 class="bold-300 mb-4 pt-md-5 pt-0">My Account</h3>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-6">
				@include('template/pages/account/includes/sidemenu')
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12 ">
                <p class="bold-700 mb-4">My Wishlist</p>
                <div class="w-100 float-left border-bottom mb-3">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                            <label class="container-checkmark">
                                <div class="label-14"><span class="">Select all</span><span> | </span><span><a href="" class="text-dark">Delete</a></span></div>
                                <input type="checkbox" value="" onchange="checkAll(this)" name="address_list[]">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                </div>
				<div class="w-100 float-left">
                    <div class="w-100 float-left mb-4 pb-3">
                        <div class="row product pl-3">
                            <label class="container-checkmark col-lg-8 col-md-8 col-sm-8 col-12">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-3 col-3">
                                        <center>
                                            <img src="{{ asset('assets/img/watu-jar.png') }}" class="img-wishlist img-cart-item" alt="">
                                        </center>
                                    </div>
                                    <div class="col-lg-10 col-md-9 col-sm-9 col-9">
                                        <p class="mb-0 bold-700">Watu Cashew nuts Original</p>
                                        <p class="mb-0"><span class="bold-700">Origin:</span> Sumba, East Nusa Tenggara</p>
                                        <p class="mb-2"><span class="bold-700">Netto:</span> 475 gr</p>

                                        <p class="mb-2 bold-700 product-line-price">Rp 200.000</p>
                                        <a href="#" title="">Remove from wishlist</a>
                                    </div>
                                </div>

                                <input type="checkbox" value="" name="address_list">
                                <span class="checkmark"></span>
                            </label>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-9 pl-lg-3 pl-sm-0 pl-4 ml-addcart mt-lg-4 mt-md-4 mt-4">
                                <div class="input-group input-group-number w-40 float-left">
                                    <form class="d-flex">
                                        <div id="field1" class="input-group-btn">
                                            <button type="button" id="sub" class="btn btn-default btn-gray btn-number sub">-</button>
                                            <input type="text" id="1" value="3" min="1" max="1000" class="form-control input-number" />
                                            <button type="button" id="add" class="btn btn-default btn-number add">+</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="w-60 float-right">
                                    <button class="checkout btn-send-about w-90 px-0 ml-3">ADD TO CART</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-100 float-left mb-4 pb-3">
                        <div class="row product pl-3">
                            <label class="container-checkmark col-lg-8 col-md-8 col-sm-8 col-12">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-3 col-3">
                                        <center>
                                            <img src="{{ asset('assets/img/watu-jar.png') }}" class="img-wishlist img-cart-item" alt="">
                                        </center>
                                    </div>
                                    <div class="col-lg-10 col-md-9 col-sm-9 col-9">
                                        <p class="mb-0 bold-700">Watu Cashew nuts Original</p>
                                        <p class="mb-0"><span class="bold-700">Origin:</span> Sumba, East Nusa Tenggara</p>
                                        <p class="mb-2"><span class="bold-700">Netto:</span> 475 gr</p>

                                        <p class="mb-2 bold-700 product-line-price">Rp 200.000</p>
                                        <a href="#" title="">Remove from wishlist</a>
                                    </div>
                                </div>

                                <input type="checkbox" value="" name="address_list">
                                <span class="checkmark"></span>
                            </label>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-9 pl-lg-3 pl-sm-0 pl-4 ml-addcart mt-lg-4 mt-md-4 mt-4">
                                <div class="input-group input-group-number w-40 float-left">
                                    <form class="d-flex">
                                        <div id="field1" class="input-group-btn">
                                            <button type="button" id="sub" class="btn btn-default btn-gray btn-number sub">-</button>
                                            <input type="text" id="1" value="3" min="1" max="1000" class="form-control input-number" />
                                            <button type="button" id="add" class="btn btn-default btn-number add">+</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="w-60 float-right">
                                    <button class="checkout btn-send-about w-90 px-0 ml-3">ADD TO CART</button>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>

        <div class="row">
            <div class="col-12">
                <ul class="list-unstyled pagination-prod float-right">
                    <li class="prev"><a href=""><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>
                    <li class="active"><a href="">1</a></li>
                    <li class=""><a href="">2</a></li>
                    <li class=""><a href="">3</a></li>
                    <li class="next"><a href=""><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div>
	</div>
</div>			

@endsection

@section('footer')
@include('template/includes/footer')
@endsection

@section('custom_js')
<script src="{{ asset('assets/js/check_all.js') }}"></script>
<script>
    $('.add').click(function () {
        if ($(this).prev().val() < 1000) {
        $(this).prev().val(+$(this).prev().val() + 1);
        }

    });
    $('.sub').click(function () {
            if ($(this).next().val() > 1) {
            if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
            }
    })
</script>
@endsection
