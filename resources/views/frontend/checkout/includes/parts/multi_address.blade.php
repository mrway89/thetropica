<div class="row mt-4">
    <div class="checkout-address-area col-md-6">
        <p class="mb-1"><span class="bold-700">{{ $address->name }}</span> ({{ $address->label }})</p>
        <p class="mb-1">{{ $address->phone_number }}</p>
        <p class="mb-1">{{ $address->address }}</p>
        <p class="mb-1">{{ $address->city }}, {{ $address->province }}, {{ $address->postal_code }}</p>
        <a href="#" class="bold-700" title="" data-toggle="modal" data-target="#editAddress">Change Address</a>
    </div>
    <div class="col-md-6 mt-sm-2 d-flex flex-row-reverse align-items-end">
        <div class="row ">
            <div class="col-md-12 mb-4">
                <div class="input-group input-group-number w-100 float-right">
                    <div class="d-flex">
                        <div id="field1" class="input-group-btn">
                            <button type="button" id="sub" class="btn btn-default btn-gray btn-number sub">-</button>
                            <input type="text" id="1" value="1" min="1" max="1000" class="form-control input-number input_qty" data-price="{{ $product->price }}"  name="address[{{ $address->id }}][{{ $product->id }}]['quantity'][]" />
                            <button type="button" id="add" class="btn btn-default btn-number add">+</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 ">
                <a href="#" class="bold-700 delete_current_address" title="" >Delete Address</a>
            </div>
        </div>
    </div>
</div>
