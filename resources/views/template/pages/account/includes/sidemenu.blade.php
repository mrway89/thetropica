<ul class="list-unstyled list-shoppingguide">
    <li  class="{{Request::segment(3) == 'profile' || Request::segment(3) == 'edit-profile'? 'active':'' }}">
        <a href="{{url('frontend/account/profile')}}">Profile</a>
    </li>
    <li class="{{Request::segment(3) == 'address'? 'active':'' }}">
        <a href="{{url('frontend/account/address')}}">Address</a>
    </li>
    <li class="{{Request::segment(3) == 'order-history'? 'active':'' }}">
    <a href="{{url('frontend/account/order-history')}}">My Order</a>
    </li>
    <li class="{{Request::segment(3) == 'wishlist'? 'active':'' }}">
        <a href="{{url('frontend/account/wishlist')}}">Wishlist</a>
    </li>
    <li class="{{Request::segment(3) == 'talasi_point'? 'active':'' }}">
        <a href="{{url('frontend/account/talasi_point')}}">Talasi Point</a>
    </li>
    <li class="{{Request::segment(3) == 'my_coupon'? 'active':'' }}">
        <a href="{{url('frontend/account/my_coupon')}}">My Coupon</a>
    </li>
    <li class="{{Request::segment(3) == 'referral'||Request::segment(3) == 'referral-invite-success'? 'active':'' }}">
        <a href="{{url('frontend/account/referral')}}">Referral</a>
    </li>
    <li class="{{Request::segment(3) == 'notifications'? 'active':'' }}">
        <a href="{{url('frontend/account/notifications')}}">Notification</a>
    </li>
    <li class="">
        <a href="#">Logout</a>
    </li>
</ul>