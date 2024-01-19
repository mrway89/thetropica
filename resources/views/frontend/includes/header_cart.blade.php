@if ($carts)
    @if ($carts->details->sum('qty') > 0)
    <div class="basket">
        {{ $carts ? $carts->details->sum('qty') : '' }}
    </div>
    @endif
@endif
<a href="#" title="">
    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
</a>

@if($carts)
    @if ($carts->details->count())
        <div class="dropdown-header border">
            <div class="text-left w-100 float-left title-cart mb-2">
                My Shopping Cart
            </div>
            <div class="list-prod w-100 float-left">
                <ul class="list-unstyled list-cart-top">
                    @foreach($carts->details as $detail)
                    <li>
                        <div class="img-cart-top">
                            <img src="{{ $detail->product->cover->url ? asset($detail->product->cover->url) : asset('assets/img/default-image.jpg') }}" />
                        </div>
                        <div class="detail-cart desc-cart-top">
                            <div class="line-clamp-2">
                                {{ $detail->product->full_name }}
                            </div>
                            <div>
                                Origin:{{ $detail->product->origin->name }}
                            </div>
                            <div>
                                Netto: {{ $detail->product->product_weight . $detail->product->unit }}
                            </div>
                            <div class="mt-2">
                                <div class="row">
                                    <div class="col-6 pr-0">{{ currency_format($detail->product_price) }}</div>
                                    <div class="col-6 pl-2 pr-0"> Amount:{{ $detail->qty }} Piece(s)</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="w-100 float-left">
                <div class="row">
                    <div class="col-6 text-left label-14">Total: <b> {{ $carts->details->sum('qty') }} Piece(s)</b></div>
                    <div class="col-6 text-right label-14 mark-all"><a href="{{ route('frontend.cart.index') }}">See All</a></div>
                </div>
            </div>
        </div>
    @else
        <div class="dropdown-header border">
            <img src="{{asset('assets/img/segitiga-white.png')}}" class="segitiga-putih" />
            <div class="border-bottom text-center w-100 float-left title-cart">
                Keranjang Belanja Anda
            </div>
            <div class="list-prod w-100 float-left">
                <div class="text-center w-100 float-left non-cart"> tidak ada keranjang belanja</div>
            </div>
            <div class="w-100 float-left text-center link-blanja mb-2">
                <a href="{{ route('frontend.cart.index') }}">Lihat Keranjang Belanja <i class="fa fa-caret-right" aria-hidden="true"></i></a>
            </div>
            <div class="w-100 float-left text-center mb-2">
                <a href="{{ route('frontend.cart.index') }}"><button class="btn btn-oval btn-pink label-14">PERIKSA TRANSAKSI</button></a>
            </div>
        </div>
    @endif
    @else
        <div class="dropdown-header border">
            <img src="{{asset('assets/img/segitiga-white.png')}}" class="segitiga-putih" />
            <div class="border-bottom text-center w-100 float-left title-cart">
                Keranjang Belanja Anda
            </div>
            <div class="list-prod w-100 float-left">
                <div class="text-center w-100 float-left non-cart"> tidak ada keranjang belanja</div>
            </div>
            <div class="w-100 float-left text-center link-blanja mb-2">
                <a href="{{ route('frontend.cart.index') }}">Lihat Keranjang Belanja <i class="fa fa-caret-right" aria-hidden="true"></i></a>
            </div>
            <div class="w-100 float-left text-center mb-2">
                <a href="{{ route('frontend.cart.index') }}"><button class="btn btn-oval btn-pink label-14">PERIKSA TRANSAKSI</button></a>
            </div>
        </div>
@endif
