@extends('frontend/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-area">
	<div class="container container-product">
		<div class="row">
			<div class="col-lg-9 col-md-9 col-sm-12 col-12 offset-md-3 offset-lg-3">
                <div class="row">
                   <div class="col-12 desc-faq mt-md-0 mt-3">
                        <h3 class="result mb-4 pt-md-5 pt-0">{{ $post->{'title_' . $language} }}</h3>

                        {!! $post->{'content_' . $language} !!}
                   </div>
                </div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('footer')
@include('frontend/includes/footer')
@endsection

@section('custom_js')
<script src="{{asset('assets/js/count_qty.js')}}"></script>
<script>
	$('#select-shoppingguide').on('change', function (e) {
	    $('#tab-shoppingguide li a').eq($(this).val()).tab('show');
	});
</script>

@endsection
