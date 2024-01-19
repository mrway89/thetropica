<!-- Modal -->
<div class="modal fade" id="addAddress" tabindex="-1" role="dialog" aria-labelledby="addAddressLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close btn-closemodal" data-dismiss="modal"><p class="mt-0">&times;</p></button>
        <h5 class="text-center mb-3">Add New Address</h5>
        <form action="{{ route('frontend.user.address.save') }}" method="POST" id="address_form_modal">
          {{ csrf_field() }}
          <div class="form-group row mb-0">
            <div class="col-12">
                <label for="address-label" class="address-label bold-700">Address Label</label>
                <input type="text" class="form-control radius-0 mb-1" id="address-label" placeholder="Label" name="label">
                <p class="text-small example-text">Example: Alamat Rumah, Alamat Kantor, Apartmen, Dropship</p>
            </div>
          </div>

          <div class="form-group row mb-0">
            <div class="col-6 pr-0">
                <label for="receiver-name" class="address-label bold-700">Receiver's Name</label>
                <input type="text" class="form-control radius-0 mb-1" id="receiver-name" placeholder="Name" name="name">
            </div>
            <div class="col-6">
                <label for="receiver-phone" class="address-label bold-700">Receiver's Phone Number</label>
                <input type="text" class="form-control radius-0 mb-1" id="receiver-phone" placeholder="Phone Number" onkeypress='validate(event)' name="phone_number">
                <p class="text-small example-text">Example: 081234567890</p>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-8 pr-0">
                <label for="city-state" class="address-label bold-700">City or State</label>
                <input type="text" class="form-control radius-0 mb-1 input-bg-search pr-4" id="city-state" placeholder="City or State" name="city">
            </div>
            <div class="col-4">
                <label for="postal-code" class="address-label bold-700" >Postal Code</label>
                <input type="text" class="form-control radius-0 mb-1" id="postal-code" placeholder="Postal Code" onkeypress='validate(event)' name="postal_code">
            </div>
          </div>

          <div class="form-group row mb-4">
            <div class="col-12">
                <label for="address" class="address-label bold-700">Address</label>
                <textarea class="form-control radius-0 mb-1 w-100" placeholder="Address" id="address_input_form" name="address"></textarea>
                <a class="float-right" id="edit-pinpoint" href="#">Edit pinpoint</a>
            </div>
          </div>

          <input name="lat" id='latitude' type="hidden" value="" class="hidden">
          <input name="long" id='longitude' type="hidden" value="" class="hidden">
          <div class="form-group row justify-content-end">
            <div class="col-3 p-0">
                <button type="button" class="btn btn-primary btn-cancel w-100">CANCEL</button>
            </div>
            <div class="col-5">
                <button type="submit" class="btn btn-primary btn-send-about w-100" id="btn_new_address">ADD ADDRESS</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
