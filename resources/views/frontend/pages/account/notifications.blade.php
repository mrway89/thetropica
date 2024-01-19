@extends('frontend/layouts/main')

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
				@include('frontend/pages/account/includes/sidemenu')
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12">
                <p class="bold-700 mb-4">My Notification</p>
                <div class="w-100 float-left border-bottom mb-3">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 mb-3">
                            <div class="label-14"><span class="">From</span></div>
                        </div>
                        <div class="col-lg-2 col-md-2 mb-3">
                            <div class="label-14"><span class="">Date</span></div>
                        </div>
                        <div class="col-lg-6 col-md-6 mb-3">
                            <div class="label-14"><span class="">Message</span></div>
                        </div>
                    </div>
                </div>
				<div class="w-100 float-left">
                    <div class="w-100 float-left mb-3">
                        @if ($notifications->count())
                            @foreach ($notifications as $notification)
                                @if ($notification->type == "App\Notifications\OrderNotification")

                                    @php
                                    $order = $user->orderCheck($notification->data['order_id']);
                                    @endphp
                                    <div class="row mb-2">
                                        <div class="col-lg-2 col-md-2 mb-3">
                                            <div class="label-14">
                                                <span class="bold-700 mb-0">Talasi</span><br>
                                                {{-- <span>Admin</span> --}}
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 mb-3">
                                            <div class="label-14"><span class="">{{ Carbon\Carbon::parse($notification->created_at)->format('j M Y') }}</span></div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 mb-3">
                                            <div class="label-14">
                                                <p>
                                                    @if ($notification->data['status'] == 'pending')
                                                    Harap lakukan pembayaran sebesar <b>{{ currency_format($order->grand_total) }}</b> untuk pesanan <b><a href="{{ route('frontend.user.transaction') }}#{{ $order->order_code }}">#{{ $order->order_code }}</a></b> sebelum <b>{{ Carbon\Carbon::parse($order->created_at)->addDays(1)->format('j F Y') }}, pukul {{ Carbon\Carbon::parse($order->created_at)->addDays(1)->format('H:i') }} WIB</b> untuk menghindari pembatalan.
                                                    @endif
                                                    @if ($notification->data['status'] == 'paid')
                                                    Anda berhasil melakukan pembayaran sebesar <b>{{ currency_format($order->grand_total) }}</b> untuk pesanan <b><a href="{{ route('frontend.user.transaction') }}#{{ $order->order_code }}">#{{ $order->order_code }}</a></b>. Tim kami akan segera melanjutkan untuk proses pengiriman. Terima kasih.
                                                    @endif
                                                    @if ($notification->data['status'] == 'sent')
                                                    Pesanan anda sudah dalam proses pengiriman dengan no. resi <b>{{ $order->no_resi }}</b>
                                                    @endif
                                                    @if ($notification->data['status'] == 'completed')
                                                    Pesanan <b><a href="{{ route('frontend.user.transaction') }}#{{ $order->order_code }}">#{{ $order->order_code }}</a></b> telah selesai. Mohon berikan review untuk produk kami. Terima kasih.
                                                    @endif
                                                    @if ($notification->data['status'] == 'failed')
                                                    Pesanan <b><a href="{{ route('frontend.user.transaction') }}#{{ $order->order_code }}">#{{ $order->order_code }}</a></b> telah dibatalkan karena telah melewati batas waktu pembayaran oleh sistem kami. Silahkan berbelanja kembali di Talasi. Terima kasih.
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                @else

                                <div class="row mb-2">
                                    <div class="col-lg-2 col-md-2 mb-3">
                                        <div class="label-14">
                                            <span class="bold-700 mb-0">Talasi</span><br>
                                            {{-- <span>Admin</span> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 mb-3">
                                        <div class="label-14"><span class="">{{ Carbon\Carbon::parse($notification->created_at)->format('j M Y') }}</span></div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 mb-3">
                                        <div class="label-14">
                                            @if ($notification->data['order_id'])
                                                @php
                                                    $order = $user->orderCheck($notification->data['order_id']);
                                                @endphp
                                                <p>Selamat anda mendapatkan {{ numbering_format($notification->data['points']) }} Talasi Point dari pesanan {{ $order->order_code }}</p>
                                            @else
                                                <p>Selamat anda mendapatkan {{ $notification->data['note'] }} sebesar {{ numbering_format($notification->data['points']) }} Talasi Point</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @endif
                            @endforeach
                        @endif
                    </div>
				</div>
            </div>

            {{-- mobile --}}
            {{-- <div class="col-lg-9 col-md-9 col-sm-12 col-12 visible-768">
                <div class="w-100 float-left border-top">
                    <div class="row">
                        <div class="col-sm-4 col-4 mt-3"><div class="label-14"><span class="">From</span></div></div>
                        <div class="col-sm-8 col-8 mt-3">
                            <div class="label-14">
                                <span class="bold-700 mb-0">Joseph </span>
                                <span>Admin</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-4 mt-3"><div class="label-14"><span class="">Date</span></div></div>
                        <div class="col-sm-8 col-8 mt-3">
                            <div class="label-14"><span class="">22 Feb 2019</span></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-12 mt-3"><div class="label-14"><span class="">Message</span></div></div>
                        <div class="col-sm-12 col-12 mt-3">
                            <div class="label-14">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100 float-left border-top">
                    <div class="row">
                        <div class="col-sm-4 col-4 mt-3"><div class="label-14"><span class="">From</span></div></div>
                        <div class="col-sm-8 col-8 mt-3">
                            <div class="label-14">
                                <span class="bold-700 mb-0">Ali Haliman </span>
                                <span>Founder of Talasi</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-4 mt-3"><div class="label-14"><span class="">Date</span></div></div>
                        <div class="col-sm-8 col-8 mt-3">
                            <div class="label-14"><span class="">22 Feb 2019</span></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-12 mt-3"><div class="label-14"><span class="">Message</span></div></div>
                        <div class="col-sm-12 col-12 mt-3">
                            <div class="label-14">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
		</div>
	</div>
</div>

@endsection

@section('footer')
@include('frontend/includes/footer_scrollspy')
@endsection

@section('custom_js')
<script src="{{ asset('assets/js/check_all.js') }}"></script>

@endsection
