@extends('template/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-area">
	<div class="container container-product pt-mb-0 pt-3">
		<div class="row">
			<div class="col-md-9 col-sm-6 col-6 offset-md-3 offset-0 pt-3">
				<h3 class="result pt-md-5 pt-0 visible-768 " onclick="browse()">Browse Product</h3>{{-- mobile --}}
				<h3 class="result mb-4 pt-md-5 pt-0 hidden-768 ">Browse Product</h3>  
            </div>
            {{-- mobile --}}
            <div class="box-browse float-left border-bottom visible-768">
                <ul class="list-unstyled list-shoppingguide mb-3 ">
                    <li class="{{Request::segment(2) == 'product-list' ? 'active':''}}">
                        <a href="{{url('frontend/product-list')}}">Browse Product</a>
                    </li>
                    <li class="{{Request::segment(2) == 'compare-product' ? 'active':''}}">
                        <a href="{{url('frontend/compare-product')}}">Compare Product</a>
                    </li>
                    <li class="{{Request::segment(2) == 'faq' ? 'active':''}}">
                        <a href="{{url('frontend/faq')}}">FAQ</a>
                    </li>
                    <li class="{{Request::segment(2) == 'shopping-guide' ? 'active':''}}">
                            <a href="{{url('frontend/shopping-guide')}}">Shopping Guide</a>
                    </li>
                    <li class="{{Request::segment(2) == 'payment-guide' ? 'active':''}}">
                        <a href="{{url('frontend/payment-guide')}}">Payment Guide</a>
                    </li>
                    <li class="{{Request::segment(2) == 'pickup-point' ? 'active':''}}">
                        <a href="{{url('frontend/pickup-point')}}">Pick Up Point</a>
                    </li>
                </ul>
            </div>
            
			<div class="col-lg-3 col-md-3 col-sm-6 col-6 hidden-768">
				<ul class="list-unstyled list-shoppingguide mb-5 ">
					<li class="{{Request::segment(2) == 'product-list' ? 'active':''}}">
                        <a href="{{url('frontend/product-list')}}">Browse Product</a>
                    </li>
                    <li class="{{Request::segment(2) == 'compare-product' ? 'active':''}}">
                        <a href="{{url('frontend/compare-product')}}">Compare Product</a>
                    </li>
                    <li class="{{Request::segment(2) == 'faq' ? 'active':''}}">
                        <a href="{{url('frontend/faq')}}">FAQ</a>
                    </li>
                    <li class="{{Request::segment(2) == 'shopping-guide' ? 'active':''}}">
                         <a href="{{url('frontend/shopping-guide')}}">Shopping Guide</a>
                    </li>
                    <li class="{{Request::segment(2) == 'payment-guide' ? 'active':''}}">
                        <a href="{{url('frontend/payment-guide')}}">Payment Guide</a>
                    </li>
                    <li class="{{Request::segment(2) == 'pickup-point' ? 'active':''}}">
                        <a href="{{url('frontend/pickup-point')}}">Pick Up Point</a>
                    </li>
                </ul>
                <ul class="list-unstyled list-filter">
                    <li>
                        <label class="w-100 float-left mb-3">Filter</label>
                    </li>
                    <li>
                        <label class="w-100 float-left subtitle">Price</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text label-14 bg-white">Rp</span>
                            </div>
                            <input type="text" class="form-control text-right label-14 border-left-0 autonumeric" placeholder="Minimum">
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend ">
                                <span class="input-group-text label-14 bg-white">Rp</span>
                            </div>
                            <input type="text" class="form-control text-right label-14 border-left-0 autonumeric" placeholder="Minimum">
                        </div>
                    </li>
                    <li>
                        <label class="w-100 float-left subtitle">Brand</label>
                        <div class="w-100  float-left mb-2">
                            <label class="container-checkmark">
                                <span class="label-14">Watu</span>
                                <input type="checkbox" value="" name="brand">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="w-100 float-left mb-2">
                            <label class="container-checkmark">
                                <span class="label-14">Starling</span>
                                <input type="checkbox" value="" name="brand">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="w-100 float-left mb-2">
                            <label class="container-checkmark">
                                <span class="label-14">Toye</span>
                                <input type="checkbox" value="" name="brand">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </li>
                    <li>
                        <label class="w-100 float-left subtitle">Keyword</label>
                        <div class="w-100 float-left mb-2">
                            <label class="container-checkmark">
                                <span class="label-14">Organic</span>
                                <input type="checkbox" value="" name="brand">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="w-100 float-left mb-2">
                            <label class="container-checkmark">
                                <span class="label-14">Vegan friendly</span>
                                <input type="checkbox" value="" name="brand">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="w-100 float-left mb-2">
                            <label class="container-checkmark">
                                <span class="label-14">Glutten free</span>
                                <input type="checkbox" value="" name="brand">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="w-100 float-left mb-2">
                            <label class="container-checkmark">
                                <span class="label-14">Cholesterol-free</span>
                                <input type="checkbox" value="" name="brand">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="w-100 float-left mb-2">
                            <label class="container-checkmark">
                                <span class="label-14">Contain alcohol</span>
                                <input type="checkbox" value="" name="brand">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </li>
                    <li>
                        <label class="w-100 float-left subtitle">Origin</label>
                        <div class="w-100 float-left mb-2">
                            <label class="container-checkmark">
                                <span class="label-14">Kuansing</span>
                                <input type="checkbox" value="" name="origin">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="w-100 float-left mb-2">
                            <label class="container-checkmark">
                                <span class="label-14">Lampung</span>
                                <input type="checkbox" value="" name="origin">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="w-100 float-left mb-2">
                            <label class="container-checkmark">
                                <span class="label-14">Kapuas Hulu</span>
                                <input type="checkbox" value="" name="origin">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="w-100 float-left mb-2">
                            <label class="container-checkmark">
                                <span class="label-14">Magelang</span>
                                <input type="checkbox" value="" name="origin">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="w-100 float-left mb-2">
                            <label class="container-checkmark">
                                <span class="label-14">Bali</span>
                                <input type="checkbox" value="" name="origin">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="w-100 float-left mb-2">
                            <label class="container-checkmark">
                                <span class="label-14">Sumba</span>
                                <input type="checkbox" value="" name="origin">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="w-100 float-left mb-2">
                            <label class="container-checkmark">
                                <span class="label-14">Luwu</span>
                                <input type="checkbox" value="" name="origin">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </li>
                    <li>
                        <label class="w-100 float-left subtitle pointer"><a href="#">Clear Filter</a></label>
                    </li>
                    <li>
                        <button class="btn btn-pink mt-3  btn-oval btn-search w-100 float-left">
                            SEARCH
                        </button>
                    </li>
                </ul>
            </div>
            <div class="col-sm-6 col-6 mt-2 visible-768 ">
                <form>
                    {{-- <label class="sort-by">Sort by :</label> --}}
                    <select id="select-shoppingguide" class="custom-select select-search select-shoppingguide float-left w-100 mr-2">
                        <option value='0'>by Popularity</option>
                        <option value='1'>by Origin</option>
                        <option value='2'>by Price (Ascending)</option>
                        <option value='3'>by Price (Descending)</option>
                        <option value='3'>by Brand</option>
                    </select>
                </form>
            </div>
            <div class="col-12 visible-768">
                <div class="float-left filtermb">
                    <a href="#" onclick="filtershow()">
                        <img src="{{asset('assets/img/options.png')}}"/>
                        <p class="lable-12 mt-2">Filter</p>
                    </a>
                </div>
            </div>
            <div class="box-filter visible-768 pt-mb-0 pt-3">
                <div class="float-left filtermb">
                    <a href="#" onclick="filterhide()">
                        <img src="{{asset('assets/img/options.png')}}"/>
                        <p class="lable-12 mt-2">Filter</p>
                    </a>
                </div>
                <div class="section-filter">
                    <ul class="list-unstyled list-filter">
                            <li>
                                <label class="w-100 float-left mb-3">Filter</label>
                            </li>
                            <li>
                                <label class="w-100 float-left subtitle">Price</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-14 bg-white">Rp</span>
                                    </div>
                                    <input type="text" class="form-control text-right label-14 border-left-0 autonumeric" placeholder="Minimum">
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text label-14 bg-white">Rp</span>
                                    </div>
                                    <input type="text" class="form-control text-right label-14 border-left-0 autonumeric" placeholder="Minimum">
                                </div>
                            </li>
                            <li>
                                <label class="w-100 float-left subtitle">Brand</label>
                                <div class="w-100  float-left mb-2">
                                    <label class="container-checkmark">
                                        <span class="label-14">Watu</span>
                                        <input type="checkbox" value="" name="brand">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-100 float-left mb-2">
                                    <label class="container-checkmark">
                                        <span class="label-14">Starling</span>
                                        <input type="checkbox" value="" name="brand">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-100 float-left mb-2">
                                    <label class="container-checkmark">
                                        <span class="label-14">Toye</span>
                                        <input type="checkbox" value="" name="brand">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <label class="w-100 float-left subtitle">Keyword</label>
                                <div class="w-100 float-left mb-2">
                                    <label class="container-checkmark">
                                        <span class="label-14">Organic</span>
                                        <input type="checkbox" value="" name="brand">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-100 float-left mb-2">
                                    <label class="container-checkmark">
                                        <span class="label-14">Vegan friendly</span>
                                        <input type="checkbox" value="" name="brand">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-100 float-left mb-2">
                                    <label class="container-checkmark">
                                        <span class="label-14">Glutten free</span>
                                        <input type="checkbox" value="" name="brand">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-100 float-left mb-2">
                                    <label class="container-checkmark">
                                        <span class="label-14">Cholesterol-free</span>
                                        <input type="checkbox" value="" name="brand">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-100 float-left mb-2">
                                    <label class="container-checkmark">
                                        <span class="label-14">Contain alcohol</span>
                                        <input type="checkbox" value="" name="brand">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <label class="w-100 float-left subtitle">Origin</label>
                                <div class="w-100 float-left mb-2">
                                    <label class="container-checkmark">
                                        <span class="label-14">Kuansing</span>
                                        <input type="checkbox" value="" name="origin">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-100 float-left mb-2">
                                    <label class="container-checkmark">
                                        <span class="label-14">Lampung</span>
                                        <input type="checkbox" value="" name="origin">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-100 float-left mb-2">
                                    <label class="container-checkmark">
                                        <span class="label-14">Kapuas Hulu</span>
                                        <input type="checkbox" value="" name="origin">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-100 float-left mb-2">
                                    <label class="container-checkmark">
                                        <span class="label-14">Magelang</span>
                                        <input type="checkbox" value="" name="origin">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-100 float-left mb-2">
                                    <label class="container-checkmark">
                                        <span class="label-14">Bali</span>
                                        <input type="checkbox" value="" name="origin">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-100 float-left mb-2">
                                    <label class="container-checkmark">
                                        <span class="label-14">Sumba</span>
                                        <input type="checkbox" value="" name="origin">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-100 float-left mb-2">
                                    <label class="container-checkmark">
                                        <span class="label-14">Luwu</span>
                                        <input type="checkbox" value="" name="origin">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <label class="w-100 float-left subtitle pointer"><a href="#">Clear Filter</a></label>
                            </li>
                            <li>
                                <button class="btn btn-pink mt-3  btn-oval btn-search w-100 float-left">
                                    SEARCH
                                </button>
                            </li>
                        </ul>
                </div>
            </div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12 mt-md-0 mt-4">
                <div class="row">
                    <div class="col-lg-5 col-md-5 hidden-768">
                        <form>
                            <label class="sort-by">Sort by :</label>
                            <select id="select-shoppingguide" class="custom-select select-search select-shoppingguide w-auto float-left mb-5 mr-2">
                                <option value='0'>by Popularity</option>
                                <option value='1'>by Origin</option>
                                <option value='2'>by Price (Ascending)</option>
                                <option value='3'>by Price (Descending)</option>
                                <option value='3'>by Brand</option>
                            </select>
                        </form>
                    </div>
                    <div class="col-lg-7 col-md-7 hidden-768">
                        <div class="float-left tagline-prod d-table">
                            <div class="my-auto d-table-cell  align-middle"> *2 Percent of Our Revenue Will be Contributed to World Health Organization&reg;</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @for ($i = 1; $i <= 6; $i++)
                        <div class="col-lg-4 col-mb-4 col-sm-12 col-12 mb-5">
                            <div class="box-img text-center mb-3">
                                <a href="#" data-toggle="modal" data-target="#modal_detail_product"><img src="{{asset('assets/img/product/img'.$i.'.jpg')}}"/></a>
                            </div>
                            <div class="text-center w-100 float-left mb-3 box-name-prod">
                                <div class="label-14 line-clamp-2 "><b>Watu Cashew Nuts original 475 gr</b></div>
                                <div class="label-14">Rp 200.000</div>
                            </div>
                            <div class="w-100 float-left">
                                <div class="box-addcart">
                                    <div class="float-left info mr-1"><a href="{{url('frontend/product/product-detail')}}"><img src="{{asset('assets/img/round-info-button.png')}}"/></a></div>
                                    <div class="input-group cart-count btn-oval border mr-1">
                                        <button class="btn cl-white btn-gray minus rounded-circle" type="button">-</button>
                                        <input type="number" class="form-control txt-qty border-0" value="1" min="1" max="999" aria-label="QTY">
                                        <button class="btn btn-pink plus  rounded-circle" type="button">+</button>
                                    </div>
                                    <button class="btn btn-pink btn-oval btn-addcart">ADD TO CART</button>
                                </div>
                            </div>
                        </div>
                    @endfor
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
	</div>
</div>

@include('template/includes/modals/modal_detail_product')
@endsection

@section('footer')
@include('template/includes/footer')
@endsection

@section('custom_js')
<script src="{{ asset('assets/js/autoNumeric.js') }}"></script>
<script src="{{asset('assets/js/count_qty.js')}}"></script>
<script>
function browse(){
    $(".box-browse").toggleClass('active');
}
function filtershow(){
    $(".box-filter").addClass('active');
}
function filterhide(){
    $(".box-filter").removeClass('active');
}
 jQuery(function ($) {
    $('.autonumeric').autoNumeric('init', {
        vMax: '999999999',
        vMin: '0',
        digitGroupSeparator:'.'
    });
});

	$('#select-shoppingguide').on('change', function (e) {
	    $('#tab-shoppingguide li a').eq($(this).val()).tab('show');
	});
</script>

@endsection
