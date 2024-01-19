<div class="modal fade" id="modalAddReviews" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <button type="button" class="close btn-closemodal" data-dismiss="modal"><p>&times;</p></button>
                    <form action="">
                        <div class="col-12 p-5">
                            <div class="row">
                                <div class="col-lg-5 col-md-5 mb-md-0 mb-3">
                                    <div class="bordashed">
                                        <div id="productreview" class=" dropdrag p-0 border-0 dropzone">
                                            <div class="dz-message my-0">
                                                <div class="drag-icon-cph"> <img class="w-100" src="{{asset('assets/img/addproduct.png')}}"/> </div>
                                                {{-- <h5>DRAG & DROP PHOTOS HERE</h5>
                                                <button type="button" class="btn btn-orange rubik-light fontsize-14 rounded-0 uppercase pl-4 pr-4 pt-2 pb-2 mb-3">Choose Photos</button>
                                                <em>JPG, JPEG and PNG files only (Maximum 1 MB per photo)</em> --}}
                                            </div>
                                            <div class="fallback">
                                                <input name="myfile" class="hidden" type="file" multiple />
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="slider-for mb-4 fallback">
                                        <div class="items">
                                            <input type="file"  name="" id="productreview" multiple>
                                            <a href="javascript:;" onclick="$('#productreview').click();"><img src="{{asset('assets/img/addproduct.png')}}" alt=""></a>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="col-lg-7 col-md-7">
                                    <div class="row d-flex justify-content-start mb-3">
                                        <div class="col-md-2 title-rating mb-2">Product:</div>
                                        <div class="col-md-6">
                                            <select name="" id="" class="custom-select selectreview">
                                                <option value="">WatuMultifloral Honey 200ml</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-md-start justify-content-center">
                                        <div class="col-md-2 title-rating mb-2">Product Quality:</div>
                                        <div class="col-md-6 d-flex flex-column">
                                            <div class="star-rating position-relative mb-2  d-flex justify-content-md-start justify-content-center" >
                                                {{-- <div class="ofrate"></div> --}}
                                                <div class="rateview-md" data-id="1" data-rating="0"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-flex justify-content-md-start justify-content-center">
                                        <div class="col-md-12 title-rating mb-3">Reviews:</div>
                                        <div class="col-md-12">
                                        <textarea name="" id="" placeholder="Thank you for your purchase! Please review our product or service here." class="form-control textarea" cols="4" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12 mb-3 d-flex justify-content-md-end justify-content-center">
                                            <button type="submit" class="btn btn-pink btn-oval btn-addcart-popup">SUBMIT REVIEW</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
