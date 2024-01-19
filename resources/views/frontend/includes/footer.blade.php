<div class="section fp-auto-height fp-footer">
    <footer class="fp-auto-height section footer-classic context-dark footer-tropical">
        <div class="box-footer">
            <div class="container container-product mb-md-5 mb-2">
            <div class="row row-30">
                <div class="col-md-3 pb-md-0 mt-5 hidden-992">
                    <img src="{{ asset($company_logo_footer) }}" class="img-logo" alt="">
                </div>
                <div class="col-lg-9 col-md-12 mt-5 p-auto p-md-0">
                    <div class="row mb-md-5 mb-2 mt-2">
                        <div class="col-md col-sm-6 col-6">
                            <h5 class="mb-3 hidden-992">Information</h5>
                            <ul class="list-unstyled">
                                @foreach ($footerNav as $navInfo)
                                    @if ($navInfo->type == 'information')
                                    <li><a href="{{ url($navInfo->url) }}" title="{{ $navInfo->name }}">{{ $navInfo->name }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>

                        <div class="col-md col-sm-6 col-6">
                            <h5 class="mb-3 hidden-992">{{ $trans['footer_guide_title'] }}</h5>
                            <ul class="list-unstyled">
                                @foreach ($footerNav as $navInfo)
                                    @if ($navInfo->type == 'guide')
                                    <li><a href="{{ url($navInfo->url) }}" title="{{ $navInfo->name }}">{{ $navInfo->name }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>

                        <div class="col-md-5 col-sm-12 col-12">
                            <h5 class="mb-md-3 mb-1">{{ $trans['footer_newsletter_title'] }}</h5>
                            <p class="mb-md-3 mb-1">{{ $trans['footer_newsletter_content'] }}</p>

                            <form action="{{ route('frontend.newsletter.add') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="input-group mb-md-3 mb-1">
                                    <input type="email" class="form-control" placeholder="{{ $trans['footer_newsletter_placeholder'] }}" aria-label="subsriber email input" name="email">
                                    <div class="input-group-append">
                                        <button class="btn btn-subscribe" type="submit" id="button-addon2">{{ $trans['footer_newsletter_button'] }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col-md col-sm-6 col-12">
                            <h5 class="mb-md-3 mb-2">{{ $trans['footer_payment_title'] }}</h5>
                            <div class="icon-area">
                                @foreach ($footerPayment as $fp)
                                <img src="{{ asset($fp->url) }}" alt="">
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md  col-sm-6 col-12">
                            <h5 class="mb-md-3 mb-2">{{ $trans['footer_shipping_title'] }}</h5>
                            <div class="icon-area">
                                @foreach ($footerShipping as $fs)
                                <img src="{{ asset($fs->url) }}" alt="">
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-5 col-sm-12 col-12 mt-md-0 mt-0">
                            <h5 class="mb-md-3 mb-1">{{ $trans['footer_social_title'] }}</h5>
                            <p class="mb-md-2 mb-1">{{ $trans['footer_social_description'] }}</p>

                            <div class="socmed-area">
                                @if ($company_youtube)
                                <a href="{{ $company_youtube }}" target="_blank">
                                    <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-youtube-play fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                                @endif
                                @if ($company_facebook)
                                <a href="{{ $company_facebook }}" target="_blank">
                                    <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                                @endif
                                @if ($company_instagram)
                                <a href="{{ $company_instagram }}" target="_blank">
                                    <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                                @endif
                                @if ($company_linkedin)
				<a href="{{ $company_linkedin }}" target="_blank">
				    <span class="fa-stack fa-lg">
				    <i class="fa fa-circle fa-stack-2x"></i>
				    <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
				    </span>
				</a>
				@endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            </div>


            <div class="container container-product">
                <div class="row mb-4">
                    <div class="col-md-3 col-sm-6 col-6">
                        <a href="mailto:{{ $admin_email }}" class="fot_font_size">
							<span class="fa-stack fa-lg">
							<i class="fa fa-circle fa-stack-2x"></i>
							<i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
							</span>
							{{ $admin_email }}
						</a>
                    </div>
                    <div class="col-md-3 col-sm-6 col-6 ">
                        <a href="tel:{{ $company_phone }}" class="fot_font_size">
							<span class="fa-stack fa-lg">
							<i class="fa fa-circle fa-stack-2x"></i>
							<i class="fa fa-whatsapp fa-stack-1x fa-inverse"></i>
							</span>
							{{ $company_phone }}
						</a>
                    </div>
                    <div class="col-md-3 col-sm-6 col-6 fot_font_size">
                        <strong>{{ $trans['footer_service_label'] }}</strong> {{ $company_footer_text }}
                    </div>
                    <div class="col-md-3 col-sm-6 col-6">
                        <p class="text-right-md text-left fot_font_size">&copy;{{ date('Y') }} The Tropical SPA. {{ $trans['footer_copyright_label'] }}</p>
                    </div>

                    {{-- <div class="col-lg-9 col-md-12 p-auto p-md-0">
                        <div class="row">
                            <div class="col-md col-sm-6 col-6 hidden-992">
                                <strong>{{ $trans['footer_phone_label'] }}</strong> <a href="tel:{{ $company_phone }}">{{ $company_phone }}</a>
                            </div>
                            <div class="col-md col-sm-6 col-6">
                                <strong>{{ $trans['footer_service_label'] }}</strong> {{ $company_footer_text }}
                            </div>
                            <div class="col-md-5 col-sm-12 col-12">
                                <p class="text-right-md text-left">&copy;{{ date('Y') }} The Tropical SPA. {{ $trans['footer_copyright_label'] }}</p>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </footer>
    </div>
</div>
