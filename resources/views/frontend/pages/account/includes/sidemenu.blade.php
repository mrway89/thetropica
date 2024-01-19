<ul class="list-unstyled list-shoppingguide">
    <li  class="{{Request::segment(2) == 'profile' || Request::segment(2) == 'edit-profile'? 'active':'' }}">
        <a href="{{ route('frontend.user.profile') }}">Profile</a>
    </li>
    <li class="{{Request::segment(2) == 'address'? 'active':'' }}">
        <a href="{{ route('frontend.user.address') }}">Address</a>
    </li>
    <li class="{{Request::segment(2) == 'order-history'? 'active':'' }}">
    <a href="{{ route('frontend.user.transaction') }}">My Order</a>
    </li>
    <li class="{{Request::segment(2) == 'wishlist'? 'active':'' }}">
        <a href="{{ route('frontend.user.wishlist') }}">Wishlist</a>
    </li>
    <li class="{{Request::segment(2) == 'reward-point'? 'active':'' }}">
        <a href="{{ route('frontend.user.reward') }}">Talasi Point</a>
    </li>
    <li class="{{Request::segment(2) == 'my-coupon'? 'active':'' }}">
        <a href="{{ route('frontend.user.coupon')}}">My Coupon</a>
    </li>
    <li class="{{Request::segment(2) == 'referral' ? 'active':'' }}">
        <a href="{{ route('frontend.user.referral') }}">Referral</a>
    </li>
    <li class="{{Request::segment(2) == 'notification'? 'active':'' }}">
        <a href="{{ route('frontend.user.notification') }}">Notification</a>
    </li>
    <li class="">
        <a href="{{ route('frontend.logout') }}">Logout</a>
    </li>
</ul>
