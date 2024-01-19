@extends('frontend/layouts/main')

@section('custom_css')
@endsection

@section('content')

<div class="content-area">
	<div class="container">
		<div class="row">
			<div class="col-md-12 pt-md-0 pt-3">
				<h3 class="mt-5 mb-4 bold-300 text-center">{{ $trans['reset_password_title'] }}</h3>
			</div>
			<div class="col-md-6 offset-md-3">
				<form class="mb-5" action="{{ route('frontend.user.reset_password_save') }}" method="POST">
					{{ csrf_field() }}
				  <div class="form-group form-login">
				    <label for="new-password">{{ $trans['reset_password_new_label'] }}</label>
				    <input type="password" class="form-control" id="new-password" oninput="setPasswordConfirmValidity();" minlength="8" placeholder="{{ $trans['reset_password_new_placeholder'] }}" name="password">
						<span class="text-danger">{{ $errors->first('password') }}</span>
				  </div>
				  <div class="form-group form-login">
				    <label for="confirm-password">{{ $trans['reset_password_confirm_label'] }}</label>
				    <input type="password" class="form-control" id="confirm-password" oninput="setPasswordConfirmValidity();" minlength="8" placeholder="{{ $trans['reset_password_confirm_placeholder'] }}" name="password_confirmation">
						<span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
				  </div>
				  <button type="submit" class="btn btn-primary btn-send-about w-100">{{ $trans['reset_password_button'] }}</button>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('footer')
{{-- @include('frontend/includes/footer') --}}
@endsection

@section('custom_js')
<script>
	function setPasswordConfirmValidity(str) {
	    const new_password = document.getElementById('new-password');
	    const confirmPasswordReset = document.getElementById('confirm-password');

	    if (new_password.value === confirmPasswordReset.value) {
	         confirmPasswordReset.setCustomValidity('');
	    } else {
	        confirmPasswordReset.setCustomValidity('Passwords must match');
	    }
	    console.log('confirmPasswordReset customError ', document.getElementById('confirmPasswordReset').validity.customError);
	    console.log('confirmPasswordReset validationMessage ', document.getElementById('confirmPasswordReset').validationMessage);
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
