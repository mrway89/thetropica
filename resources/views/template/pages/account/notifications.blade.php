@extends('template/layouts/main')

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
				@include('template/pages/account/includes/sidemenu')
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12 hidden-768">
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
                        <div class="row mb-2">
                            <div class="col-lg-2 col-md-2 mb-3">
                                <div class="label-14">
                                    <span class="bold-700 mb-0">Joseph</span><br>
                                    <span>Admin</span>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 mb-3">
                                <div class="label-14"><span class="">22 Feb 2019</span></div>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3">
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

                        <div class="row mb-2">
                            <div class="col-lg-2 col-md-2 mb-3">
                                <div class="label-14">
                                    <span class="bold-700 mb-0">Joseph</span><br>
                                    <span>Admin</span>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 mb-3">
                                <div class="label-14"><span class="">22 Feb 2019</span></div>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3">
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
				</div>
            </div>
            {{-- mobile --}}
            <div class="col-lg-9 col-md-9 col-sm-12 col-12 visible-768">
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
            </div>
		</div>
	</div>
</div>			

@endsection

@section('footer')
@include('template/includes/footer')
@endsection

@section('custom_js')
<script src="{{ asset('assets/js/check_all.js') }}"></script>

@endsection
