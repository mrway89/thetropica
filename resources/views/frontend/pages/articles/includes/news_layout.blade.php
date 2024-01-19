@extends('frontend/layouts/main')

@section('custom_css')
@endsection

@section('content')

<div class="content-area">
	<div class="container container-product">
		<div class="row">
			<div class="col-md-12">
                @yield('purchase_content')
			</div>
		</div>
	</div>
</div>

@endsection

@section('footer')
@include('frontend/includes/footer')
@endsection
