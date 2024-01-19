@extends('template/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-area">
	<div class="container container-product">
		<div class="row">
			<div class="col-md-9 col-sm-12 col-12 offset-md-3 offset-0 pt-3">
				<h3 class="bold-300 mb-4 pt-5">My Account</h3>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-6">
				@include('template/pages/account/includes/sidemenu')
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12">
				<p class="bold-700 mb-4">My Account Details <a href="{{url('frontend/account/edit-profile')}}" class="ml-3" title="">Edit</a></p>
				<div class="w-100 float-left">
					<table class="w-100 float-left account-detail">
						{{-- <tr>
							<th>Username</th>
							<td>:</td>
							<td>Buyer123</td>
						</tr> --}}
						<tr>
							<th>Name</th>
							<td>:</td>
							<td>Joseph Nathaniel</td>
						</tr>
						<tr>
							<th>Email</th>
							<td>:</td>
							<td>josephnathaniel@gmail.com</td>
						</tr>
						<tr>
							<th>Phone</th>
							<td>:</td>
							<td>0878888866444</td>
						</tr>
						{{-- <tr>
							<td colspan="3">&nbsp;</td>
						</tr> --}}
						{{-- <tr>
							<th>Status</th>
							<td>:</td>
							<td><span class="float-left mr-3">Unverified</span><span class="float-left"><a href="">How to verity</a></span></td>
						</tr>
						<tr>
							<td colspan="3">&nbsp;</td>
						</tr>
						<tr>
							<th>My Coupons</th>
							<td>:</td>
							<td>0</td>
						</tr> --}}
					</table>
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


@endsection
