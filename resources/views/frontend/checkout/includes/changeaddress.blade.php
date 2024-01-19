<!-- Modal -->
<div class="modal fade" id="changeAddress" tabindex="-1" role="dialog" aria-labelledby="changeAddressLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close btn-closemodal" data-dismiss="modal"><p class="mt-0">&times;</p></button>
        <h5 class="text-center mb-5">Change Address</h5>
        <form action="" method="get" accept-charset="utf-8">
          <div class="form-group row">
            <div class="col-12">
                <input type="text" class="form-control radius-0 mb-2 input-bg-search" id="search_address" onkeyup="filterAddressList()" placeholder="Change Address">
            </div>
          </div>
        </form>

        <div id="myAddress">
          @foreach (\Auth::user()->addresses as $address)
          <div class="row address_row" data-filtername="{{ $address->name }} {{ $address->label }} {{ $address->phone_number }} {{ $address->address }} {{ $address->city }} {{ $address->province }} {{ $address->postal_code }}">
            <div class="col-12 mb-5">
                <div class="checkout-address-area">
                  <p class="mb-1"><span class="bold-700">{{ $address->name }}</span> ({{ $address->label }}) <span class="badge badge-address">{{ $address->is_default == 1 ? 'Main Address' : '' }}</span></p>
                <p class="mb-1">{{ $address->phone_number }}</p>
                <p class="mb-1">{{ $address->address }}</p>
                <p class="mb-1">{{ $address->city }}, {{ $address->province }}, {{ $address->postal_code }}</p>
                <a href="#" class="bold-700" onclick="editAddress({{ $address->id }})">Edit Address</a>
                  <span class="mx-2">|</span>
                  {{-- <a href="#" class="bold-700" onclick="initEditFormMap({{ '"'. $address->city . '","' . $address->lat . '","' . $address->long . '"'}})">Edit Pinpoint</a> --}}
                  {{-- <span class="mx-2">|</span> --}}
                  <a href="#" class="bold-700 process_loading" onclick="useAddress({{ $address->id }})" onclick="useAddress({{ $address->id }})">Use Address</a>
                </div>
            </div>
          </div>
          @endforeach
        </div>

        <div class="row">
          <div class="col-12">
              <a data-dismiss="modal" data-toggle="modal" id="edit-pinpoint" data-target="#addAddress" href="#">Add New Address +</a>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
