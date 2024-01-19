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
			<div class="col-lg-9 col-md-9 col-sm-12 col-12">
                <p class="bold-700 mb-4">My Address Book</p>
                <div class="w-100 float-left border-bottom mb-3">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                            <label class="container-checkmark">
                                <div class="label-14"><span class="">Select all</span><span> | </span><span class="cl-black"><a href="">Delete</a></span></div>
                                <input type="checkbox" value="" class="cekall" onchange="checkAll(this)" name="address_list[]">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                            <div class="label-14 float-md-right float-left">
                                {{-- <span class=""><a href="#" data-toggle="modal" data-target="#changeAddress">Change main address</a></span>
                                <span class="cl-blue"> | </span> --}}
                                <span><a href="#" data-toggle="modal" data-target="#addAddress">Add Address +</a></span>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="w-100 float-left">
                    <div class="w-100 float-left mb-3">
                        <label class="container-checkmark">
                            <div class="float-left label-14">
                                <div class="w-100 float-left mb-2">
                                    <span class="float-left"><b>Joseph Nathaniel </b> (Alamat Kos) </span><span class="label-addr btn-oval ml-md-2 ml-0 btn-pink float-left"> MAIN ADDRESS</span>
                                </div>
                                <div class="w-100 float-left">
                                    <span>08788866444</span><br/>
                                    <span>Jalan Bacang 8A</span><br/>
                                    <span>Kebayoran Baru, Kota Administrasi Jakarta Selatan, 12160</span><br/>
                                    <span><a href="#" data-toggle="modal" data-target="#editAddress">Edit address</a></span><span class="cl-blue"> | </span><span><a href="#" data-toggle="modal" data-target="#editPinpoint">Edit pinpoint</a></span>
                                </div>
                            </div>
                            <input type="checkbox" value="" onclick="uncheckAll()" name="address_list">
                            <span class="checkmark"></span>
                        </label>
                    </div>

                    <div class="w-100 float-left mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="container-checkmark">
                                    <div class="float-left label-14">
                                        <div class="w-100 float-left  mb-2">
                                            <span><b>Shalahudin </b> (Alamat Rumah) </span>
                                        </div>
                                        <div class="w-100 float-left">
                                            <span>08788866444</span><br/>
                                            <span>Jalan Bacang 8A</span><br/>
                                            <span>Kebayoran Baru, Kota Administrasi Jakarta Selatan, 12160</span><br/>
                                            <span><a href="#" data-toggle="modal" data-target="#editAddress">Edit address</a></span><span class="cl-blue"> | </span><span><a data-toggle="modal" data-target="#editPinpoint">Edit pinpoint</a></span>
                                        </div>
                                    </div>
                                    <input type="checkbox" onclick="uncheckAll()" value="" name="address_list">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <span class="label-14 float-right md-mt-5 mt-3"><a href="">Set as main address</a></span>
                            </div>
                        </div>
                    </div>

				</div>
			</div>
		</div>
	</div>
</div>			
@include('template/checkout/includes/addaddress')
@include('template/checkout/includes/editaddress')
@include('template/checkout/includes/changeaddress')
@include('template/checkout/includes/editpinpoint')
@endsection

@section('footer')
@include('template/includes/footer')
@endsection

@section('custom_js')
<script src="{{ asset('assets/js/check_all.js') }}"></script>

@endsection
