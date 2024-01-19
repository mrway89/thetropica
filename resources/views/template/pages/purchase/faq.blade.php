@extends('template/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-area">
	<div class="container container-product pt-mb-0 pt-3">
		<div class="row">
			<div class="col-md-9 offset-3 pt-3 hidden-768">
				<h3 class="result mb-4 pt-md-5 pt-0">Frequently Asked Questions</h3>
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
                <div class="row ">
                    <div class="col-lg-3 col-md-3 hidden-768">
                        <form>
                            <select id="select-shoppingguide" class="custom-select select-search select-shoppingguide float-left w-100 mb-5 mr-2">
                                <option value='0'>Account</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="row">
                   <div class="col-12 desc-faq">
                        <h5>How does Google protect my privacy and keep my information secure?</h5>
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium
                            doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore
                            veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim
                            ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
                            consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. 
                            Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur,
                            adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et
                            dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum
                            exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi
                            consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse
                            quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla
                        </p>
                        <p><a href="">How to create multiple accounts?</a></p>
                        <p><a href="">How to refer this website to friends and family?</a></p>

                        <h5>How does Google protect my privacy and keep my information secure?</h5>
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium
                            doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore
                            veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim
                            ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
                            consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. 
                            Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur,
                            adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et
                            dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum
                            exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi
                            consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse
                            quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla
                        </p>
                        <h5>How does Google protect my privacy and keep my information secure?</h5>
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium
                            doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore
                            veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim
                            ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
                            consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. 
                            Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur,
                            adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et
                            dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum
                            exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi
                            consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse
                            quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla
                        </p>
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
