@extends('frontend/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="content-area">
	<div class="container container-product">
		<div class="row">
            <div class="col-md-9 col-sm-12 col-12 offset-md-3 offset-0 pt-3">
				<h3 class="bold-300 mb-4 pt-5">Referral</h3>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-6">
				@include('frontend/pages/account/includes/sidemenu')
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-6 pr-mb-5 pr-3">
                        <div class="border-top-mb pt-mb-0 pt-3">
                            <form action="{{ route('frontend.user.referral.send') }}" method="POST">
                                {{ csrf_field() }}
                                <p class="bold-700 mb-2">{{ $content->{'title_' . $language} }}</p>
                                <div class="desc-talasi-point">
                                    {!! $content->{'content_' . $language} !!}
                                </div>
                                <input type="text" class="form-control label-14 rounded-0 mb-4" placeholder="Input email here and use comma for multiple email" name="email" value="{{ old('email') }}" required/>
                                <input type="hidden" name="recaptcha" class="recaptchaResponse">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-pink btn-oval btn-addcart-popup mb-5 w-md-100">SEND INVITATION</button>
                                </div>
                            </form>
                        </div>
                        <div class="row d-flex justify-content-start  mb-md-5 mb-3">
                            <div class="desc-talasi-point col-md-5 mb-md-0 mb-3">Atau undang via media sosial:</div>
                            <div class="col-md-7 d-flex align-items-center">
                                <ul class="sosmed-referral w-100 pl-0 mb-0 d-flex justify-content-start ">
                                    <li><a href="{{ shareFacebook(route('frontend.home', ['ref' => \Auth::user()->referralCode()])) }}"><img src="{{asset('assets/img/facebook.png')}}" alt="" target="_blank"></a></li>
                                    <li><a href="{{ shareTwitter(route('frontend.home', ['ref' => \Auth::user()->referralCode()]), $referral_share_twitter) }}" target="_blank"><img src="{{asset('assets/img/twitter.png')}}" alt=""></a></li>
                                    {{-- <li><a href="{{ shareGplus(route('frontend.register', ['ref' => \Auth::user()->referralCode()])) }}"><img src="{{asset('assets/img/google.png')}}" alt=""></a></li> --}}
                                    <li><a href="{{ shareLinkedIn(route('frontend.home', ['ref' => \Auth::user()->referralCode()]), $referral_share_linkedin) }}" target="_blank"><img src="{{asset('assets/img/linkedin.png')}}" alt=""></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="desc-talasi-point border-bottom-mb mb-md-0 mb-3">
                            {!! $json->{'referral_note_' . $language} !!}
                        </div>
                    </div>
                    <div class="col-md-6 pl-mb-5 pl-3">
                        @if (! \Auth::user()->referrer->upline->name)
                            <form action="{{ route('frontend.user.referral.add') }}" method="POST">
                                {{ csrf_field() }}
                                <p class="bold-700 mb-2">{{ $json->{'share_title_' . $language} }}</p>
                                <div class="desc-talasi-point">
                                    {!! $json->{'share_content_' . $language} !!}
                                </div>
                                <input type="text" class="form-control label-14 rounded-0 mb-4" placeholder="Input referral code" name="referral" value="{{ session()->has('referral_code') ? session()->get('referral_code') : '' }}" required/>
                                <input type="hidden" name="recaptcha" class="recaptchaResponse">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" data-toggle="modal" data-target="#modal_codesuccess" class="btn btn-pink btn-oval btn-addcart-popup w-md-100">SUBMIT REFERRAL CODE</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if ($notification)
    @include('frontend/pages/account/includes/modal_codesuccess')
@endif
@endsection

@section('footer')
@include('frontend/includes/footer')
@endsection

@section('custom_js')
<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHAV3_SITEKEY') }}"></script>
<script>
grecaptcha.ready(function() {
    grecaptcha.execute('{{ env('RECAPTCHAV3_SITEKEY') }}', {action: 'referral_send'}).then(function(token) {
        var recaptchaResponse = $('.recaptchaResponse');

        recaptchaResponse.each(function() {
            $(this).val(token);
        });
    });
});

@if ($notification)
$(document).ready(function() {
    // checkPopup();
	 $(window).on('load',function(){
        $('#modal_codesuccess').modal('show');
    });
});
@endif
</script>

@endsection
