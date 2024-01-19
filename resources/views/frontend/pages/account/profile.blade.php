@extends('frontend/layouts/main')

@section('custom_css')
@endsection

@section('content')

<div class="content-area">
	<div class="container container-product">
		<div class="row">
			<div class="col-md-9 col-sm-12 col-12 offset-md-3 offset-0 pt-3">
				<h3 class="bold-300 mb-4 pt-5">My Account</h3>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-6">
				@include('frontend/pages/account/includes/sidemenu')
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12">
				<p class="bold-700 mb-4">My Account Details <a href="{{ route('frontend.user.profile.edit') }}" class="ml-3" title="">Edit</a></p>
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
							<td>{{ \Auth::user()->name }}</td>
						</tr>
						<tr>
							<th>Email</th>
							<td>:</td>
							<td>{{ \Auth::user()->email }}</td>
						</tr>
						<tr>
							<th>Phone</th>
							<td>:</td>
							<td>+62 {{ \Auth::user()->phone }}</td>
						</tr>
						<tr>
							<th>Reward Points</th>
							<td>:</td>
							<td>{{ \Auth::user()->creditbalance() ? numbering_format(\Auth::user()->creditbalance()) : '0' }} &nbsp; <i class="fa fa-info-circle pointer" data-toggle="popover" data-content="You got reward point for each completed purchase. You can exchange your reward point." data-trigger="hover"></i></td>
						</tr>
						<tr>
							<th>User Level</th>
							<td>:</td>
						<td>{{ $level ? $level->name . ' (' . $level->percentage . '%)' : 'Level 1' }} &nbsp; <i class="fa fa-info-circle pointer" data-toggle="popover" data-content="Your user level increase based on your completed purchase. you got points cashback {{ $level->percentage }}% for each total purchase" data-trigger="hover"></i></td>
						</tr>
						<tr>
							<th>Completed Purchase</th>
							<td>:</td>
							<td>{{ currency_format($total) }}</td>
						</tr>
						{{-- <tr>
							<td colspan="3">{{ \Auth::user()->rewardPercentage() }}</td>
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
@include('frontend/includes/footer_scrollspy')
@endsection

@section('custom_js')


@endsection
