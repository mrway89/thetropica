@extends('frontend/layouts/main')

@section('content')

<div class="content-area">
	<div class="container container-product">
		<div class="row">
            <div class="col-md-9 col-sm-12 col-12 offset-md-3 offset-0 pt-3">
                <h3 class="bold-300 mb-4 pt-md-5 pt-0">My Account</h3>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-6">
				@include('frontend/pages/account/includes/sidemenu')
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12">
                <p class="bold-700 mb-4">My Address Book</p>
                <div class="w-100 float-left border-bottom mb-3">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                            <label class="container-checkmark">
                                <div class="label-14"><span class="">Select all</span><span> | </span><span class="cl-black"><a href="" class="btn_remove_address">Delete</a></span></div>
                                <input type="checkbox" value="" class="cekall" onchange="checkAll(this)" name="address_list[]">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                            <div class="label-14 float-md-right float-left">
                                {{-- <span class=""><a href="#" data-toggle="modal" data-target="#changeAddress">Change main address</a></span>
                                <span class="cl-blue"> | </span> --}}
                                <span><a href="#" data-toggle="modal" data-target="#addAddress">Add Address +</a></span>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="w-100 float-left">
                    @foreach ($addresses as $address)
                        <div class="w-100 float-left mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="container-checkmark">
                                        <div class="float-left label-14">
                                            <div class="w-100 float-left mb-2">
                                                <span class="float-left"><b>{{ ucwords($address->name) }} </b> ({{ ucwords($address->label) }}) </span>
                                                @if ($address->is_default == 1)
                                                <span class="label-addr btn-oval ml-md-2 ml-0 btn-pink float-left"> MAIN ADDRESS</span>
                                                @endif
                                            </div>
                                            <div class="w-100 float-left">
                                                <span>+62 {{ $address->phone_number }}</span><br/>
                                                <span>{{ $address->address }}</span><br/>
                                                <span>{{ $address->city }}, {{ $address->province }}, {{ $address->postal_code }}</span><br/>
                                                <span><a href="#" onclick="editAddress({{ $address->id }})">Edit address</a></span>
                                                <span class="cl-blue"> | </span><span><a href="#" class="edit_pinpoint_each" data-id="{{ $address->id }}" data-lat="{{ $address->lat }}" data-long="{{ $address->long }}" data-state="{{ $address->city }}">Edit pinpoint</a></span>
                                            </div>
                                        </div>
                                        <input type="checkbox" value="" onclick="uncheckAll()" name="address_list" class="check_address" data-rand="{{ $address->id }}">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                @if ($address->is_default !== 1)
                                <div class="col-md-6">
                                    <span class="label-14 float-right md-mt-5 mt-3"><a href="" onclick="setAsDefault({{ $address->id }})">Set as main address</a></span>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
				</div>
			</div>
		</div>
	</div>
</div>
@include('frontend/pages/account/includes/accaddaddress')
@include('frontend/pages/account/includes/editaddress')
@include('frontend/pages/account/includes/changeaddress')
@include('frontend/pages/account/includes/editpinpoint')
@endsection

@section('footer')
@include('frontend/includes/footer')
@endsection

@section('custom_js')
<script src="{{ asset('assets/js/check_all.js') }}"></script>
<script src="https://cdn.jsdelivr.net/select2/3.4.8/select2.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.8.1/parsley.min.js"></script>
<script>

