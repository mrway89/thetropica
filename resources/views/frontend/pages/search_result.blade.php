@extends('frontend/layouts/main')

@section('custom_css')

<link href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/slick/slick.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/slick/slick-theme.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/raterater/raterater.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-area">
	<div class="container container-product">
		<div class="row" >
			<div class="col-md-9 offset-3 pt-3" id="count_result_wrapper">
                <div id="count_result">
                    <h3 class="result mb-4 pt-5">Results for "{{ request()->search }}" <small>({{ $products->count() }} matches)</small></h3>
                </div>
			</div>
			<div class="col-md-3">
                <label class="title-search">Advance Search</label>
				<ul class="list-unstyled list-advance-search">
					<li>
                        <label class="w-100 float-left">Size</label>
                        <select id="filter_weight" class="custom-select select-shoppingguide select-search w-100 float-left">
                            <option value=''>Select Range</option>
                            <option value='100-250'>100-250 gr/ml</option>
                            <option value='250-500'>250-500 gr/ml</option>
                            <option value='500-100'>500-1000 gr/ml</option>
                        </select>
					</li>
					<li>
						<label>Price</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text label-14 bg-white">Rp</span>
                            </div>
                            <input type="text" class="form-control text-right label-14 border-left-0 autonumeric" placeholder="Minimum" value="{{ isset(request()->price) ? $lowerprice : '' }}" id="filter_minprice">
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend ">
                                <span class="input-group-text label-14 bg-white">Rp</span>
                            </div>
                            <input type="text" class="form-control text-right label-14 border-left-0 autonumeric max_price" placeholder="Maximum"  value="{{ isset(request()->price) ? $upperprice : '' }}" id="filter_maxprice">
                        </div>
					</li>
					{{-- <li>
						<label>Promotion</label>
                        <select id="select-shoppingguide" class="custom-select select-shoppingguide select-search w-100 float-left">
                            <option value=''>Select Promotion</option>
                            <option value='1'>Sample Discount</option>

                        </select>
					</li>
					<li>
                        <label>Add keyword:</label>
                        <input type="text" class="w-100 float-left txt-search" data-role="tagsinput"  placeholder="Press enter to add"/>
					</li> --}}
					<li>
						<a href="#"><label>Clear Filter</label></a>
                    </li>
                    <li>
                        <button class="btn btn-pink mt-3  btn-oval btn-search w-100 float-left" onclick="loadFilter();">
                            SEARCH
                        </button>
                    </li>
                </ul>
			</div>
			<div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <form>
                            <label class="sort-by">Sort by :</label>
                            <select id="select-shoppingguide" class="custom-select select-shoppingguide select-search w-40 mb-5">
                                <option value='1'>by Popularity</option>
                                <option value='2'>by Origin</option>
                                <option value='3'>by Price (Ascending)</option>
                                <option value='4'>by Price (Descending)</option>
                                <option value='5'>by Brand</option>
                            </select>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled  w-60 view-page">
                            <li>
                                View :
                            </li>
                            <li class="active"><a href="">10</a></li>
                            <li><a href="">20</a></li>
                            <li><a href="">30</a></li>
                        </ul>
                    </div>
                </div>
                <div id="ajax_product">
                    <div class="row" id="product-list">
                        @foreach ($products as $product)
                            <div class="col-lg-4 col-mb-4 mb-5">
                                <div class="box-img text-center mb-2">
                                    <a class="" href="{{ route('frontend.product.detail', $product->slug) }}"><img src="{{ asset($product->cover->url) }}"/></a>
                                </div>
                                <div class="text-center w-100 float-left mb-3 box-name-prod">
                                    <div class="label-14">
                                        {!! $product->display_name !!}
                                    </div>
                                    <div class="label-14">{{ currency_format($product->price) }}</div>
                                </div>
                                <div class="w-100 float-left">
                                    <div class="box-addcart">
                                        <div class="float-left info mr-1"><a href="#" class="display_product" data-toggle="modal" data-target="#modal_detail_product" data-slug="{{ $product->slug }}"><img src="{{asset('assets/img/round-info-button.png')}}"/></a></div>
                                        <div class="input-group cart-count btn-oval border mr-1">
                                            <button class="btn cl-white btn-gray minus rounded-circle" type="button">-</button>
                                            <input type="number" class="form-control txt-qty border-0" value="1" min="1" max="999" aria-label="QTY" id="qty_count{{ $product->id }}">
                                            <button class="btn btn-pink plus  rounded-circle" type="button">+</button>
                                        </div>
                                        <button class="btn btn-pink btn-oval btn-addcart add_to_cart_many" data-id="{{ $product->id }}">ADD TO CART</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
