@extends('frontend/layouts/main')

@section('custom_css')
@endsection

@section('content')

<div class="section fp-table about-home" style="background: url({{ asset('assets/img/peta.jpg') }});">
	<div class="fp-tableCell">
		<div class="row justify-content-center">
	        <div class="col-md-9 text-center text-white">
	        </div>
	    </div>
	</div>
</div>

@endsection

@section('footer')
{{-- @include('frontend/includes/footer') --}}
@endsection

@section('custom_js')
<script src="{{ asset('assets/js/fullpage.min.js')}}"></script>
<script>
	$(document).ready(function() {
		$('#fullpage').fullpage({
			//options here
			autoScrolling:true,
			scrollHorizontally: true,
			normalScrollElements: 'footer'
		});

		//methods
		$.fn.fullpage.setAllowScrolling(true);
	});
</script>
@endsection
