@extends('crudbooster::admin_template')
@section('content')
<!-- Your html goes here -->
<div class='panel panel-default'>
    <div class='panel-heading'><strong><i class="fa fa-map-signs"></i> {{ $form_type }} Pickup Point Management</strong></div>
    <div class='panel-body' style="padding: 20px 0px 0px 0px;">
        <form method='post' action='{{route('AdminPickupPointsControllerPostSavePickup')}}' enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @if ($edit)
            <input type="hidden" name="id" value="{{ $pickpoint->id }}">
            @endif
            <div class="box-body" id="parent-form-area">

                <div class="form-group header-group-0 " id="form-group-packaging_type" style="">
                    <label class="control-label col-sm-2">Active
                            <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-md-1">
                        <input type="radio" id="on_radiot" name="is_active" {{ $edit ? ($pickpoint->is_active == 1 ? "checked" : '') : 'checked' }} class="is_active" value="1">
                        <label for="on_radiot">Active</label>
                    </div>
                    <div class="col-md-1">
                        <input type="radio" id="off_radiot" name="is_active" {{ $edit ? ($pickpoint->is_active == 0 ? "checked" : '') : '' }} class="is_active" value="0">
                        <label for="off_radiot">Inactive</label>
                    </div>
                </div>
                <div class="form-group header-group-0 " id="form-group-name" style="">
                    <label class="control-label col-sm-2">
                        Name
                        <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-10">
                        <input type="text" title="Name" required="" placeholder="You can only enter the letter only" maxlength="70" class="form-control" name="name" id="name" value="{{  $edit ? $pickpoint->name : old('name') }}">

                        <div class="text-danger"></div>
                        <p class="help-block"></p>

                    </div>
                </div>

                <div class="form-group header-group-0 " id="form-group-province" style="">
                    <label class="control-label col-sm-2">Province
                        <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-10">
                        <select class="form-control" id="province" data-value="6-DKI Jakarta" name="province">
                            <option value="">** Please select a Province</option>
                            <option value="1-Bali" {{ $edit ? ($pickpoint->province_id == 1 ? 'selected' : '') : '' }}>Bali</option>
                            <option value="2-Bangka Belitung" {{ $edit ? ($pickpoint->province_id == 2 ? 'selected' : '') : '' }}>Bangka Belitung</option>
                            <option value="3-Banten" {{ $edit ? ($pickpoint->province_id == 3 ? 'selected' : '') : '' }}>Banten</option>
                            <option value="4-Bengkulu" {{ $edit ? ($pickpoint->province_id == 4 ? 'selected' : '') : '' }}>Bengkulu</option>
                            <option value="5-DI Yogyakarta" {{ $edit ? ($pickpoint->province_id == 5 ? 'selected' : '') : '' }}>DI Yogyakarta</option>
                            <option value="6-DKI Jakarta" {{ $edit ? ($pickpoint->province_id == 6 ? 'selected' : '') : '' }}>DKI Jakarta</option>
                            <option value="7-Gorontalo" {{ $edit ? ($pickpoint->province_id == 7 ? 'selected' : '') : '' }}>Gorontalo</option>
                            <option value="8-Jambi" {{ $edit ? ($pickpoint->province_id == 8 ? 'selected' : '') : '' }}>Jambi</option>
                            <option value="9-Jawa Barat" {{ $edit ? ($pickpoint->province_id == 9 ? 'selected' : '') : '' }}>Jawa Barat</option>
                            <option value="10-Jawa Tengah" {{ $edit ? ($pickpoint->province_id == 10 ? 'selected' : '') : '' }}>Jawa Tengah</option>
                            <option value="11-Jawa Timur" {{ $edit ? ($pickpoint->province_id == 11 ? 'selected' : '') : '' }}>Jawa Timur</option>
                            <option value="12-Kalimantan Barat" {{ $edit ? ($pickpoint->province_id == 12 ? 'selected' : '') : '' }}>Kalimantan Barat</option>
                            <option value="13-Kalimantan Selatan" {{ $edit ? ($pickpoint->province_id == 13 ? 'selected' : '') : '' }}>Kalimantan Selatan</option>
                            <option value="14-Kalimantan Tengah" {{ $edit ? ($pickpoint->province_id == 14 ? 'selected' : '') : '' }}>Kalimantan Tengah</option>
                            <option value="15-Kalimantan Timur" {{ $edit ? ($pickpoint->province_id == 15 ? 'selected' : '') : '' }}>Kalimantan Timur</option>
                            <option value="16-Kalimantan Utara" {{ $edit ? ($pickpoint->province_id == 16 ? 'selected' : '') : '' }}>Kalimantan Utara</option>
                            <option value="17-Kepulauan Riau" {{ $edit ? ($pickpoint->province_id == 17 ? 'selected' : '') : '' }}>Kepulauan Riau</option>
                            <option value="18-Lampung" {{ $edit ? ($pickpoint->province_id == 18 ? 'selected' : '') : '' }}>Lampung</option>
                            <option value="19-Maluku" {{ $edit ? ($pickpoint->province_id == 19 ? 'selected' : '') : '' }}>Maluku</option>
                            <option value="20-Maluku Utara" {{ $edit ? ($pickpoint->province_id == 20 ? 'selected' : '') : '' }}>Maluku Utara</option>
                            <option value="21-Nanggroe Aceh Darussalam (NAD)" {{ $edit ? ($pickpoint->province_id == 21 ? 'selected' : '') : '' }}>Nanggroe Aceh Darussalam (NAD)</option>
                            <option value="22-Nusa Tenggara Barat (NTB)" {{ $edit ? ($pickpoint->province_id == 22 ? 'selected' : '') : '' }}>Nusa Tenggara Barat (NTB)</option>
                            <option value="23-Nusa Tenggara Timur (NTT)" {{ $edit ? ($pickpoint->province_id == 23 ? 'selected' : '') : '' }}>Nusa Tenggara Timur (NTT)</option>
                            <option value="24-Papua" {{ $edit ? ($pickpoint->province_id == 24 ? 'selected' : '') : '' }}>Papua</option>
                            <option value="25-Papua Barat" {{ $edit ? ($pickpoint->province_id == 25 ? 'selected' : '') : '' }}>Papua Barat</option>
                            <option value="26-Riau" {{ $edit ? ($pickpoint->province_id == 26 ? 'selected' : '') : '' }}>Riau</option>
                            <option value="27-Sulawesi Barat" {{ $edit ? ($pickpoint->province_id == 27 ? 'selected' : '') : '' }}>Sulawesi Barat</option>
                            <option value="28-Sulawesi Selatan" {{ $edit ? ($pickpoint->province_id == 28 ? 'selected' : '') : '' }}>Sulawesi Selatan</option>
                            <option value="29-Sulawesi Tengah" {{ $edit ? ($pickpoint->province_id == 29 ? 'selected' : '') : '' }}>Sulawesi Tengah</option>
                            <option value="30-Sulawesi Tenggara" {{ $edit ? ($pickpoint->province_id == 30 ? 'selected' : '') : '' }}>Sulawesi Tenggara</option>
                            <option value="31-Sulawesi Utara" {{ $edit ? ($pickpoint->province_id == 31 ? 'selected' : '') : '' }}>Sulawesi Utara</option>
                            <option value="32-Sumatera Barat" {{ $edit ? ($pickpoint->province_id == 32 ? 'selected' : '') : '' }}>Sumatera Barat</option>
                            <option value="33-Sumatera Selatan" {{ $edit ? ($pickpoint->province_id == 33 ? 'selected' : '') : '' }}>Sumatera Selatan</option>
                            <option value="34-Sumatera Utara" {{ $edit ? ($pickpoint->province_id == 34 ? 'selected' : '') : '' }}>Sumatera Utara</option>
                        </select>
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>

                <div class="form-group header-group-0 " id="form-group-city" style="">
                    <label class="control-label col-sm-2">City
                        <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-10">
                        <select class="form-control" id="city" data-value="" required="" name="city" {{ $edit ? '' : 'disabled' }}>
                            <option value="">** Please select a City</option>
                            @if ($edit)
                                @if($cities)
                                    @foreach ($cities as $key => $city)
                                        <option value="{{ $city['value']}}" {{ $pickpoint->city == $city['name']  ? 'selected' : '' }}>{{ $city['name'] }}</option>
                                    @endforeach
                                @endif
                            @endif
                        </select>
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>

                <div class="form-group header-group-0 " id="form-group-subdistrict" style="">
                    <label class="control-label col-sm-2">Subdistrict
                        <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-10">
                        <select class="form-control" id="subdistrict" data-value="" required="" name="subdistrict"  {{ $edit ? '' : 'disabled' }}>
                            <option value="">** Please select a Subdistrict</option>
                            @if ($edit)
                                @if($subdistricts)
                                    @foreach ($subdistricts as $key => $subdistrict)
                                        <option value="{{ $subdistrict['value']}}" {{ $pickpoint->subdistrict == $subdistrict['name']  ? 'selected' : '' }}>{{ $subdistrict['name'] }}</option>
                                    @endforeach
                                @endif
                            @endif
                        </select>
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>

                <div class="form-group header-group-0 " id="form-group-address" style="">
                    <label class="control-label col-sm-2">Address
                        <span class="text-danger" title="This field is required">*</span>
                    </label>
                    <div class="col-sm-10">
                        <textarea name="address" id="address" required="" maxlength="5000" class="form-control" rows="5">{{ $edit ? $pickpoint->address : old('address') }}</textarea>
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group header-group-0 " id="form-group-postal_code" style="">
                    <label class="control-label col-sm-2">Postal Code
                        {{-- <span class="text-danger" title="This field is required">*</span> --}}
                    </label>

                    <div class="col-sm-3">
                        <input type="number" step="1" title="Postal Code" class="form-control" name="postal_code" id="postal_code" value="{{ $edit ? $pickpoint->postal_code : old('postal_code') }}">
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group header-group-0 " id="form-group-postal_code" style="">
                    <label class="control-label col-sm-2">Contact Person Name
                        {{-- <span class="text-danger" title="This field is required">*</span> --}}
                    </label>

                    <div class="col-sm-3">
                        <input type="text" step="1" title="contact_person" class="form-control" name="contact_person" id="contact_person" value="{{ $edit ? $pickpoint->contact_person : old('contact_person') }}">
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group header-group-0 " id="form-group-postal_code" style="">
                    <label class="control-label col-sm-2">Contact Person Phone
                        <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-3">
                        <input type="text" step="1" title="contact_phone" class="form-control" name="contact_phone" id="contact_phone" value="{{ $edit ? $pickpoint->contact_phone : old('contact_phone') }}">
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group header-group-0 " id="form-group-postal_code" style="">
                    <label class="control-label col-sm-2">Contact Person Email
                        <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-3">
                        <input type="text" step="1" title="contact_email" class="form-control" name="contact_email" id="contact_email" value="{{ $edit ? $pickpoint->contact_email : old('contact_email') }}">
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group header-group-0 " id="form-group-latitude" style="">
                    <label class="control-label col-sm-2">Latitude
                        <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-3">
                        <input type="text" step="1" title="latitude Code" required="" class="form-control" name="latitude" id="latitude" value="{{ $edit ? $pickpoint->latitude : old('latitude') }}">
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group header-group-0 " id="form-group-longitude" style="">
                    <label class="control-label col-sm-2">Longitude
                        <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-3">
                        <input type="text" step="1" title="longitude Code" required="" class="form-control" name="longitude" id="longitude" value="{{ $edit ? $pickpoint->longitude : old('longitude') }}">
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer" style="background: #F5F5F5">

                <div class="form-group">
                    <label class="control-label col-sm-2"></label>
                    <div class="col-sm-10">
                        <a href="{{ url('admin/pickup_points') }}" class="btn btn-default"><i class="fa fa-chevron-circle-left"></i> Back</a>

                        <input type="submit" name="submit" value="Save" class="btn btn-success">

                    </div>
                </div>

            </div>
            <!-- /.box-footer-->

        </form>
    </div>
