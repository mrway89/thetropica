@extends('frontend/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/plugins/slick/slick.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/slick/slick-theme.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/raterater/raterater.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-area">
    <div class="container container-product pt-mb-0 pt-3">
		<div class="row">
            <div class="col-md-12 col-sm-6 col-6 offset-md-3 offset-0 pt-md-0 pt-5">
                <h3 class="result pt-md-5 pt-0 visible-768 " onclick="browse()">Browse Product</h3>{{-- mobile --}}
                <!--<h3 class="result mb-4 pt-lg-5 pt-0 hidden-768 ">Browse Product</h3>-->
            </div>


            <!--<div class="box-browse float-left border-bottom visible-768 pt-3">
                @include('frontend.purchase.includes.side_menu')
            </div>-->

			<div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-md-0 mt-2">
                <div class="row">                    
                    <div class="col-lg-12 col-md-5 hidden-768">
                    <label class="sort-by">Product GIFT : </label>
                        <!--<form>
                            <label class="sort-by">Sort by :</label>
                            <select id="select-shoppingguide" class="custom-select select-search select-shoppingguide w-auto float-left mb-5 mr-2">
                                <option value=''>Select Sort</option>
                                <option value='1'>by Popularity</option>
                                <option value='2'>by Origin</option>
                                <option value='3'>by Price (Ascending)</option>
                                <option value='4'>by Price (Descending)</option>
                                <option value='5'>by Brand</option>
                            </select>
                        </form>-->
                    </div>
                    <!--<div class="col-lg-7 col-md-7 hidden-768">
                        <div class="float-left tagline-prod d-table">
                            <div class="my-auto d-table-cell  align-middle"></div>
                        </div>
                    </div>-->
                </div>
                <div id="ajax_product">
                    <div class="row" id="product-list">
                        @foreach ($products as $product)
                            <div class="col-lg-3 col-sm-3 mb-4 shad_box"><br />
                               @if($product->packaging_type == 'sachet')
                                    <div class="box-img-sch text-center mb-2 bg_product_list">
                                        <a class="" href="{{ route('frontend.product.detail', $product->slug) }}"><img src="{{ asset($product->cover->url) }}"/></a>
                                    </div>
                               @else
                                    <div class="box-img text-center mb-2 bg_product_list">
                                        <a class="" href="{{ route('frontend.product.detail', $product->slug) }}"><img src="{{ asset($product->cover->url) }}"/></a>
                                    </div>
                               @endif
                                
                                <div class="text-center w-100 float-left mb-3 box-name-prod">
                                    <div class="label-14 mb-1">
                                        {{ $product->{'title_description_' . $language} }} <br />
                                        {{ $product->packaging_type }}
                                    </div>
                                    <div class="label-14 mb-1">{{ currency_format($product->price) }}</div>
                                    <div class="label-14 cl-red">
                                        <b><i>{{ $product->note }}</i></b>
                                    </div>
                                </div>
                                @if($product->stock >= 1)
                                <div class="w-100 float-left">
                                    <div class="box-addcart">
                                        <div class="float-left info mr-1"><a href="#" class="display_product" data-slug="{{ $product->slug }}"><img src="{{asset('assets/img/star.png')}}"/></a></div>
                                        <div class="input-group cart-count btn-oval border mr-1">
                                            <button class="btn cl-white btn-gray minus rounded-circle" type="button">-</button>
                                            <input type="number" class="form-control txt-qty border-0" value="1" min="1" max="999" aria-label="QTY" id="qty_count{{ $product->id }}">
                                            <button class="btn btn-tropical plus  rounded-circle" type="button">+</button>
                                        </div>
                                        <button class="btn btn-tropical btn-oval btn-addcart add_to_cart_many" data-id="{{ $product->id }}">ADD TO CART</button>
                                    </div><br />
                                </div>
                                @else
                                <div class="w-100 float-left">
                                    <div class="box-addcart min-h-32"></div>
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            {{ $products->links('vendor.pagination.bootstrap-4') }}
                        </div>
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
<script src="{{ asset('assets/js/autoNumeric.js') }}"></script>
<script src="{{asset('assets/js/count_qty.js')}}"></script>
<script src="{{asset('assets/plugins/slick/slick.js')}}"></script>
<script src="{{ asset('assets/plugins/raterater/raterater.js') }}"></script>
<script>
$('#modalReviews').on('shown.bs.modal', function (e) {
    // alert('modal-open close')
    $('body').addClass('modal-open');
})

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
        nextArrow:"<img class='arrow-right thumb' src='../assets/img/right-arrow.png'>",
        responsive: [
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 0,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
        ]
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

$(function() {
    $("body").on('click', '.btn-closemodal', function () {
        $('#modal_detail_product').modal('hide');
    });

    $("body").on('click', '.display_product', function () {
        var slug = $(this).data('slug');
        loadingStart();

        $.ajax({
            type: 'GET',
            url: "{{ url('ajax/product') }}/" + slug,
            cache: true,
            success: function (respond) {
                loadingEnd();
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

    $(document).on('change', '#select-shoppingguide-mobile', function() {
        loadFilterMobile();
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

function filterMobile() {
    var select_brand = '';
    $("input[name='filter_brand_mobile[]']:checked").each(function() {
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

function filterFeatureMobile() {
    var select_feature = '';
    $("input[name='filter_feature_mobile[]']:checked").each(function() {
        if(select_feature != '') select_feature += ',';
        select_feature += $(this).data('name');
    });

    return select_feature;
}

function filterOrigin() {
    var select_origin = '';
    $("input[name='filter_origin[]']:checked").each(function() {
        if(select_origin != '') select_origin += ',';
        select_origin += $(this).data('name');
    });

    return select_origin;
}

function filterOriginMobile() {
    var select_origin = '';
    $("input[name='filter_origin_mobile[]']:checked").each(function() {
        if(select_origin != '') select_origin += ',';
        select_origin += $(this).data('name');
    });

    return select_origin;
}

function filterSort() {
    var select_sort = '';
    select_sort = $('#select-shoppingguide').val();

    return select_sort;
}

function filterSortMobile() {
    var select_sort = '';
    select_sort = $('#select-shoppingguide-mobile').val();

    return select_sort;
}

function loadFilter() {
    loadingStart();
    var query       = filter();
    var query2      = filterSort();
    var query3      = filterFeature();
    var query4      = filterOrigin();
    //var minPrice    = $("#filter_minprice").val().replace(/(\d+),(?=\d{3}(\D|$))/g, "$1");
    //var maxPrice    = $("#filter_maxprice").val().replace(/(\d+),(?=\d{3}(\D|$))/g, "$1");

    var current_url = location.protocol + '//' + location.host + location.pathname;
    //var newurl = current_url + ("?brand=") + query + "&sort=" + query2 + "&price=" + minPrice + "," + maxPrice + "&keyword=" + query3 + "&origin=" + query4;
    var newurl = current_url + ("?sort=") + query2;
    window.history.pushState('Object', 'Title', newurl);

    // $('#product-list').html("<div class='loading-wrapper'><img class='loading-indicator' src='{{ asset("assets/img/loading.gif") }}' width=100 height=100 /></div>");


    /*$("#ajax_product").load(newurl+' #product-list', function() {
        loadingEnd();
    });*/
    
     window.location.href = newurl;

}

function loadFilterMobile() {
    loadingStart();
    var query       = filterMobile();
    var query2      = filterSortMobile();
    var query3      = filterFeatureMobile();
    var query4      = filterOriginMobile();
    //var minPrice    = $("#filter_minprice_mobile").val().replace(/(\d+),(?=\d{3}(\D|$))/g, "$1");
    //var maxPrice    = $("#filter_maxprice_mobile").val().replace(/(\d+),(?=\d{3}(\D|$))/g, "$1");

    var current_url = location.protocol + '//' + location.host + location.pathname;
    //var newurl = current_url + ("?brand=") + query + "&sort=" + query2 + "&price=" + minPrice + "," + maxPrice + "&keyword=" + query3 + "&origin=" + query4;
    var newurl = current_url + ("?sort=") + query2;

    window.history.pushState('Object', 'Title', newurl);

    // $('#product-list').html("<div class='loading-wrapper'><img class='loading-indicator' src='{{ asset("assets/img/loading.gif") }}' width=100 height=100 /></div>");


    $("#ajax_product").load(newurl+' #product-list', function() {
        loadingEnd();
    });

}

var toggler = document.getElementsByClassName("caret");
var i;

for (i = 0; i < toggler.length; i++) {
  toggler[i].addEventListener("click", function() {
    this.parentElement.querySelector(".nested").classList.toggle("active");
    this.classList.toggle("caret-down");
  });
}

$.fn.extend({
    treed: function (o) {
      
      var openedClass = 'glyphicon-minus-sign';
      var closedClass = 'glyphicon-plus-sign';
      
      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };
      
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
      tree.find('.branch .indicator').each(function(){
        $(this).on('click', function () {
            $(this).closest('li').click();
        });
      });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});

//Initialization of treeviews

$('#tree1').treed();

$('#tree2').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});

$('#tree3').treed({openedClass:'glyphicon-chevron-right', closedClass:'glyphicon-chevron-down'});

var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}
</script>

@endsection
