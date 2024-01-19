<div class="outDiv"></div>

<a href="" class="delete_compare" data-id="{{ $select }}">
    <img class="closebox" src="{{asset('assets/img/closebox.png')}}"/>
</a>

<div class="divOne">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-6 col-6 position-relative">
            <center>
                <img src="{{ asset($detail->cover->url) }}" class="mb-5 reflect" alt="">
            </center>
            <div class="w-100 float-left">
                <div class="row justify-content-md-center">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 pr-md-0 mb-md-0 mb-2">
                        <div class="input-group input-group-number">
                            <form class="d-flex">
                                <div id="field1" class="input-group-btn">
                                    <button type="button" id="sub" class="btn btn-default btn-gray btn-number sub">-</button>
                                    <input type="text" value="1" min="1" max="1000" class="form-control input-number" id="qty_count{{ $detail->id }}" />
                                    <button type="button" id="add" class="btn btn-default btn-number add">+</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 pr-md-0">
                        <button type="button" class="btn btn-addtocart-small add_to_cart_many" data-id="{{ $detail->id }}">ADD TO CART</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-6 col-6">
            <div class="product-detail-compare mt-md-5 mt-0">
                <img src="{{ asset($detail->brand->logo)}}" class="w-50 compare-logo" alt="">
                <h3 class="mb-2">{{ ucwords($detail->name) }}</h3>
                <p><span class="bold-700">Price : </span>{{ currency_format($detail->price) }}</p>

                @if ($detail->specification)
                    @foreach ($detail->specification as $spec)
                    <p><span class="bold-700">{{ $spec['name_' . $language . ''] }} : </span>{{ $spec['value_' . $language . ''] }}</p>
                    @endforeach
                @endif

                {{-- <p><span class="bold-700">Certification:</span><br></p> --}}

                @foreach ($detail->certifications as $cert)
                    <img src="{{ asset($cert->url)}}" class="img-stamp" alt="">
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="divTwo">
    <div class="w-100 float-left justify-content-md-center mt-5 pt-5">
        <div class="w-100 float-left">
            <select id="select_{{ $select }}" class="custom-select w-100">
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ ucwords($product->name) . ' ' . $product->product_weight . ' ' . $product->unit }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