</div>
@endsection

@push('head')
<link rel='stylesheet' href='{{ asset("vendor/crudbooster/assets/select2/dist/css/select2.min.css") }}'/>
<style>
</style>
@endpush
@push('bottom')
<script type="text/javascript" src="{{asset('vendor/crudbooster/assets/select2/dist/js/select2.full.min.js')}}"></script>

<script type="text/javascript">
$(document).ready(function () {
    var cityWrap            = $('#city');
    var subdistrictWrap     = $('#subdistrict');
    var myToken             = $('input[name=\"_token\"]').val();

    @if($edit)
    $('#city').select2();
    $('#subdistrict').select2();
    @endif

    $('#province').on('change', function (e) {
        var initProvince = $('#province').val().split('-');
        $('#city').attr('disabled', true);
        cityWrap.empty();
        cityWrap.append('<option selected>Loading...</option>');

        $.ajax({
            type: 'GET',
            url: "{{ route('AdminPickupPointsControllerGetCity') }}",
            data:
            {
                '_token' : myToken,
                'prov' : initProvince[0],
            },
            success: function (respond) {
                $('#city').attr('disabled', false);
                cityWrap.empty();
                var cities = respond.cities.city;
                for (var i = 0; i < cities.length; i++) {
                    cityWrap.append('<option value=\"' + cities[i].value + '\">' + cities[i].name + '</option>');
                }

                cityWrap.select2();
            }
        });
    });

    $('#city').on('change', function (e) {
        var initCity = $('#city').val().split('-');
        $('#subdistrict').attr('disabled', true);
        subdistrictWrap.empty();
        subdistrictWrap.append('<option selected>Loading...</option>');

        $.ajax({
            type: 'GET',
            url: "{{ route('AdminPickupPointsControllerGetSubdistrict') }}",
            data:
            {
                '_token' : myToken,
                'city' : initCity[0],
            },
            success: function (respond) {
                $('#subdistrict').attr('disabled', false);
                subdistrictWrap.empty();
                var subdistrict = respond.subdistrict.subdistrict;
                for (var i = 0; i < subdistrict.length; i++) {
                    subdistrictWrap.append('<option value=\"' + subdistrict[i].value + '\">' + subdistrict[i].name + '</option>');
                }

                subdistrictWrap.select2();
            }
        });
    });

    $('#province').select2();
});
</script>
@endpush
