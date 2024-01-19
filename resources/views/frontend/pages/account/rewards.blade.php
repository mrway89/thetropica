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
				<h3 class="bold-300 mb-4 pt-md-5 pt-0">My Account</h3>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-6">
                @include('frontend/pages/account/includes/sidemenu')
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12 ">
                <p class="bold-700 mb-4">Reward Point Exchange <span class="pull-right">My Reward Points : {{ number_format(\Auth::user()->creditBalance()) }}</span></p>
                {{-- <p class="bold-700 pull-right">

                </p> --}}
                <div class="w-100 float-left border-bottom">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                            <label class="container-checkmark">
                                {{-- <div class="label-14"><span class="">Select all</span><span> | </span><span><a href="" class="text-dark" id="btn_delete_wishlist">Delete</a></span></div> --}}
                                {{-- <input type="checkbox" value="" onchange="checkAll(this)" name="address_list[]">
                                <span class="checkmark"></span> --}}
                            </label>
                        </div>
                    </div>
                </div>
				<div class="w-100 float-left">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="cuopon-list-tab" data-toggle="tab" href="#cuopon-list" role="tab" aria-controls="cuopon-list" aria-selected="true">
                                Cuopon List
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">
                                History
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="cuopon-list" role="tabpanel" aria-labelledby="cuopon-list-tab">
                            @foreach ($cuopons as $cuopon)
                                <div class="w-100 float-left">
                                    <div class="row product pl-3 mt-3">
                                        <label class="container-checkmark col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <img src="{{ asset($cuopon->images) }}" class="img-fluid rounded " alt="">
                                                </div>
                                                {{-- <div class="col-lg-10 col-md-9 col-sm-9 col-9">
                                                    <p class="mb-0 bold-700">{{ $wishlist->product->full_name }}</p>
                                                    <p class="mb-0"><span class="bold-700">Origin:</span> {{ $wishlist->product->origin->name }}</p>
                                                    <p class="mb-2"><span class="bold-700">Netto:</span> {{ $wishlist->product->product_weight . ' ' . $wishlist->product->unit }}</p>

                                                    <p class="mb-2 bold-700 product-line-price">{{ currency_format($wishlist->product->price) }}</p>
                                                    <a href="#" title="" class="btn_delete_wishlist"  data-id="{{ $wishlist->id }}">Remove from wishlist</a>
                                                </div> --}}
                                            </div>
                                        </label>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-9 pl-lg-3 pl-sm-0 pl-4 ml-addcart mt-lg-5 mt-md-5 mt-5">
                                            <div class="input-group input-group-number w-40 float-left">
                                                {{ $cuopon->points }} Points
                                                {{-- <form class="d-flex">
                                                    <div id="field1" class="input-group-btn">
                                                        <button type="button" id="sub" class="btn btn-default btn-gray btn-number sub">-</button>
                                                        <input type="text" id="1" value="1" min="1" max="1000" class="form-control input-number" id="qty_count{{ $wishlist->product->id }}" />
                                                        <button type="button" id="add" class="btn btn-default btn-number add">+</button>
                                                    </div>
                                                </form> --}}
                                            </div>
                                            <div class="w-60 float-right">
                                                @if ($cuopon->points <= \Auth::user()->creditBalance())
                                                    <button class="checkout btn-send-about w-90 px-0 ml-3 buy_cuopon" data-id="{{ $cuopon->id }}">Redeem</button>
                                                @else
                                                    <button class="checkout btn-send-about w-90 px-0 ml-3 btn-gray" disabled>Redeem</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                            <div class="table-responsive ">
                                <table class="table table-hover table-bordered ">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col"></th>
                                            <th scope="col">Cuopon</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($histories as $i=>$history)
                                        <tr>
                                            <th scope="row">{{ $i + 1 }}</th>
                                            <td>
                                                <img src="{{ asset($history->cuopon->images) }}" class="" alt="" height=50>
                                            </td>
                                            <td>
                                                {{ $history->cuopon->name }}
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($history->created_at)->format('d F Y H:i') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
				</div>
			</div>
		</div>

        <div class="row">
            <div class="col-12">
                {{-- {{ $wishlists->links() }} --}}
            </div>
        </div>
	</div>
</div>

@endsection

@section('footer')
@include('frontend/includes/footer')
@endsection

@section('custom_js')
<script>
$(document).ready(function () {
    $("body").on('click', '.buy_cuopon', function (e) {
        e.preventDefault();

        loadingStart();

        var cuopon = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: "{{ route('frontend.user.reward.exchange') }}",
            data:
            {
                "cuopon": cuopon,
                "_token" : "{{ csrf_token() }}"
            },
            success: function (respond) {
                location.reload();
            }
        });
    });
});
</script>
@endsection
