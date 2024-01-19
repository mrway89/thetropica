<div class="row">
    <div class="col-lg-5 col-md-5" id="review_img_slider">
        <div class="slider-for mb-4">
            @foreach ($images as $image)
                <div class="items">
                    <img src="{{asset($image->url)}}" alt="">
                    <div class="row d-flex justify-content-start mb-4">
                        <div class="col-md-3 star-rating mb-2 position-relative">
                            <div class="ofrate"></div>
                            <div class="rateview-sm" data-id="1" data-rating="{{ $image->review->rating }}"></div>
                        </div>
                        <div class="col-md-9 info-rate">oleh <b>{{ ucwords($image->user->name) }}</b> <small>{{ \Carbon\Carbon::parse($image->created_at)->format('d M Y H:i') }}</small></div>
                    </div>
                </div>
            @endforeach
            </div>
        <div class="slider-nav">
            @foreach ($images as $image)
                <div class="items"><img src="{{asset($image->url)}}" alt=""></div>
            @endforeach
        </div>
    </div>
    <div class="col-lg-7 col-md-7">
        <div class="row d-flex justify-content-start mb-md-0 mb-3">
            <div class="col-md-2 title-rating">Product Quality:</div>
            <div class="col-md-3 d-flex flex-column">
                @php
                $bintang = 0;
                if ($product->review->sum('rating') > 0) {
                    $bintang = $product->review->sum('rating') / $product->review->count();
                }
                @endphp
                <div class="box-value-rating d-flex justify-content-md-left justify-content-center">
                    <span class="value-rating">{{ round($bintang, 1) }}</span><span class="start-rating">/ 5</span>
                </div>
                <div class="star-rating position-relative mb-2 d-flex justify-content-md-left justify-content-center">
                    <div class="ofrate"></div>
                    <div class="rateview-sm" data-id="1" data-rating="{{ $bintang > 0 ? round($bintang, 1) : '0' }}"></div>
                </div>
                <div class="info-rate cl-abuabu d-flex justify-content-md-left justify-content-center">from {{ $bintang > 0 ? $product->review->count() : '0' }} Reviews</div>
            </div>
            <div class="col-md-6">
                <div class="row d-flex justify-content-start">
                    <div class="number-rate">
                        5 <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="5" style="width: {{ $five > 0 ? $five / $reviewCount * 100 : '0' }}%;"></div>
                    </div>
                    <div class="jumlah-rate">{{ $one }}</div>
                </div>
                <div class="row d-flex justify-content-start">
                    <div class="number-rate">
                        4 <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="5" style="width: {{ $four > 0 ? $four / $reviewCount * 100 : '0' }}%;"></div>
                    </div>
                    <div class="jumlah-rate">{{ $two }}</div>
                </div>
                <div class="row d-flex justify-content-start">
                    <div class="number-rate">
                        3 <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="5" style="width: {{ $three > 0 ? $three / $reviewCount * 100 : '0' }}%;"></div>
                    </div>
                    <div class="jumlah-rate">{{ $three }}</div>
                </div>
                <div class="row d-flex justify-content-start">
                    <div class="number-rate">
                        2 <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="5" style="width: {{ $two > 0 ? $two / $reviewCount * 100 : '0' }}%;"></div>
                    </div>
                    <div class="jumlah-rate">{{ $four }}</div>
                </div>
                <div class="row d-flex justify-content-start">
                    <div class="number-rate">
                        1 <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="5" style="width: {{ $one > 0 ? $one / $reviewCount * 100 : '0' }}%;"></div>
                    </div>
                    <div class="jumlah-rate">{{ $five }}</div>
                </div>
            </div>
        </div>

        <div class="row d-flex justify-content-start  mb-md-0 mb-3">
            <div class="col-md-12 title-rating mb-3">Reviews:</div>
            <div class="col-md-12 box-reviews mb-md-0 mb-4">

                @if ($bintang > 0)
                    @foreach ($product->review as $item)

                    <div class="border rounded p-3 mb-3">
                        <div class="row d-flex justify-content-start mb-md-2 mb-3">
                            <div class="col-md-3 star-rating mb-2 position-relative">
                                <div class="ofrate"></div>
                                <div class="rateview-sm" data-id="1" data-rating="{{ $item->rating }}"></div>
                            </div>
                            <div class="col-md-9 info-rate">oleh <b>{{ $item->user->name }}</b> <small>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</small></div>
                        </div>

                        <div class="row d-flex justify-content-between">
                            <div class="col-md-9 message-review">
                                {{ $item->description }}
                            </div>
                            <div class="col-md-3 attach-review  d-flex align-items-end">
                                <a href="#" class="get_review_img" data-id="{{ $item->encrypted() }}" >{{ $item->images->count() }} images</a>
                            </div>
                        </div>
                    </div>

                    @endforeach
                @else
                <div class="border rounded p-3 mb-3">
                    No Review Yet.
                </div>
                @endif

            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 mb-3">
                <a href="{{ route('frontend.product.detail', $product->slug) }}"><button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2  mb-md-0 mb-3">PRODUCT INFORMATION</button></a>
                <div class="input-group cart-count btn-oval border  mb-md-0 mb-3 mr-2">
                    <button class="btn cl-white btn-gray minus rounded-circle" type="button">-</button>
                    <input type="number" class="form-control txt-qty border-0" id="qty_popup_count{{ $product->id }}" value="1" min="1" max="999" aria-label="QTY">
                    <button class="btn btn-pink plus  rounded-circle" type="button">+</button>
                </div>
                <button class="btn btn-pink btn-oval btn-addcart-popup add_to_cart_popup" data-id="{{ $product->id }}">ADD TO CART</button>
            </div>
        </div>
    </div>
</div>
