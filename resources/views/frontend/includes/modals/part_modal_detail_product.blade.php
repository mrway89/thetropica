
<div class="col-12 p-5">
    <div class="row">
        <div class="col-lg-5 col-md-5">
            <div class="box-popup-img w-100 float-left text-center mb-2">
                <img src="{{ asset($product->cover->url)}}"/>
            </div>
        </div>
        <div class="col-lg-7 col-md-7 pl-0 pr-0">
            <div class="box-desc-popup">
                <div class="w-100 float-left mb-3">
                    <div class="float-left title-img">
                        <img src="{{ asset($product->brand->logo) }}" alt="">
                    </div>
                    <div class="float-left original-nuts d-table box-subtitle">
                        <div class="my-auto align-bottom d-table-cell subtitle_product type-1">
                            <h2>{{ strtolower($product->name) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="w-100 float-left mb-5">
                    <div><span class="bold-700">Origin: </span>{{ $product->origin->name }}.</div>
                @if ($product->specification)
                    @foreach ($product->specification as $spec)
                        <div><span class="bold-700">{{ $spec['name_' . $language . ''] }}: </span>{{ $spec['value_' . $language . ''] }}</div>
                    @endforeach
                @endif
                </div>
                <div class="w-100 float-left">
                    <h4 class="nothing-font">{{ ucwords($product->{'title_description_' . $language}) }}</h4>
                    <p class="nothing-font">
                        {{ strip_tags($product->{'description_' . $language}) }}
                    </p>
                </div>
            </div>
            <div class="w-100 float-left mt-3">
                <div class="w-100 float-left mb-3">
                <a href="javascript:;" data-id='{{ $product->encrypted() }}' class="show_review"><button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2 mb-2">PRODUCT REVIEWS</button></a>
                <a href="{{ route('frontend.product.detail', $product->slug) }}"><button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2 mb-2">MORE INFORMATION</button></a>
                    <div class="input-group cart-count btn-oval border mr-2 mb-2">
                        <button class="btn cl-white btn-gray minus rounded-circle" type="button">-</button>
                        <input type="number" class="form-control txt-qty border-0" id="qty_count_info{{ $product->id }}" value="1" min="1" max="999" aria-label="QTY">
                        <button class="btn btn-pink plus  rounded-circle" type="button">+</button>
                    </div>
                    <button class="btn btn-pink btn-oval btn-addcart-popup add_to_cart_info mb-2" data-id="{{ $product->id }}">ADD TO CART</button>
                </div>
            </div>
        </div>
    </div>
</div>
