<!-- Modal -->
<div class="modal fade" id="editAddress" tabindex="-1" role="dialog" aria-labelledby="editAddressLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-body py-5">
        <button type="button" class="close btn-closemodal" data-dismiss="modal"><p class="mt-0">&times;</p></button>
        <h5 class="text-center mb-3">Edit Address</h5>
        <form action="" method="get" accept-charset="utf-8">
          <div class="form-group row mb-0">
            <div class="col-12">
                <label for="address-label" class="address-label bold-700">Address Label</label>
                <input type="text" class="form-control radius-0 mb-1" id="address-label" placeholder="First name" value="Alamat Kos">
                <p class="text-small example-text">Example: Alamat Rumah, Alamat Kantor, Apartmen, Dropship</p>
            </div>
          </div>

          <div class="form-group row mb-0">
            <div class="col-6">
                <label for="receiver-name" class="address-label bold-700">Receiver's Name</label>
                <input type="text" class="form-control radius-0 mb-1" id="receiver-name" placeholder="Name" value="Joseph Nathaniel">
            </div>
            <div class="col-6">
                <label for="receiver-phone" class="address-label bold-700">Receiver's Phone Number</label>
                <input type="text" class="form-control radius-0 mb-1" id="receiver-phone" placeholder="Phone Number" value="081336511195" onkeypress='validate(event)'>
                <p class="text-small example-text">Example: 081234567890</p>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-8">
                <label for="city-state" class="address-label bold-700">City or State</label>
                <input type="text" class="form-control radius-0 mb-1 input-bg-search" id="city-state" placeholder="City or State" value="DKI Jakarta, Kota Administrasi Jakarta Sel...">
            </div>
            <div class="col-4">
                <label for="postal-code" class="address-label bold-700">Postal Code</label>
                <input type="text" class="form-control radius-0 mb-1" id="postal-code" placeholder="Postal Code" value="12121" onkeypress='validate(event)'>
            </div>
          </div>

          <div class="form-group row mb-4">
            <div class="col-12">
                <label for="address" class="address-label bold-700">Address</label>
                <textarea class="form-control radius-0 mb-1 w-100" placeholder="Address">Jl.Bacang no 8A</textarea>
                <a class="float-right" href="#">Edit Pinpoint</a>
            </div>
          </div>

          <div class="form-group row justify-content-end">
            <div class="col-3 p-0">
                <button type="button" class="btn btn-primary btn-cancel-pop w-100">CANCEL</button>
            </div>
            <div class="col-5">
                <button type="button" class="btn btn-primary btn-send-about w-100" data-dismiss="modal" data-toggle="modal" data-target="#changeAddress">CHANGE ADDRESS</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>