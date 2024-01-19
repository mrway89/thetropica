@extends('template/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/plugins/slick/slick.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/slick/slick-theme.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/raterater/raterater.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/dropzone.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-area">
	<div class="container container-product">
		<div class="row">
			<div class="col-md-9 col-sm-12 col-12 offset-md-3 offset-0 pt-lg-3 pt-md-3 pt-0">
				<h3 class="bold-300 mb-4 pt-lg-5 pt-md-5 pt-0">My Account</h3>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-6">
				@include('template/pages/account/includes/sidemenu')
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12">
                <p class="bold-700 mb-4">My Order</p>

				<div class="w-100 float-left hidden-992">
					<table class="w-100 float-left order-history">
						<tr>
                            <th>Order Number</th>
                            <th>Date</th>
                            <th>Product</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
						<tr>
                            <td>#3522423908</td>
                            <td>22 Feb 2019</td>
                            <td>
                                <div>
                                   <div><i>To: Jalan Bacang 8A</i></div>
                                   <div><b>Watu Multifloral Honey 200ml</b></div>
                                   <div> 3pcs @Rp 150.000,-</div>
                                </div>
                                <div>
                                    <div><b>Watu Cashew Nuts Salted 400ml</b></div>
                                    <div> 3pcs @Rp 150.000,-</div>
                                </div>
                            </td>
                            <td>Rp 850.000,-</td>
                            <td>
                                <div><span>Delivered</span></div>
                                <div><a href="javascript:;" data-dismiss="modal" data-toggle="modal" data-target="#modalAddReviews"><small>Write Review</small></a></div>
                                <button type="text" class="mt-2 btn btn-pink btn-oval btn-addcart">ORDER AGAIN</button>
                            </td>
                        </tr>
						<tr>
                            <td>#3522423908</td>
                            <td>22 Feb 2019</td>
                            <td>
                                <div>
                                    <div>
                                        <div><i>To: Jalan Bacang 8A</i></div>
                                        <div><b>Watu Cashew Nuts Salted 400ml</b></div>
                                        <div> 3pcs @Rp 150.000,-</div>
                                    </div>
                                </div>
                            </td>
                            <td>Rp 1.800.000,-</td>
                            <td>
                                <div><span class="status-waiting">Waiting for payment</span></div>
                            </td>
                        </tr>
						<tr>
                            <td></td>
                            <td></td>
                            <td>
                                <div>
                                    <div>
                                        <div><i>To: Jalan Bacang 8A</i></div>
                                        <div><b>Watu Cashew Nuts Salted 400ml</b></div>
                                        <div> 3pcs @Rp 150.000,-</div>
                                    </div>
                                </div>
                            </td>
                            <td>Rp 1.800.000,-</td>
                            <td>
                                <div><span class="">Delivered in progress</span></div>
                            </td>
                        </tr>
					</table>
                </div>
                {{-- Mobile --}}
                <div class="w-100 float-left visible-992">
                    <table class="w-100float-left order-history">
                        <tr>
                            <th>Order Number</th>
                            <td>#3522423908</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>22 Feb 2019</td>
                        </tr>
                        <tr>
                            <th>Product</th>
                            <td>
                                <div>
                                <div><i>To: Jalan Bacang 8A</i></div>
                                <div><b>Watu Multifloral Honey 200ml</b></div>
                                <div> 3pcs @Rp 150.000,-</div>
                                </div>
                                <div>
                                    <div><b>Watu Cashew Nuts Salted 400ml</b></div>
                                    <div> 3pcs @Rp 150.000,-</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Total Price</th>
                            <td>Rp 850.000,-</td>
                        </tr>
                        <tr>
                          <th class="pb-4">Status</th>
                            <td class="pb-4">
                                <div><span>Delivered</span></div>
                                <button type="text" class="mt-2 btn btn-pink btn-oval btn-addcart">ORDER AGAIN</button>
                            </td>
                        </tr>

                        <tr>
                            <th>Order Number #</th>
                            <td>#3522423908</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>22 Feb 2019</td>
                        </tr>
                        <tr>
                            <th>Product</th>
                            <td>
                                <div>
                                <div><i>To: Jalan Bacang 8A</i></div>
                                <div><b>Watu Multifloral Honey 200ml</b></div>
                                <div> 3pcs @Rp 150.000,-</div>
                                </div>
                                <div>
                                    <div><b>Watu Cashew Nuts Salted 400ml</b></div>
                                    <div> 3pcs @Rp 150.000,-</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Total Price</th>
                            <td>Rp 850.000,-</td>
                        </tr>
                        <tr>
                            <th class="pb-4">Status</th>
                            <td class="pb-4">
                                <div><span class="status-waiting">Waiting for payment</span></div>
                            </td>
                        </tr>

                        <tr>
                            <th>Order Number #</th>
                            <td>#3522423908</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>22 Feb 2019</td>
                        </tr>
                        <tr>
                            <th>Product</th>
                            <td>
                                <div>
                                <div><i>To: Jalan Bacang 8A</i></div>
                                <div><b>Watu Multifloral Honey 200ml</b></div>
                                <div> 3pcs @Rp 150.000,-</div>
                                </div>
                                <div>
                                    <div><b>Watu Cashew Nuts Salted 400ml</b></div>
                                    <div> 3pcs @Rp 150.000,-</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Total Price</th>
                            <td>Rp 850.000,-</td>
                        </tr>
                      <tr>
                            <th class="pb-4">Status</th>
                            <td class="pb-4">
                                <div><span class="">Delivered in progress</span></div>
                            </td>
                        </tr>
                    </table>
                </div>
			</div>
		</div>
	</div>
</div>
@include('template/pages/account/includes/modal_add_review')
@endsection

@section('footer')
@include('template/includes/footer')
@endsection

@section('custom_js')
<script src="{{asset('assets/plugins/slick/slick.js')}}"></script>
<script src="{{asset('assets/js/dropzone.js')}}"></script>
<script src="{{ asset('assets/plugins/raterater/raterater.js') }}"></script>
<script>
    Dropzone.autoDiscover = false;
$('#modalAddReviews').on('shown.bs.modal', function (e) {
    $("#productreview").dropzone({
        maxFilesize: 1,
        parallelUploads: 10,
        acceptedFiles: 'image/*',
        init: function () {
            var myDropzone = this;

            this.on("addedfile", function (file) {
                if (file.size > 1000000) {
                    swal("Error", 'File size have to be lower or equal 1 Mb', "error");
                    this.removeFile(file);
                    return false;
                }
            });
        },

        sending: function(file, xhr, formData) {
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("unique", $('[name=project_unique]').val());
        },
        url: "{{ route("frontend.home") }}",
        success: function (file, response) {
            if(response.status) {
                var data    = response.message;
                return file.previewElement.classList.add("dz-success");
            }
            else {
                var node, _i, _len, _ref, _results;
                var message = response.message;
                file.previewElement.classList.add("dz-error");
                _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                _results = [];
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i];
                    _results.push(node.textContent = message);
                }
                return _results;
            }
        }
    });
});
// $('#modalAddReviews').on('shown.bs.modal', function (e) {
//   // Initialize Dropzone
//     if ($('#productreview').length) {
//         $("div#productreview").dropzone({ url: "/img/review" });
//     // other code here
//     }
// });
//  if ($('#productreview').length) {
//   $("div#productreview").dropzone({ url: "/img/review" });
//   // other code here
// }
// if (document.getElementById('productreview')) {
//     var myDropzone = new Dropzone("div#productreview", { url: "/img/review"});
//   // other code here
// }
// $(document).ready(function () {

    // $("div#productreview").dropzone({ url: "/img/review" });
//     $('.slider-for').slick({
//         slidesToShow: 1,
//         slidesToScroll: 1,
//         arrows: true,
//         fade: true,
//         asNavFor: '.slider-nav',
//         prevArrow:"<img class='arrow-left' src='../../assets/img/left-arrow.png'>",
//         nextArrow:"<img class='arrow-right' src='../../assets/img/right-arrow.png'>"
//     });
//     $('.slider-nav').slick({
//         slidesToShow: 6,
//         slidesToScroll: 1,
//         asNavFor: '.slider-for',
//         dots: false,
//         centerMode: true,
//         focusOnSelect: true,
//         prevArrow:"<img class='arrow-left thumb' src='../../assets/img/left-arrow.png'>",
//         nextArrow:"<img class='arrow-right thumb' src='../../assets/img/right-arrow.png'>"
//     });
//     $('.modal').on('shown.bs.modal', function (e) {
//         $('.slider-for').resize();
//         $('.slider-nav').resize();
//     })
// });
$(function () {
    $('.rateview-md').raterater({
        starWidth: 20,
        spaceWidth: 5,
        numStars: 5
    });
});
</script>
@endsection
