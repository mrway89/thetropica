@extends('frontend/layouts/main')

@section('custom_css')
<style>
.content-area ul {
    padding-inline-start: 20px !important;
}
</style>
@endsection

@section('content')

<div class="content-area">
	<div class="container">
		<div class="row">
			<div class="col-md-12 pt-md-0 pt-3">
				<h3 class="mt-0 mt-md-5 mb-4 bold-300">{{ $trans['forgot_title'] }}</h3>
				<p class="bold-500">{{ $trans['forgot_description'] }}</p>
			</div>
			<div class="col-md-5">
				<form class="mb-5" action="{{ route('frontend.forgot.post') }}" method="POST">
					{{ csrf_field() }}
					<div class="form-group form-login">
						<label for="PasswordInput">{{ $trans['forgot_email_label'] }}</label>
						<input type="text" class="form-control" id="PasswordInput" placeholder="{{ $trans['forgot_email_placeholder'] }}" name="forgot_email" value="{{ old('forgot_email') }}">
						<span class="text-danger">{{ $errors->first('forgot_email') }}</span>
					</div>
					<button type="submit" class="btn btn-primary btn-send-about btn-login">{{ $trans['forgot_email_button'] }}</button>
				</form>
			</div>
			<div class="col-md-12 bold-500">
				{!! $tutorial->{'content_' . $language} !!}
			</div>
		</div>
	</div>
</div>

@endsection

@section('footer')
{{-- @include('frontend/includes/footer') --}}
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
