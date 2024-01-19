@extends('frontend/layouts/main')

@section('custom_css')
@endsection

@section('content')

<div class="content-area">
	<div class="container container-product">
		<div class="row">
			<div class="col-md-9 offset-md-3 pt-3">
				<h3 class="bold-300 mb-4 pt-md-0 pt-5">
					@if (Request::segment(2) == 'faqs')
					Frequently Asked Questions
					@endif
					@if (Request::segment(2) == 'shopping-guide')
					{{ $trans['purchase_side_menu_shopping_guide'] }}
					@endif
					@if (Request::segment(2) == 'payment-guide')
					{{ $trans['purchase_side_menu_payment_guide'] }}
					@endif
				</h3>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-6 pt-md-0">
				@include('frontend.purchase.includes.side_menu')
			</div>
			<div class="col-sm-6 col-6 visible-768 pt-md-0">
				<form>
					<select id="select-shoppingguide" class="custom-select select-shoppingguide w-100 mb-5">
						@foreach ($posts as $i=>$item)
						<option value='{{ $i }}'>{{ $item->{'title_' . $language} }}</option>
						@endforeach
					</select>
				</form>
			</div>
			<div class="col-md-9">
                @yield('purchase_content')
			</div>
		</div>
	</div>
</div>

@endsection

@section('footer')
@include('frontend/includes/footer')
@endsection

@section('custom_js')

<script>
	$('.select-shoppingguide').on('change', function (e) {
	    $('#tab-shoppingguide li a').eq($(this).val()).tab('show');
	});
</script>

@endsection
