<ul class="list-unstyled list-shoppingguide {{Request::segment(2) == 'product-list' ? 'mb-5' : '' }}">
    <li class="{{Request::segment(2) == 'product-list' ? 'active' : '' }}">
        <a href="{{ route('frontend.product.purchase')}}">{{ $trans['purchase_side_menu_browse_product'] }}</a>
    </li>
       <li class="{{Request::segment(2) == 'faqs' ? 'active' : '' }}">
        <a href="{{ route('frontend.guide.faqs') }}">{{ $trans['purchase_side_menu_faqs'] }}</a>
    </li>
    <li class="{{Request::segment(2) == 'shopping-guide' ? 'active' : '' }}">
        <a href="{{ route('frontend.guide.shopping') }}">{{ $trans['purchase_side_menu_shopping_guide'] }}</a>
    </li>
    <li class="{{Request::segment(2) == 'payment-guide' ? 'active' : '' }}">
        <a href="{{ route('frontend.guide.payment') }}">{{ $trans['purchase_side_menu_payment_guide'] }}</a>
    </li>
</ul>
