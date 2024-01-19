<div class="modal fade" id="modal_codesuccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-modal">
            <div class="modal-body p-0">
                <button type="button" class="close btn-closemodal" data-dismiss="modal"><p>&times;</p></button>
                <div class="col-12 p-md-5 p-3 text-center">
                    <div class="congrats mb-3">Congratulations! You get</div>
                    <h3 class="referral-title mb-4">Talasi Referral Special Coupon</h3>
                    <div class="coupon-referall">
                        <img src="{{asset($coupon->images)}}" alt="">
                    </div>
                    <div class="row d-flex justify-content-center mt-4 px-5">
                        <div class="col-md-7 desc-modal ">
                            @if ($notification->downline_id)

                                <p><b>{{ $notification->downline->name }}</b> telah bergabung dengan keluarga Talasi berkat undangan Anda. Talasi Coupon spesial di atas telah ditambahkan ke halaman kupon Anda.</p>

                            @else

                                <p>Selamat! Anda telah bergabung dengan keluarga Talasi. Talasi Coupon spesial di atas telah ditambahkan ke halaman kupon Anda.</p>

                            @endif

                            <p>Silahkan cek di halaman <a href="{{ route('frontend.user.coupon') }}">My Coupon</a> untuk mendapatkan informasi lebih detail mengenai Talasi Coupon ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
