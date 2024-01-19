@extends('frontend/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/plugins/slick/slick.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/slick/slick-theme.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/raterater/raterater.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/dropzone.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-area">
	<div class="container container-product">
		<div class="row">
			<div class="col-md-9 col-sm-12 col-12 offset-md-3 offset-0 pt-lg-3 pt-md-3 pt-0">
				<h3 class="bold-300 mb-4 pt-lg-5 pt-md-5 pt-0">My Account</h3>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-6">
				@include('frontend/pages/account/includes/sidemenu')
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
                        @foreach ($orders as $order)
                            <tr>
                                <td><div id="{{ $order->order_code }}">#{{ $order->order_code }}</div></td>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                                <td>
                                    <div>
                                        <div><i>To: {{ $order->cart->address->address }}</i></div>
                                    </div>
                                    @foreach ($order->details as $detail)
                                        <div>
                                            <div><b>{{  $detail->product->full_name }}</b></div>
                                            <div> {{ $detail->quantity }}pcs <span>@</span>{{ currency_format($detail->price) }},-</div>
                                        </div>
                                    @endforeach
                                </td>
                                <td>{{ currency_format($order->grand_total) }},-</td>
                                <td>
                                    <div>
                                        @switch($order->status)
                                            @case('pending')
                                                <span>Waiting for Payment</span>
                                                @break
                                            @case('paid')
                                                <span>In Progress</span>
                                                @break
                                            @case('sent')
                                                <span>In Progress</span>
                                                @break
                                            @case('completed')
                                                <span>Delivered</span>
                                                @if ($order->haveReview())
                                                    <div>
                                                        <a href="javascript:;" class="give_review" data-id="{{ Crypt::encryptString($order->id) }}"><span>Give Review</span></a>
                                                    </div>
                                                @endif
                                                @break
                                            @case('failed')
                                                <span>Failed</span>
                                                @break
                                            @default
                                                <span>Waiting for Payment</span>
                                        @endswitch
                                    </div>
                                    @if ($order->status == 'completed')
                                        <a href="{{ route('frontend.user.transaction.reorder', $order->encrypted()) }}">
                                            <button type="text" class="mt-2 btn btn-pink btn-oval btn-addcart">ORDER AGAIN</button>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
					</table>
                </div>
                {{-- Mobile --}}
                <div class="w-100 float-left visible-992">
                    <table class="w-100 float-left order-history">
                        @foreach ($orders as $order)
                            <tr>
                                <th>Order Number</th>
                                <td>#{{ $order->order_code }}</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th>Product</th>
                                <td>
                                    <div>
                                        <div><i>To: {{ $order->cart->address->address }}</i></div>
                                    </div>
                                    @foreach ($order->details as $detail)
                                        <div>
                                            <div><b>{{  $detail->product->full_name }}</b></div>
                                            <div> {{ $detail->quantity }}pcs <span>@</span>{{ currency_format($detail->price) }},-</div>
                                        </div>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>Total Price</th>
                                <td>{{ currency_format($order->grand_total) }},-</td>
                            </tr>
                            <tr>
                            <th class="pb-4">Status</th>
                                <td class="pb-4">
                                    <div>
                                        @switch($order->status)
                                            @case('pending')
                                                <span>Waiting for Payment</span>
                                                @break
                                            @case('paid')
                                                <span>In Progress</span>
                                                @break
                                            @case('sent')
                                                <span>In Progress</span>
                                                @break
                                            @case('completed')
                                                <span>Delivered</span>
                                                @if ($order->haveReview())
                                                    <div>
                                                        <a href="javascript:;" class="give_review" data-id="{{ Crypt::encryptString($order->id) }}"><span>Give Review</span></a>
                                                    </div>
                                                @endif
                                                @break
                                            @case('failed')
                                                <span>Failed</span>
                                                @break
                                            @default
                                                <span>Waiting for Payment</span>
                                        @endswitch
                                    </div>
                                    @if ($order->status == 'completed')
                                        <a href="{{ route('frontend.user.transaction.reorder', $order->encrypted()) }}">
                                            <button type="text" class="mt-2 btn btn-pink btn-oval btn-addcart">ORDER AGAIN</button>
                                        </a>
                                    @endif
                                </td>
                            </tr>

                        @endforeach
                    </table>
                </div>
			</div>
		</div>
	</div>
</div>

@include('frontend/pages/account/includes/modal_add_review')
@endsection

@section('footer')
@include('frontend/includes/footer')
@endsection

@section('custom_js')
<script src="{{asset('assets/plugins/slick/slick.js')}}"></script>
<script src="{{ asset('assets/plugins/raterater/raterater.js') }}"></script>
<script src="{{asset('assets/js/dropzone.js')}}"></script>
<script>
Dropzone.autoDiscover = false;

function rateAlert(id, rating){
    $('#rating_review').val(rating);
}

$('#modalAddReviews').on('shown.bs.modal', function (e) {
    $("#productreview").dropzone({
        url: '{{ route('frontend.user.review.store') }}',
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 5,
        maxFiles: 5,
        maxFilesize: 1,
        acceptedFiles: 'image/*',
        addRemoveLinks: true,
        init: function () {
            var myDropzone = this;

            this.on("addedfile", function (file) {
                if (file.size > 1000000) {
                    swal("Error", 'File size have to be lower or equal 1 Mb', "error");
                    this.removeFile(file);
                    return false;
                }
            });

            var submitButton = document.getElementById("submit_review");

            submitButton.addEventListener("click", function () {
                if (!$("#description_review").val()) {
                    swal("Error", 'Please write some reviews in textbox', "error");
                    return false;
                }

                if (!$("#rating_review").val()) {
                    swal("Error", 'Please give some star', "error");
                    return false;
                }

                if (myDropzone.files.length == 0) {
                    var token = '{{ csrf_token() }}';
                    var desc = $("#description_review").val();
                    var prod = $("#product_to_review").val();
                    var rating = $("#rating_review").val();

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('frontend.user.review.store') }}',
                        data: {
                            '_token': token,
                            'description': desc,
                            'product': prod,
                            'rating': rating,
                        },
                        success: function (respond) {
                            location.reload();
                        }
                    });
                }

                myDropzone.processQueue();
            });

            this.on('sendingmultiple', function (data, xhr, formData) {
                formData.append("_token", '{{ csrf_token() }}');
                formData.append("description", $("#description_review").val());
                formData.append("product", $("#product_to_review").val());
                formData.append("rating", $("#rating_review").val());
            });
            this.on("successmultiple", function(files, response) {
                location.reload();
            });

            this.on("errormultiple", function(files, response) {
                swal("Error", response.message, "error");
            });
        }
    });
});

$(document).ready(function() {
    var speed = 1000;

    // check for hash and if div exist... scroll to div
    var hash = window.location.hash;
    if($(hash).length) scrollToID(hash, speed);

    $("body").on('click', '.give_review', function () {
        var id = $(this).data('id');
        loadingStart();

        $.ajax({
            type: 'POST',
            url: "{{ route('frontend.user.review.get') }}",
            data: {
                id: id,
            },
            success: function (respond) {
                loadingEnd();
                $("#product_to_review" ).html(respond.content);
                $('#modalAddReviews').modal('show');
            }
        });
    });

    $('.rateview-md').raterater({
        submitFunction: 'rateAlert',
        starWidth: 20,
        spaceWidth: 5,
        allowChange: true,
        numStars: 5
    });

});


function scrollToID(id, speed) {
    var offSet = 100;
    var obj = $(id).offset();
    var targetOffset = obj.top - offSet;
    $('html,body').animate({ scrollTop: targetOffset }, speed);
}
</script>

@endsection
