@extends('crudbooster::admin_template')
@section('content')
  <!-- Your html goes here -->
  <div class='panel panel-default'>
    <div class='panel-heading'></div>
    <div class='panel-body'>

        <div class="card product_item_list">
            <div class="body">
                <a href="{{ route('AdminGeneralSettingControllerGetResetCache') }}" class="btn btn-info pull-right"><i class="fa fa-refresh"></i> Refresh Cache</a>
                <ul class="nav nav-tabs">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a class="nav-link" data-toggle="tab" href="#config">System Config</a>
                    </li>
                    <li>
                        <a class="nav-link" data-toggle="tab" href="#contact">Contact Details</a>
                    </li>
                    <li>
                        <a class="nav-link" data-toggle="tab" href="#referral">Referral Setting</a>
                    </li>
                    <li>
                        <a class="nav-link" data-toggle="tab" href="#SEO">SEO Setting</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="config" role="tabpanel" class="tab-pane in active">
                        <form method="post" action="{{ route('AdminGeneralSettingControllerPostSave') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="_tab" value="config" />
                            <br />
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Maintenance Mode</b><br>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="radio" id="on_radiot" name="maintenance_mode" {{ $setting['maintenance_mode'] == 1 ? "checked" : '' }} class="maintenance_check" value="1">
                                            <label for="on_radiot">On</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" id="off_radiot" name="maintenance_mode" {{ $setting['maintenance_mode'] == 0 ? "checked" : '' }} class="maintenance_check" value="0">
                                            <label for="off_radiot">Off</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-20">
                                <div class="col-md-6">
                                    <b>Contact Email</b>
                                    <div class="input-group"> <span class="input-group-addon"> <i class="fa fa-envelope"></i> </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" value="{{ $setting['admin_email'] }}" name="admin_email" id="admin-email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <b>Whitelist IP</b>
                                    <div class="input-group"> <span class="input-group-addon"> <i class="fa fa-desktop"></i> </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" value="{{ $setting['whitelist_ip'] }}" name="whitelist_ip" id="text-whitelist">
                                        </div>
                                    </div>
                                    <small id="emailHelp" class="form-text text-muted">* For multiple ip, use comma(,)</small>
                                </div>
                            </div>
                            <div class="row mt-20">
                                <div class="col-md-6">
                                    <b>BCC Email System</b>
                                    <div class="input-group"> <span class="input-group-addon"> <i class="fa fa-envelope"></i> </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" value="{{ $setting['bcc_email_system'] }}" name="bcc_email_system" id="bcc_email_system">
                                        </div>
                                    </div>
                                    <small id="emailHelp" class="form-text text-muted">* For multiple email, use comma(,)</small><br>
                                    <small id="emailHelp" class="form-text text-muted">* these emails will receive email for every order, contact message, etc</small>
                                </div>

                                <div class="col-md-6">
                                    <b>Google Analytic ID</b>
                                    <div class="input-group"> <span class="input-group-addon"> <i class="fa fa-google"></i> </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" value="{{ $setting['ga_id'] }}" name="ga_id" id="ga_id">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="text-maintenance">Maintenance Text</label>
                                        <textarea name="maintenance_text" class="form-control summernote_text" id="text-maintenance">{{ $setting['maintenance_text'] }}</textarea>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="text-maintenance">Error 404 Text</label>
                                        <textarea name="text_404" class="form-control summernote_text" id="text-404">{{ $setting['text_404'] }}</textarea>
                                    </div>
                                </div> --}}

                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                    {{-- <div id="checkout" class="tab-pane">
                        <form method="post" action="">
                            <input type="hidden" name="_token" value="{{csrf_token()}}" />
                            <input type="hidden" name="_tab" value="checkout" />
                            <br />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="transfer_checkout_text">Transfer Payment Message</label>
                                        <textarea name="transfer_checkout_text" class="form-control" id="transfer_checkout_text">{{ $setting['transfer_checkout_text'] }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="midtrans_checkout_text">Midtrans Payment Message</label>
                                        <textarea name="midtrans_checkout_text" class="form-control" id="midtrans_checkout_text">{{ $setting['midtrans_checkout_text'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div> --}}
                    <div id="contact" class="tab-pane fade in">
                        <form method="post" action="{{ route('AdminGeneralSettingControllerPostSave') }}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="_tab" value="contact" />
                            <br />
                            <div class="form-group">
                                <img src="{{ asset($setting['company_logo_header']) }}" style="max-width:200px;" alt="">
                            </div>
                            <div class="form-group">
                                @if ($setting['company_logo_header'])
                                @endif
                                <label for="company_phone">Logo Light</label>
                                <input type='file' name="company_logo_header" class="form-control" id="company_logo_header" value="{{ $setting['company_logo_header'] }}" accept="*/images" />
                                <small id="emailHelp" class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <img src="{{ asset($setting['company_logo_footer']) }}" style="max-width:200px;" alt="">
                            </div>
                            <div class="form-group">
                                @if ($setting['company_logo_footer'])
                                @endif
                                <label for="company_phone">Logo Dark</label>
                                <input type='file' name="company_logo_footer" class="form-control" id="company_logo_footer" value="{{ $setting['company_logo_footer'] }}" accept="*/images" />
                                <small id="emailHelp" class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label for="company_phone">Phone</label>
                                <input name="company_phone" class="form-control" id="company_phone" value="{{ $setting['company_phone'] }}" />
                                <small id="emailHelp" class="form-text text-muted">* example: 81212345678</small>
                            </div>
                            {{-- <div class="form-group">
                                <label for="company_whatsapp">Whatsapp</label>
                                <input name="company_whatsapp" class="form-control" id="company_whatsapp" value="{{ $setting['company_whatsapp'] }}" />
                                <small id="emailHelp" class="form-text text-muted">* example: 81212345678</small>
                            </div> --}}
                            {{-- <div class="form-group">
                                <label for="address">Whatsapp Text</label>
                                <textarea name="whatsapp_text" class="form-control">{{ $setting['whatsapp_text'] }}</textarea>
                            </div> --}}
                            <div class="form-group">
                                <label for="company_facebook">Facebook</label>
                                <input name="company_facebook" class="form-control" id="company_facebook" value="{{ $setting['company_facebook'] }}" />
                                <small id="emailHelp" class="form-text text-muted">* Please insert full url. example: https://www.facebook.com/google</small>
                            </div>
                            <div class="form-group">
                                <label for="company_instagram">Instagram</label>
                                <input name="company_instagram" class="form-control" id="company_instagram" value="{{ $setting['company_instagram'] }}" />
                                <small id="emailHelp" class="form-text text-muted">* Please insert full url. example: https://www.instagram.com/google</small>
                            </div>
                            <div class="form-group">
                                <label for="company_tiktok">Tiktok</label>
                                <input name="company_tiktok" class="form-control" id="company_tiktok" value="{{ $setting['company_tiktok'] }}" />
                                <small id="emailHelp" class="form-text text-muted">* Please insert full url.</small>
                            </div>
							<div class="form-group">
                                <label for="company_youtube">Youtube</label>
                                <input name="company_youtube" class="form-control" id="company_youtube" value="{{ $setting['company_youtube'] }}" />
                                <small id="emailHelp" class="form-text text-muted">* Please insert full url.</small>
                            </div>
							<div class="form-group">
                                <label for="company_linkedin">Linkedin</label>
                                <input name="company_linkedin" class="form-control" id="company_linkedin" value="{{ $setting['company_linkedin'] }}" />
                                <small id="emailHelp" class="form-text text-muted">* Please insert full url.</small>
                            </div>
                            {{-- <div class="form-group">
                                <label for="company_twitter">Twitter</label>
                                <input name="company_twitter" class="form-control" id="company_twitter" value="{{ $setting['company_twitter'] }}" />
                                <small id="emailHelp" class="form-text text-muted">* Please insert full url. example: https://www.twitter.com/google</small>
                            </div> --}}
                            <div class="form-group">
                                <label for="company_footer_text">Footer Text</label>
                                <input name="company_footer_text" class="form-control" id="company_footer_text" value="{{ $setting['company_footer_text'] }}" />
                                {{-- <small id="emailHelp" class="form-text text-muted">* Please insert full url. example: https://www.twitter.com/google</small> --}}
                            </div>
                            {{-- <div class="form-group">
                                <label for="email">Email</label>
                                <input name="email" class="form-control" id="email" value="{{ $setting['company_email'] }}">
                            </div> --}}
                            {{-- <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" class="form-control" id="address" name="address">{{ $setting['company_address'] }}</textarea>
                            </div> --}}

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                    <div id="referral" class="tab-pane fade in">
                        <form method="post" action="{{ route('AdminGeneralSettingControllerPostSave') }}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="_tab" value="contact" />
                            <br />
                            <div class="form-group">
                                <label for="referral_share_twitter">Share to Twitter Text</label>
                                <input name="referral_share_twitter" class="form-control" id="referral_share_twitter" value="{{ $setting['referral_share_twitter'] }}" />
                                {{-- <small id="emailHelp" class="form-text text-muted">* Please insert full url. example: https://www.facebook.com/google</small> --}}
                            </div>
                            <div class="form-group">
                                <label for="referral_share_linkedin">Share to LinkedIn Text</label>
                                <input name="referral_share_linkedin" class="form-control" id="referral_share_linkedin" value="{{ $setting['referral_share_linkedin'] }}" />
                                {{-- <small id="emailHelp" class="form-text text-muted">* Please insert full url. example: https://www.instagram.com/google</small> --}}
                            </div>

                            <div class="form-group">
                                <button type="submiReferralt" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                    <div id="SEO" class="tab-pane fade in">
                        <form method="post" action="{{ route('AdminGeneralSettingControllerPostSave') }}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="_tab" value="contact" />
                            <br />

                            <div class="form-group">
                                <img src="{{ asset($setting['favicon']) }}" style="max-width:200px;" alt="">
                            </div>
                            <div class="form-group">
                                @if ($setting['favicon'])
                                @endif
                                <label for="favicon">Favicon</label>
                                <input type='file' name="favicon" class="form-control" id="favicon" value="{{ $setting['favicon'] }}"  accept="image/*" />
                                <small id="emailHelp" class="form-text text-muted"></small>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="default_description">Default Description</label>
                                <input name="default_description" class="form-control" id="default_description" value="{{ $setting['default_description'] }}" />
                            </div>
                            <div class="form-group">
                                <label for="default_keywords">Default Keywords</label>
                                <input name="default_keywords" class="form-control" id="default_keywords" value="{{ $setting['default_keywords'] }}" />
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="home_title">Home Title</label>
                                <input name="home_title" class="form-control" id="home_title" value="{{ $setting['home_title'] }}" />
                            </div>
                            <div class="form-group">
                                <label for="home_meta_title">Home Meta Title</label>
                                <input name="home_meta_title" class="form-control" id="home_meta_title" value="{{ $setting['home_meta_title'] }}" />
                            </div>
                            <div class="form-group">
                                <label for="home_description">Home Description</label>
                                <input name="home_description" class="form-control" id="home_description" value="{{ $setting['home_description'] }}" />
                            </div>
                            <div class="form-group">
                                <label for="home_keywords">Home Keywords</label>
                                <input name="home_keywords" class="form-control" id="home_keywords" value="{{ $setting['home_keywords'] }}" />
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="about_title">About Us Title</label>
                                <input name="about_title" class="form-control" id="about_title" value="{{ $setting['about_title'] }}" />
                            </div>
                            <div class="form-group">
                                <label for="about_meta_title">About Us Meta Title</label>
                                <input name="about_meta_title" class="form-control" id="about_meta_title" value="{{ $setting['about_meta_title'] }}" />
                            </div>
                            <div class="form-group">
                                <label for="about_description">About Us Description</label>
                                <input name="about_description" class="form-control" id="about_description" value="{{ $setting['about_description'] }}" />
                            </div>
                            <div class="form-group">
                                <label for="about_keywords">About Us Keywords</label>
                                <input name="about_keywords" class="form-control" id="about_keywords" value="{{ $setting['about_keywords'] }}" />
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="product_title">Product Title</label>
                                <input name="product_title" class="form-control" id="product_title" value="{{ $setting['product_title'] }}" />
                            </div>
                            <div class="form-group">
                                <label for="product_meta_title">Product Meta Title</label>
                                <input name="product_meta_title" class="form-control" id="product_meta_title" value="{{ $setting['product_meta_title'] }}" />
                            </div>
                            <div class="form-group">
                                <label for="product_description">Product Description</label>
                                <input name="product_description" class="form-control" id="product_description" value="{{ $setting['product_description'] }}" />
                            </div>
                            <div class="form-group">
                                <label for="product_keywords">Product Keywords</label>
                                <input name="product_keywords" class="form-control" id="product_keywords" value="{{ $setting['product_keywords'] }}" />
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="origin_title">Origin Title</label>
                                <input name="origin_title" class="form-control" id="origin_title" value="{{ $setting['origin_title'] }}" />
                            </div>
                            <div class="form-group">
                                <label for="origin_meta_title">Origin Meta Title</label>
                                <input name="origin_meta_title" class="form-control" id="origin_meta_title" value="{{ $setting['origin_meta_title'] }}" />
                            </div>
                            <div class="form-group">
                                <label for="origin_description">Origin Description</label>
                                <input name="origin_description" class="form-control" id="origin_description" value="{{ $setting['origin_description'] }}" />
                            </div>
                            <div class="form-group">
                                <label for="origin_keywords">Origin Keywords</label>
                                <input name="origin_keywords" class="form-control" id="origin_keywords" value="{{ $setting['origin_keywords'] }}" />
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="experience_title">Experience Title</label>
                                <input name="experience_title" class="form-control" id="experience_title" value="{{ $setting['experience_title'] }}" />
                            </div>
                            <div class="form-group">
                                <label for="experience_meta_title">Experience Meta Title</label>
                                <input name="experience_meta_title" class="form-control" id="experience_meta_title" value="{{ $setting['experience_meta_title'] }}" />
                            </div>
                            <div class="form-group">
                                <label for="experience_description">Experience Description</label>
                                <input name="experience_description" class="form-control" id="experience_description" value="{{ $setting['experience_description'] }}" />
                            </div>
                            <div class="form-group">
                                <label for="experience_keywords">Experience Keywords</label>
                                <input name="experience_keywords" class="form-control" id="experience_keywords" value="{{ $setting['experience_keywords'] }}" />
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="purchase_title">Purchase Title</label>
                                <input name="purchase_title" class="form-control" id="purchase_title" value="{{ $setting['purchase_title'] }}" />
                            </div>
                            <div class="form-group">
                                <label for="purchase_meta_title">Purchase Meta Title</label>
                                <input name="purchase_meta_title" class="form-control" id="purchase_meta_title" value="{{ $setting['purchase_meta_title'] }}" />
                            </div>
                            <div class="form-group">
                                <label for="purchase_description">Purchase Description</label>
                                <input name="purchase_description" class="form-control" id="purchase_description" value="{{ $setting['purchase_description'] }}" />
                            </div>
                            <div class="form-group">
                                <label for="purchase_keywords">Purchase Keywords</label>
                                <input name="purchase_keywords" class="form-control" id="purchase_keywords" value="{{ $setting['purchase_keywords'] }}" />
                            </div>

                            <div class="form-group">
                                <button type="submiReferralt" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class='panel-footer'>
    </div>
  </div>
@endsection

@push('head')
<link rel="stylesheet" type="text/css" href="{{asset('vendor/crudbooster/assets/summernote/summernote.css')}}">
<style>
.nav-tabs li.active {
    border: 1px solid #EEF;
}

.mt-20 {
    margin-top: 20px;
}
</style>
@endpush

@push('bottom')
<script type="text/javascript" src="{{asset('vendor/crudbooster/assets/summernote/summernote.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('.summernote_text').summernote({
        height: 300,
        callbacks: {
            onImageUpload: function (image) {
                uploadImage{{$name}}(image[0]);
            }
        }
    });
});
</script>
@endpush
