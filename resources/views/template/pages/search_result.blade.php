@extends('template/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-area">
	<div class="container container-product">
		<div class="row">
			<div class="col-md-9 col-sm-12 col-12 offset-md-3 offset-0 pt-3">
				<h3 class="result mb-4 pt-md-5 pt-0">Results for "Watu" <small>(11 matches)</small></h3>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-12 col-12 position-relative">
                <label class="title-search visible-768 pointer" onclick="advance()">Advance Search</label>
                <label class="title-search hidden-768">Advanced Search</label>
                <div class="box-list-as float-left">
                    <ul class="list-unstyled list-advance-search">
                        <li>
                            <label class="w-100 float-left">Size</label>
                            <select id="select-shoppingguide" class="custom-select select-shoppingguide select-search w-100 float-left">
                                <option value=''>Select Range</option>
                                <option value='1'>100-250 gr/ml</option>
                                <option value='2'>250-500 gr/ml</option>
                                <option value='3'>500-1000 gr/ml</option>
                            </select>
                        </li>
                        <li>
                            <label>Price</label>
                            <select id="select-shoppingguide" class="custom-select select-shoppingguide select-search w-100 float-left">
                                <option value=''>Select Range</option>
                                <option value='1'>Rp. 100.000 - 200.000</option>
                                <option value='2'>Rp. 200.000 - 500.000</option>
                                <option value='3'>Rp. 500.000 - 1.000.000</option>
                            </select>
                        </li>
                        <li>
                            <label>Promotion</label>
                            <select id="select-shoppingguide" class="custom-select select-shoppingguide select-search w-100 float-left">
                                <option value=''>Select Promotion</option>
                                <option value='1'>Sample Discount</option>
                                
                            </select>
                        </li>
                        <li>
                            <label>Add keyword:</label>
                            <input type="text" class="w-100 float-left txt-search" data-role="tagsinput"  placeholder="Press enter to add"/>
                        </li>
                        <li>
                            <a href="#"><label>Clear Filter</label></a>
                        </li>
                        <li>
                            <button class="btn btn-pink btn-oval btn-search w-100 float-left">
                                SEARCH
                            </button>
                        </li>
                    </ul>
                </div>
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12 mt-md-0 mt-4">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-12">
                        <form>
                            <label class="sort-by">Sort by :</label>
                            <select id="select-shoppingguide" class="custom-select select-shoppingguide select-search w-40 w-mb-70 mb-md-5 mb-0">
                                <option value='0'>Relevance</option>
                                <option value='1'>Newest</option>
                                <option value='2'>by Price (Aascending)</option>
                                <option value='3'>by Price (Descending)</option>
                                <option value='4'>Popularity</option>
                            </select>
                        </form>
                    </div>
                    <div class="col-md-6 col-sm-6 col-12">
                        <ul class="list-unstyled  w-auto view-page">
                            <li>
                                View :
                            </li>
                            <li class="active"><a href="">10</a></li>
                            <li><a href="">20</a></li>
                            <li><a href="">30</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    @for ($i = 1; $i <= 6; $i++)
                        <div class="col-lg-4 col-mb-4 col-sm-6 col-12 mb-5">
                            <div class="box-img text-center mb-2">
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
<script src="{{asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
<script src="{{asset('assets/js/count_qty.js')}}"></script>
<script>
    function advance(){
        $(".box-list-as").toggleClass('active');
    }
	$('#select-shoppingguide').on('change', function (e) {
	    $('#tab-shoppingguide li a').eq($(this).val()).tab('show'); 
	});
</script>	

@endsection
