
@foreach ($addresses as $address)
<div class="row address_row" data-filtername="{{ $address->name }} {{ $address->label }} {{ $address->phone_number }} {{ $address->address }} {{ $address->city }} {{ $address->province }} {{ $address->postal_code }}">
<div class="col-12 mb-5">
    <div class="checkout-address-area">
        <input type="hidden" class="address_id_{{ $product }}" value="{{ $address->id }}">
        <p class="mb-1"><span class="bold-700">{{ $address->name }}</span> ({{ $address->label }}) <span class="badge badge-address">{{ $address->is_default == 1 ? 'Main Address' : '' }}</span></p>
        <p class="mb-1">{{ $address->phone_number }}</p>
        <p class="mb-1">{{ $address->address }}</p>
        <p class="mb-1">{{ $address->city }}, {{ $address->province }}, {{ $address->postal_code }}</p>
        {{-- <a href="#" class="bold-700" onclick="editAddress({{ $address->id }})">Edit Address</a>
        <span class="mx-2">|</span>
        <a href="#" class="bold-700" onclick="initEditFormMap({{ '"'. $address->city . '","' . $address->lat . '","' . $address->long . '"'}})">Edit Pinpoint</a>
        <span class="mx-2">|</span> --}}
        <a href="#" class="bold-700" onclick="useAddress({{ $address->id }})">Use Address</a>
    </div>
</div>
</div>
@endforeach
