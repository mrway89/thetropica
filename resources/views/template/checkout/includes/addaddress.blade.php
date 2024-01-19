<!-- Modal -->
<div class="modal fade" id="addAddress" tabindex="-1" role="dialog" aria-labelledby="addAddressLabel" aria-hidden="true">
  <div class="modal-dialog modal-full modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close btn-closemodal" data-dismiss="modal"><p class="mt-0">&times;</p></button>
        <h5 class="text-center mb-3">Add New Address</h5>
        <form action="" method="get" accept-charset="utf-8">
          <div class="form-group row mb-0">
            <div class="col-12">
                <label for="address-label" class="address-label bold-700">Address Label</label>
                <input type="text" class="form-control radius-0 mb-1" id="address-label" placeholder="First name">
                <p class="text-small example-text">Example: Alamat Rumah, Alamat Kantor, Apartmen, Dropship</p>
            </div>
          </div>

          <div class="form-group row mb-0">
            <div class="col-md-6 col-12 pr-md-0">
                <label for="receiver-name" class="address-label bold-700">Receiver's Name</label>
                <input type="text" class="form-control radius-0 mb-1" id="receiver-name" placeholder="Name">
            </div>
            <div class="col-md-6 col-12 ">
                <label for="receiver-phone" class="address-label bold-700">Receiver's Phone Number</label>
                <input type="text" class="form-control radius-0 mb-1" id="receiver-phone" placeholder="Phone Number" onkeypress='validate(event)'>
                <p class="text-small example-text">Example: 081234567890</p>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-8 col-12 pr-md-0">
                <label for="city-state" class="address-label bold-700">City or State</label>
                <input type="text" class="form-control radius-0 mb-1 input-bg-search pr-4" id="city-state" placeholder="City or State">
            </div>
            <div class="col-md-4 col-12">
                <label for="postal-code" class="address-label bold-700" >Postal Code</label>
                <input type="text" class="form-control radius-0 mb-1" id="postal-code" placeholder="Postal Code" onkeypress='validate(event)'>
            </div>
          </div>

          <div class="form-group row mb-4">
            <div class="col-12">
                <label for="address" class="address-label bold-700">Address</label>
                <textarea class="form-control radius-0 mb-1 w-100" placeholder="Address"></textarea>
                <a class="float-right" data-dismiss="modal" data-toggle="modal" id="edit-pinpoint" data-target="#editPinpoint" href="#">Edit pinpoint</a>
            </div>
          </div>

          <div class="form-group row justify-content-center">
            <div class="col-md-3 col-4 p-0">
                <button type="button"  data-dismiss="modal" class="btn btn-primary btn-cancel w-100">CANCEL</button>
            </div>
            <div class="col-md-5 col-6">
                <button type="button" class="btn btn-primary btn-send-about w-100">ADD ADDRESS</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>