@include('frontend/includes/modals/modal_detail_product')
@include('frontend/includes/modals/modal_reviews')
@endsection

@section('footer')
@include('frontend/includes/footer')
@endsection

@section('custom_js')
<script src="{{asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
<script src="{{ asset('assets/js/autoNumeric.js') }}"></script>
<script src="{{asset('assets/js/count_qty.js')}}"></script>
<script src="{{asset('assets/plugins/slick/slick.js')}}"></script>
<script src="{{ asset('assets/plugins/raterater/raterater.js') }}"></script>
<script>
function initSliderReview() {
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: true,
        asNavFor: '.slider-nav',
        prevArrow:"<img class='arrow-left' src='../assets/img/left-arrow.png'>",
        nextArrow:"<img class='arrow-right' src='../assets/img/right-arrow.png'>"
    });
    $('.slider-nav').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        prevArrow:"<img class='arrow-left thumb' src='../assets/img/left-arrow.png'>",
        nextArrow:"<img class='arrow-right thumb' src='../assets/img/right-arrow.png'>"
    });
    $('.rateview-sm').raterater({
        starWidth: 14,
        spaceWidth: 5,
        numStars: 5
    });
    $('.modal').on('shown.bs.modal', function (e) {
        $('.slider-for').resize();
        $('.slider-nav').resize();
    })
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

$(function() {
    $("body").on('click', '.btn-closemodal', function () {
        $('#modal_detail_product').modal('hide');
    });

    $("body").on('click', '.display_product', function () {
        var slug = $(this).data('slug');

        $.ajax({
            type: 'GET',
            url: "{{ url('ajax/product') }}/" + slug,
            cache: true,
            success: function (respond) {
                $("#modal_content_detail" ).html(respond.content);
                $('#modal_detail_product').modal('show');
            }
        });
    });

    $("body").on('click', '.show_review', function () {
        var id = $(this).data('id');
        loadingStart();

        $.ajax({
            type: 'GET',
            url: "{{ url('ajax/reviews') }}/" + id,
            cache: true,
            success: function (respond) {
                loadingEnd();
                $("#review_content" ).html(respond.content);
                $('#modal_detail_product').modal('hide');
                initSliderReview();
                $('#modalReviews').modal('show');
            }
        });
    });

    $("body").on('click', '.get_review_img', function () {
        var id = $(this).data('id');
        loadingStart();

        $.ajax({
            type: 'GET',
            url: "{{ url('ajax/reviews-image') }}/" + id,
            cache: true,
            success: function (respond) {
                $("#review_img_slider" ).html(respond.content);
                initSliderReview();
                loadingEnd();
            }
        });
    });



    $(document).on('change', '#select-shoppingguide', function() {
        loadFilter();
    });

});



function filter() {
    var select_brand = '';
    $("input[name='filter_brand[]']:checked").each(function() {
        if(select_brand != '') select_brand += ',';
        select_brand += $(this).data('name');
    });

    return select_brand;
}

function filterFeature() {
    var select_feature = '';
    $("input[name='filter_feature[]']:checked").each(function() {
        if(select_feature != '') select_feature += ',';
        select_feature += $(this).data('name');
    });

    return select_feature;
}

function filterSort() {
    var select_sort = '';
    select_sort = $('#select-shoppingguide').val();

    return select_sort;
}

function filterWeight() {
    var select_sort = '';
    select_sort = $('#filter_weight').val();

    return select_sort;
}

function loadFilter() {
    var query       = filter();
    var query2      = filterSort();
    var query3      = filterFeature();
    var query4      = filterWeight();
    var minPrice    = $("#filter_minprice").val().replace(/(\d+),(?=\d{3}(\D|$))/g, "$1");
    var maxPrice    = $("#filter_maxprice").val().replace(/(\d+),(?=\d{3}(\D|$))/g, "$1");

    var current_url = location.protocol + '//' + location.host + location.pathname + "?search={{ request()->search }}";
    var newurl = current_url + ("&brand=") + query + "&sort=" + query2 + "&price=" + minPrice + "," + maxPrice + "&keyword=" + query3 + "&weight=" + query4;


    window.history.pushState('Object', 'Title', newurl);

    // $('#ajax').html("<div class='loading-wrapper'><img class='loading-indicator' src='{{ asset("assets/img/loading.gif") }}' width=100 height=100 /></div>");

    $("#ajax_product").load(newurl+' #product-list');
    $("#count_result_wrapper").load(newurl+' #count_result');
}
</script>

@endsection
