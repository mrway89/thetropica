@extends('template/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-area">
	<div class="container container-product">
		<div class="row">
			<div class="col-md-9 offset-3 pt-3 hidden-768">
				<h3 class="result mb-4 pt-md-5 pt-0">Pick Up Point</h3>
			</div>
			@include('template/pages/purchase/includes/sidebar_purchase')
            <div class="col-sm-6 col-6 visible-768">
                <form>
                    <select id="select-shoppingguide" class="custom-select select-search select-shoppingguide float-left w-100 mb-5 mr-2">
                        <option value='0'>Account</option>
                    </select>
                </form>
            </div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="row">
                   <div class="col-12 desc-faq">
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium
                            doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore
                            veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                        </p>
                        <ul class="list-unstyled float-left list-pickup pl-0">
                            <li>
                                <p><b>Jakarta</b></br>
                                    Puri Jimbaran blok E 6 i /26</br>
                                    Ancol Timur</br>
                                    Jakarta 14430
                                </p>
                            </li>
                            <li>
                                <p><b>Bekasi</b></br>
                                    Kawasan Industri MM2100</br>
                                    Jl. Irian v Blok MM-2</br>
                                    Cibitung, Bekasi 17520
                                </p>
                            </li>
                            <li>
                                <p><b>Bandung</b></br>
                                    Jl.Kartini No.6</br>
                                    Bandung 40135
                                </p>
                            </li>
                            <li>
                                <p><b>Bali</b></br>
                                    Bali Talasi Bumi Tabanan</br>
                                    Jl. Wira No. 8, Sanur</br>
                                    Denpasar, Bali 80228
                                </p>
                            </li>
                            <li>
                                <p><b>Semarang</b></br>
                                    Jl. Kuala Mas | No.42</br>
                                    Semarang 50177
                                </p>
                            </li>
                        </ul>
                   </div>
                </div>
			</div>
		</div>
	</div>
</div>			

@endsection

@section('footer')
@include('template/includes/footer')
@endsection

@section('custom_js')
<script src="{{asset('assets/js/count_qty.js')}}"></script>
<script>
	$('#select-shoppingguide').on('change', function (e) {
	    $('#tab-shoppingguide li a').eq($(this).val()).tab('show'); 
	});
</script>	

@endsection
