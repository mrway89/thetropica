<div class="modal fade" id="modal_detail_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
          <div class="modal-body p-0">
              <button type="button" class="close btn-closemodal" data-dismiss="modal">&times;</button>
              <div class="col-12 p-5">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="box-popup-img w-100 float-left text-center mb-2">
                            <img src="{{asset('assets/img/product/img1.jpg')}}"/>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 pl-0 pr-0">
                        <div class="box-desc-popup">
                            <div class="w-100 float-left mb-3">
                                <div class="float-left title-img">
                                    <img src="{{ asset('assets/img/logo-watu-detail.png')}}" alt="">
                                </div>
                                <div class="float-left original-nuts d-table box-subtitle">
                                    <div class="my-auto align-bottom d-table-cell subtitle_product type-1">
                                        <h2>cashew nuts original</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 float-left mb-5">
                                <div><span class="bold-700">Origin: </span>Kapuas Hulu, Kalimantan</div>
                                <div><span class="bold-700">Netto: </span>475 gr</div>
                            </div>
                            <div class="w-100 float-left">
                                <h4 class="nothing-font">Finest Cashew Nuts from Sumba</h4>
                                <p class="nothing-font">
                                    Harvested traditionally by the local communities of Kapuas Hulu through the Tikung method on trees that are up to 30-40m high. With our commitment for sustainable nature, we apply The Lestari harvest process to ensure preservation of natural wealth and empowerment of the local communities.  
                                </p>
                            </div>
                        </div>
                        <div class="w-100 float-left">
                            <div class="w-100 float-left">
                                <a href="{{url('frontend/product/product-detail')}}"><button class="btn float-left btn-white btn-oval btn-addcart-popup mr-2">MORE INFORMATION</button></a>
                                <div class="input-group cart-count btn-oval border mr-2">
                                    <button class="btn cl-white btn-gray minus rounded-circle" type="button">-</button>
                                    <input type="number" class="form-control txt-qty border-0" value="1" min="1" max="999" aria-label="QTY">
                                    <button class="btn btn-pink plus  rounded-circle" type="button">+</button>
                                </div>
                                <button class="btn btn-pink btn-oval btn-addcart-popup">ADD TO CART</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
     </div>
   </div>
</div>