<div class="col-lg-3 col-md-3 col-sm-6 col-6">
    <ul class="list-unstyled list-shoppingguide">
        <li class="{{Request::segment(2) == 'product-list' ? 'active':''}}">
            <a href="{{url('frontend/product-list')}}">Browse Product</a>
        </li>
        <li class="{{Request::segment(2) == 'compare-product' ? 'active':''}}">
            <a href="{{url('frontend/compare-product')}}">Compare Product</a>
        </li>
        <li class="{{Request::segment(2) == 'faq' ? 'active':''}}">
            <a href="{{url('frontend/faq')}}">FAQ</a>
        </li>
        <li class="{{Request::segment(2) == 'shopping-guide' ? 'active':''}}">
             <a href="{{url('frontend/shopping-guide')}}">Shopping Guide</a>
        </li>
        <li class="{{Request::segment(2) == 'payment-guide' ? 'active':''}}">
            <a href="{{url('frontend/payment-guide')}}">Payment Guide</a>
        </li>
        {{-- <li class="{{Request::segment(2) == 'pickup_point' ? 'active':''}}">
            <a href="{{url('frontend/pickup-point')}}">Pick Up Point</a>
        </li> --}}
    </ul>
</div>