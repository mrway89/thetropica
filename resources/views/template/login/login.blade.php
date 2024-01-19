@extends('template/layouts/main')

@section('custom_css')
@endsection

@section('content')

<div class="content-area">
	<div class="container">
		<div class="row">
			<div class="col-md-5 pt-md-0 pt-3">
				<h3 class="mt-0 mt-md-5 mb-4 bold-300">Login</h3>
				<form class="mb-4">
				  <div class="form-group form-login">
				    <label for="exampleInputEmail1">Account</label>
				    <input required type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Username or Email Address">
				  </div>
				  <div class="form-group form-login">
				    <label for="exampleInputPassword1">Password</label>
				    <a href="{{ url('frontend/forgot') }}" class="float-right" title="">Forgot Password ?</a>
				    <input required type="password" minlength="8" class="form-control" id="exampleInputPassword1" placeholder="Password">
				  </div>
				  <div class="form-group">
				    <input type="checkbox" class="form-check-input" id="exampleCheck1">
				    <label class="form-check-label bold-500" for="exampleCheck1">Stay signed in</label>
				  </div>
				  <button type="submit" class="btn btn-primary btn-send-about btn-login">LOGIN</button>
				</form>
				<a href="#" title="">Mobile number sign in</a>
			</div>
			<div class="col-md-5 d-block d-md-none mt-4">
				<strong class="mt-5">Login with :</strong>
				<div class="social mt-4">
					<a href="#" title=""><img src="{{ asset('assets/img/facebook.png') }}" alt=""></a>
					<a href="#" title=""><img src="{{ asset('assets/img/twitter.png') }}" alt=""></a>
					<a href="#" title=""><img src="{{ asset('assets/img/google.png') }}" alt=""></a>
					<a href="#" title=""><img src="{{ asset('assets/img/linkedin.png') }}" alt=""></a>
				</div>
			</div>
			<div class="col-md-5 offset-md-2 offset-0">
				<h3 class="mt-5 mb-4 bold-300">Sign Up</h3>
				<form>
				  <div class="form-group form-login">
				    <label for="exampleInputEmail1">Email Address</label>
				    <input required type="email" pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email Address / Mobile Number">
				  </div>
				  <div class="form-group form-login">
				    <label for="exampleInputEmail1">Mobile Number (Optional)</label>
				    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" onkeypress='validate(event)' placeholder="Mobile Number (Optional)">
				  </div>
				  <div class="form-group form-login">
				    <label for="exampleInputEmail1">Full Name</label>
				    <input required type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Full Name">
				  </div>
				  <div class="form-group form-login">
				    <label for="exampleInputPassword1">Password</label>
				    <input required type="password" minlength="8" class="form-control" id="exampleInputPassword1" placeholder="Password">
				  </div>
				  <div class="form-group">
				    <input required type="checkbox" class="form-check-input" id="signup">
				    <label class="form-check-label bold-500" for="signup">Upon creating my account, I agree to:
				    	<ul class="line-height12">
					    	<li>The <a href="#">Talasi.co.id User Agreement</a></li>
					    	<li>Receive emails related to Talasi.co.id membership and services</li>
					    </ul>
					</label>
				  </div>
				  <button type="submit" class="btn btn-primary btn-send-about btn-login mb-5">SIGN UP</button>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-md-5 d-none d-md-block">
				<strong class="mt-5">Login with :</strong>
				<div class="social mt-4">
					<a href="#" title=""><img src="{{ asset('assets/img/facebook.png') }}" alt=""></a>
					<a href="#" title=""><img src="{{ asset('assets/img/twitter.png') }}" alt=""></a>
					<a href="#" title=""><img src="{{ asset('assets/img/google.png') }}" alt=""></a>
					<a href="#" title=""><img src="{{ asset('assets/img/linkedin.png') }}" alt=""></a>
				</div>
			</div>

			<div class="col-md-5 offset-md-2 offset-0">
				<strong class="mt-5">Sign up faster with :</strong>
				<div class="social text-md-left  mt-4">
					<a href="#" title=""><img src="{{ asset('assets/img/facebook.png') }}" alt=""></a>
					<a href="#" title=""><img src="{{ asset('assets/img/twitter.png') }}" alt=""></a>
					<a href="#" title=""><img src="{{ asset('assets/img/google.png') }}" alt=""></a>
					<a href="#" title=""><img src="{{ asset('assets/img/linkedin.png') }}" alt=""></a>
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

<script>
	function validate(evt) {
	  var theEvent = evt || window.event;

	  // Handle paste
	  if (theEvent.type === 'paste') {
	      key = event.clipboardData.getData('text/plain');
	  } else {
	  // Handle key press
	      var key = theEvent.keyCode || theEvent.which;
	      key = String.fromCharCode(key);
	  }
	  var regex = /[0-9]|\./;
	  if( !regex.test(key) ) {
	    theEvent.returnValue = false;
	    if(theEvent.preventDefault) theEvent.preventDefault();
	  }
	}
</script>

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
