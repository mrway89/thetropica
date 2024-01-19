@extends('frontend/layouts/main')

@section('custom_css')
<style>
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input[type=number] {
    -moz-appearance:textfield;
}
</style>
@endsection

@section('content')

<div class="content-area">
	<div class="container">
		<div class="row pt-md-0 pt-4">
			<div class="col-md-5 pt-md-0 pt-5">
				<h3 class="mt-0 mt-md-5 mb-4 bold-300">{{ $trans['login_title'] }}</h3>
				<form action="{{ route('frontend.login.post') }}" method="POST" class="mb-4">
					{{ csrf_field() }}
					<input type="hidden" value="{{ url()->previous() }}" name="previous">
					@if (\Session::has('error_forgot'))
					<span class="text-danger">{{ \Session::get('error_forgot') }}</span>
					@endif
				  <div class="form-group form-login">
				    <label for="exampleInputEmail1">{{ $trans['login_username_label'] }}</label>
				    <input type="text" class="form-control" placeholder="{{ $trans['login_username_placeholder'] }}" name="login_email" value="{{ old('login_email') }}" required>
						<span class="text-danger">{{ $errors->first('login_email') }}</span>
				  </div>
				  <div class="form-group form-login">
				    <label for="exampleInputPassword1">{{ $trans['login_password_label'] }}</label>
				    <a href="{{ route('frontend.forgot') }}" class="float-right" title="{{ $trans['login_forgot_password'] }}">{{ $trans['login_forgot_password'] }}</a>
				    <input type="password" class="form-control" placeholder="{{ $trans['login_password_placeholder'] }}" name="login_password" required>
						<span class="text-danger">{{ $errors->first('login_password') }}</span>
				  </div>
				  <div class="form-group">
				    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember">
				    <label class="form-check-label bold-500" for="exampleCheck1">{{ $trans['login_remember_label'] }}</label>
					</div>
					@if (session('error_confirmation'))
						<span class="text-danger">{{ session('error_confirmation') }}</span>
					@endif
				  <button type="submit" class="btn btn-primary btn-send-about btn-login text-uppercase process_loading">{{ $trans['login_button'] }}</button>
				</form>
			</div>
			<div class="col-md-5 d-block d-md-none mt-4">
				<strong class="mt-5">Login with :</strong>
				<div class="social mt-4">
					<a href="{{ route('frontend.oauth.redirect_to_facebook') }}" title=""><img src="{{ asset('assets/img/facebook.png') }}" alt=""></a>
					<a href="{{ route('frontend.oauth.redirect_to_twitter') }}" title=""><img src="{{ asset('assets/img/twitter.png') }}" alt=""></a>
					<a href="{{ route('frontend.oauth.redirect_to_google') }}" title=""><img src="{{ asset('assets/img/google.png') }}" alt=""></a>
					{{-- <a href="{{ route('frontend.oauth.redirect_to_linkedin') }}" title=""><img src="{{ asset('assets/img/linkedin.png') }}" alt=""></a> --}}
				</div>
			</div>
			<div class="col-md-5 offset-md-2 offset-0">
				<h3 class="mt-5 mb-4 bold-300">{{ $trans['register_title'] }}</h3>
				<form action="{{ route('frontend.register') }}" method="POST">
					{{ csrf_field() }}
				  <div class="form-group form-login">
				    <label for="exampleInputEmail1">{{ $trans['register_email_label'] }}</label>
						<input type="email" class="form-control" placeholder="{{ $trans['register_email_placeholder'] }}" name="register_email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" value="{{ old('register_email') }}" required>
						@if ($errors->has('register_email'))
							<span class="text-danger">{{ $errors->first('register_email') }}</span>
						@endif
				  </div>
				  <div class="form-group form-login">
				    <label for="exampleInputEmail1">{{ $trans['register_fullname_label'] }}</label>
						<input type="text" class="form-control" placeholder="{{ $trans['register_fullname_placeholder'] }}" name="register_name" value="{{ old('register_name') }}">
						@if ($errors->has('register_name'))
							<span class="text-danger">{{ $errors->first('register_name') }}</span>
						@endif
				  </div>
                                  <div class="form-group form-login">
				    <label for="exampleInputEmail1">{{ $trans['register_company_label'] }}</label>
						<input type="text" class="form-control" placeholder="{{ $trans['register_copmany_placeholder'] }}" name="company_name" value="{{ old('company_name') }}">
						@if ($errors->has('company_name'))
							<span class="text-danger">{{ $errors->first('company_name') }}</span>
						@endif
				  </div>
				  <div class="form-group form-login">
				    <label for="exampleInputEmail1">{{ $trans['register_phone_label'] }}</label>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text bg-light">+62</span>
							</div>
							<input type="number" class="form-control phone_number" placeholder="8xxxxxxxxxxx" name="register_phone" value="{{ old('register_phone') }}">
						</div>
						@if ($errors->has('register_phone'))
							<span class="text-danger">{{ $errors->first('register_phone') }}</span>
						@endif
				  </div>
				  <div class="form-group form-login">
						<label for="exampleInputPassword1">{{ $trans['register_password_label'] }}</label>
				    <input type="password" class="form-control" placeholder="{{ $trans['register_password_placeholder'] }}" name="register_password" required>
						@if ($errors->has('register_password'))
							<span class="text-danger">{{ $errors->first('register_password') }}</span>
						@endif
				  </div>
				  <div class="form-group">
				    <input type="checkbox" name="agree" class="form-check-input" id="signup">
				    <label class="form-check-label bold-500" for="signup">{{ $trans['register_agreement_title'] }}
				    	<ul class="line-height12">
					    	<li>{!! $trans['register_aggreement_1'] !!}</li>
					    	<li>{{ $trans['register_aggreement_2'] }}</li>
					    </ul>
						</label>

						@if ($errors->has('agree'))
							<span class="text-danger">{{ $errors->first('agree') }}</span>
						@endif
				  </div>
				  <button type="submit" class="btn btn-primary btn-send-about w-100 mb-5 text-uppercase">{{ $trans['register_button'] }}</button>
				</form>
			</div>
		</div>
                <?php /*
		<div class="row">
			<div class="col-md-5 d-none d-md-block">
				<strong class="mt-5">{{ $trans['login_social_label'] }} :</strong>
				<div class="social mt-4">
					<a href="{{ route('frontend.oauth.redirect_to_facebook') }}" title=""><img src="{{ asset('assets/img/facebook.png') }}" alt=""></a>
					<a href="{{ route('frontend.oauth.redirect_to_twitter') }}" title=""><img src="{{ asset('assets/img/twitter.png') }}" alt=""></a>
					<a href="{{ route('frontend.oauth.redirect_to_google') }}" title=""><img src="{{ asset('assets/img/google.png') }}" alt=""></a>
					{{-- <a href="{{ route('frontend.oauth.redirect_to_linkedin') }}" title=""><img src="{{ asset('assets/img/linkedin.png') }}" alt=""></a> --}}
				</div>
			</div>

			<div class="col-md-5 offset-md-2 offset-0">
				<strong class="mt-5">{{ $trans['register_social_label'] }} :</strong>
				<div class="social text-md-left  mt-4">
					<a href="{{ route('frontend.oauth.redirect_to_facebook') }}" title=""><img src="{{ asset('assets/img/facebook.png') }}" alt=""></a>
					<a href="{{ route('frontend.oauth.redirect_to_twitter') }}" title=""><img src="{{ asset('assets/img/twitter.png') }}" alt=""></a>
					<a href="{{ route('frontend.oauth.redirect_to_google') }}" title=""><img src="{{ asset('assets/img/google.png') }}" alt=""></a>
					{{-- <a href="{{ route('frontend.oauth.redirect_to_linkedin') }}" title=""><img src="{{ asset('assets/img/linkedin.png') }}" alt=""></a> --}}
				</div>
			</div>
		</div>*/ ?>
	</div>
</div>

@endsection

@section('footer')
@include('frontend/includes/footer_scrollspy')
@endsection

@section('custom_js')
<script>
	$(document).ready(function() {
		$('.phone_number').on('input propertychange paste', function (e) {
				var reg = /^0+/gi;
				if (this.value.match(reg)) {
						this.value = this.value.replace(reg, '');
				}
		});
	});
</script>
@endsection
