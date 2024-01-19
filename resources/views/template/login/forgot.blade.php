@extends('template/layouts/main')

@section('custom_css')
@endsection

@section('content')

<div class="content-area">
	<div class="container">
		<div class="row">
			<div class="col-md-12 pt-md-0 pt-3">
				<h3 class="mt-0 mt-md-5 mb-4 bold-300">Retrieve Password</h3>
				<p class="bold-500">If you need help resetting your password, we can help by sending you a link to reset it</p>
			</div>
			<div class="col-md-5">
				<form class="mb-5">
				  <div class="form-group form-login">
				    <label for="exampleInputEmail1">Username</label>
				    <input required type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Username">
				  </div>
				  <div class="form-group form-login">
				    <label for="exampleInputPassword1">Email Address / Mobile Number</label>
				    <input required type="email" class="form-control" id="exampleInputPassword1" placeholder="Email Address / Mobile Number">
				  </div>
				  <button type="submit" class="btn btn-primary btn-send-about btn-login">SUBMIT</button>
				</form>
			</div>
			<div class="col-md-12 bold-500">
				<ul class="mb-5">
					<li>Check your inbox for a password reset email</li>
					<li>Click on the URL provided in the email and enter a new password</li>
				</ul>

				<p class="mb-3">If you don't see the email in your inbox</p>
				<ul class="mb-5">
					<li>Check your spam/junk folder</li>
					<li>Make sure email address: noreply@talasi.co.id not blocked or make sure all email are always delivered</li>
					<li>If that still does not work, try contacting your email service provider. They are most likely blocking emails from talasi.co.id from being delivered.</li>
					<li>The forgot password feature has been changed</li>
				</ul>
			</div>
		</div>
	</div>
</div>			

@endsection

@section('footer')
@include('template/includes/footer')
@endsection

@section('custom_js')
<!-- <script src="{{ asset('assets/js/fullpage.min.js')}}"></script>
<script>
	$(document).ready(function() {
		$('#fullpage').fullpage({
			//options here
			autoScrolling:true,
			scrollHorizontally: true,
			normalScrollElements: 'footer'
		});

		//methods
		$.fn.fullpage.setAllowScrolling(true);
	});
</script> -->
@endsection