function editAddress(id)
{
    $.ajax({
        url: "{{ route('frontend.checkout.address.edit') }}",
        data:
        {
            "addressId": id,
            "_token": "{{ csrf_token() }}"
        },
        type: 'POST',
        dataType: 'json',
        success: function (data, textStatus, jqXHR)
        {
            $('#changeAddress').modal('hide');
            $('#editAddress').modal('show');

            var cityVal = data.address.city + ', ' + data.address.province;

            $("#edit_address_id").val(data.address.id);
            $("#edit_address_label").val(data.address.label);
            $("#edit_address_name").val(data.address.name);
            $("#edit_address_postal").val(data.address.postal_code);
            $("#edit_address_phone").val(data.address.phone_number);
            $("#edit_address_address").val(data.address.address);
            $("#edit_latitude").val(data.address.lat);
            $("#edit_longitude").val(data.address.long);
            $('#edit_address_state').val(cityVal);
            if (data.is_default == 1) {
                $("#address_is_default").attr('disabled', true);
                $("#address_is_default").attr('checked', true);
            } else {
                $("#address_is_default").attr('checked', false);
                $("#address_is_default").attr('disabled', false);
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal('error', 'error', 'error');
        },
    });
};

function setAsDefault(id){
    $.ajax({
        url: "{{ route('frontend.user.address.set_default') }}",
        data:
        {
            "id": id,
            "_token" : "{{ csrf_token() }}"
        },
        type: 'POST',
        dataType: 'json',
        success: function (respond)
        {
            if (respond.status) {
                location.reload();
            }
        },
    });
}


$(document).ready(function(){
    $('#city-state').select2({
        closeOnSelect: true,
        minimumInputLength: 3,

        ajax: {
            url: "{{ route('frontend.rajaongkir.get_city') }}",
            dataType: 'json',
            // delay: 250,
            data: function (params) {
                return {
                    query: params,
                };
            },
            results: function (data) {
                    var myResults = [];
                    $.each(data.cities, function (index, item) {
                            myResults.push({
                                    'id': item.raja_ongkir_id + '-' + item.city_name + ',' + item.province.raja_ongkir_id + '-' + item.province.name,
                                    'text': item.city_name + ' (' + item.city_type + '), ' + item.province.name
                            });
                    });
                    return {
                            results: myResults
                    };
            },
            cache: true
        }
    });

    $('body').on('click', '#edit_address_state', function(e){
        $('#edit_address_state').select2({
                closeOnSelect: true,
                minimumInputLength: 3,
            placeholder: "Choose City / State",

                ajax: {
                    url: "{{ route('frontend.rajaongkir.get_city') }}",
                    dataType: 'json',
                    data: function (params) {
                        return {
                            query: params,
                        };
                    },
                    results: function (data) {
                            var myResults = [];
                            $.each(data.cities, function (index, item) {
                                    myResults.push({
                                            'id': item.raja_ongkir_id + '-' + item.city_name + ',' + item.province.raja_ongkir_id + '-' + item.province.name,
                                            'text': item.city_name + ' (' + item.city_type + '), ' + item.province.name
                                    });
                            });
                            return {
                                    results: myResults
                            };
                    },
                    cache: true
                }
        });

        $('#s2id_autogen2_search').focus();
    });

    $("#address_form_modal").parsley({
        errorClass: 'is-invalid text-danger',
        successClass: 'is-valid',
        errorsWrapper: '<span class="form-text text-danger"></span>',
        errorTemplate: '<small></small>',
        trigger: 'change'
    });

    $("body").on('submit', '#address_form_modal', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var form = $(this);
        form.parsley().validate();

        var formData    = $(this).serialize();

        if (form.parsley().isValid()){
            $('#btn_new_address').attr('disabled', true);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                success: function (respond) {
                    var message = respond.message;
                    if (respond.status) {
                        location.reload();
                    } else {
                        swal("Error", respond.message, "error");
                    }
                    $('#btn_new_address').attr('disabled', false);
                }
            });
        }
    });

    $('#edit-pinpoint').click(function(e) {
        e.preventDefault();
        initAutocomplete();
        $('#address_map_type').val('new');
        $('#addAddress').modal('hide');
        $('#editPinpoint').modal('show');
    });

    $('#edit_form_pinpoint').click(function(e) {
        e.preventDefault();
        initEditFormMap();
        $('#address_map_type').val('edit_form');
        $('#editAddress').modal('hide');
        $('#editPinpoint').modal('show');
    });

    $('.edit_pinpoint_each').click(function(e) {
        var lat = $(this).attr('data-lat');
        var long = $(this).attr('data-long');
        var id = $(this).attr('data-id');
        var state = $(this).attr('data-state');
        $('#temp_id').val(id);
        $('#temp_lat').val(lat);
        $('#temp_long').val(long);
        $('#temp_state').val(state);
        e.preventDefault();
        initEditMap();
        $('#address_map_type').val('edit');
        $('#editPinpoint').modal('show');
    });



    $("body").on('click', '.btn_remove_address', function (e) {
        e.preventDefault();

        var existChecked = false;
        var prods = [];
        $('.check_address:checkbox:checked').each(function(){
            var $this = $(this);
            prods.push([ $this.data('rand') ]);
            existChecked = true;
        });
        if (existChecked) {
            $.ajax({
                type: 'POST',
                url: "{{ route('frontend.user.address.multi_delete_address') }}",
                data:
                {
                    "address": prods,
                    "_token" : "{{ csrf_token() }}"
                },
                success: function (respond) {
                    if (respond.status) {
                        location.reload();
                    } else {
                        swal("Error", respond.message, "error");
                    }
                }
            });
        } else {
            swal("Error", 'Please checked one or multiple product to delete product from wishlist', "error");
        }

    });
});
</script>
@endsection

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/select2/3.4.8/select2.css" />

<style>
.modal-pinpoint.modal-dialog {
    max-width: 100vw;

}
.modal-content {
    max-width: 100vw;
}
select::-ms-expand {
    display: none;
}
select {
    -webkit-appearance: none;
    -moz-appearance: none;
    text-indent: 1px;
    text-overflow: '';
        font-size: 13px;
}

.select2-dropdown--above{
    display: flex; flex-direction: column;
}
.select2-dropdown--above .select2-search--dropdown{
    order: 2;
}
.select2-dropdown--above .select2-results {
order: 1;
}

.select2-dropdown--below{
    display: flex; flex-direction: column;
}
.select2-dropdown--below .select2-search--dropdown{
    order: 1;
}
.select2-dropdown--below .select2-results {
order: 2;
}

.select2-container .select2-choice {
    border:none;
    background-image: none;
}
.select2-arrow {
    display: none !important;
}
.select2-container .select2-choice {
    background: none;
}
#map .centerMarker{
    position:absolute;
    background:url({{ asset('assets/img/map_marker.png') }}) no-repeat;
    top:50%;
    left:50%;
    z-index:1;
    transform: translate(-50%, -50%);
    width:100px;
    height:56px;
    cursor:pointer;
}

</style>
@endsection
