@extends('frontend/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
<style>
.btn-gray {
    cursor: not-allowed;
}

.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    border: none;
}

.nav-tabs .nav-link.active {
    color:#000 !important;
}

.nav-tabs .nav-link:focus, .nav-tabs .nav-link:hover {
    border: #fff;
}
</style>
@endsection

@section('content')
<div class="content-area">
	<div class="container container-product">
		<div class="row">
            <div class="col-md-9 col-sm-12 col-12 offset-md-3 offset-0 pt-3">
				<h3 class="bold-300 mb-4 pt-5 ">Talasi Point</h3>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-6">
				@include('frontend/pages/account/includes/sidemenu')
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-3 text-center-mb">
                        <p class="bold-700 mb-2 border-top-mb pt-mb-0 pt-3">My Talasi Points: </p>
                        <div class="point">{{ number_format(\Auth::user()->creditBalance()) }}</div>
                    </div>
                    <div class="col-md-9 desc-talasi-point">
                        {!! $content->{'content_' . $language} !!}
                    </div>
                </div>
                <div class="mb-5 desc-talasi-point border-bottom-mb pb-mb-3 pb-5">
                    {!! $content->other_content !!}
                </div>
               <div class="row">
                    @foreach ($cuopons as $cuopon)
                        <div class="col-md-6 position-relative pt-3 mb-5">
                                <div class="ket_coupon position-absolute bg-orange text-truncate text-center">{{ $cuopon->points }} Talasi Point</div>
                            {{-- <div class="new-coupon position-absolute"><img src="{{asset('assets/img/new.png')}}" alt=""></div> --}}
                            <div class="coupon mb-3">
                                <img src="{{ asset($cuopon->images) }}" alt="">
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-mb-6 col-12 mb-md-0 mb-3  pl-md-3  pr-md-3 pl-5 pr-5">
                                    <a href="#" class="coupon_detail" data-id="{{ Crypt::encryptString($cuopon->id) }}">
                                        <button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2  w-100">ABOUT THIS COUPON</button>
                                    </a>
                                </div>
                                <div class="col-lg-6 col-mb-6 col-12 mb-md-0 mb-3 pr-md-3  pl-md-3 pl-5 pr-5">
                                    @if ($cuopon->points <= \Auth::user()->creditBalance())
                                        <button class="btn btn-pink btn-oval btn-addcart-popup w-100 buy_cuopon" data-id="{{ Crypt::encryptString($cuopon->id) }}">GET THIS COUPON</button>
                                    @else
                                        <button class="btn btn-pink btn-oval btn-addcart-popup w-100 btn-gray" disabled>GET THIS COUPON</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                   @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@include('frontend.pages.account.includes.modal_about_coupon')
@endsection

@section('footer')
@include('frontend/includes/footer')
@endsection

@section('custom_js')
<script>
$(document).ready(function () {
    $("body").on('click', '.coupon_detail', function (e) {
        e.preventDefault();
        loadingStart();

        var coupon  = $(this).data('id');
        var vc      = $(this).data('vc');

        $.ajax({
            type: 'POST',
            url: "{{ route('frontend.user.get.coupon') }}",
            data:
            {
                "coupon": coupon,
                "_token" : "{{ csrf_token() }}"
            },
            success: function (respond) {
                console.log(respond.message);
                loadingEnd();
                $('#modal_coupon_container').html(respond.message);
                $('#modal_aboutcoupon').modal('show');
            }
        });
    });

    $("body").on('click', '.buy_cuopon', function (e) {
        e.preventDefault();
        var coupon = $(this).data('id');

        swal({
            title: "Apakah anda yakin membeli kupon ini?",
            text: "Anda tidak dapat membatalkan penukaran setelah konfirmasi tombol beli di bawah",
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonText: 'Beli',
            showLoaderOnConfirm: true,
            confirmButtonColor: "#ff5656",
            preConfirm: () => {
                    loadingStart();
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('frontend.user.reward.exchange') }}",
                        data:
                        {
                            "coupon": coupon,
                            "_token" : "{{ csrf_token() }}"
                        },
                        success: function (respond) {
                            location.reload();
                        }
                    });

                }

        })
    });
});
</script>

@endsection
