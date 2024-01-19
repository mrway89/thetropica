@extends('frontend/layouts/main')

@section('custom_css')
<style>
.desc-discover-origin,
.title-discover-origin_type2 h1 {
    color:white;
}
</style>

@endsection

@section('content')

@foreach ($slides as $i => $slide)
    @if ($i == 0)
        <div class="section fp-table about-area" id="origin_discover-{{ $i+1 }}" style="background: url({{ asset($slide->url) }});">
            <div class="fp-tableCell">
                <div class="row align-items-center d-flex minh-100vh justify-content-center">
                    <div>
                        <div class="col-md-12 text-center text-white title-discover-origin mt-md-5">
                            <h1 class="mb-4">{{ $slide->{'title_' . $language} }}</h1>
                        </div>
                        <div  class="d-flex justify-content-center">
                            <div class="col-md-8 col-sm-8 col-12 pl-md-3 pr-md-3 pl-4 pr-4 text-center text-white desc-discover-origin">
                                <p>
                                    {{ $slide->{'content_' . $language} }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="discover discover-product discover-ori">
                <a href="#{{ $i+2 }}" title="">
                    <p>Discover {{ ucwords($origin->name) }}</p>
                    <img src="{{ asset('assets/img/down-button.png') }}" alt="">
                </a>
            </div>
        </div>
    @elseif($i == $slides->count() - 1)
        <div class="section fp-table about-area" id="origin_discover-{{ $i+1 }}" style="background: url({{ asset($slide->url) }});">
            <div class="mt-5">
                <div class="container container-product ">
                    <div class="row pt-5">
                        <div class="col-lg-5 col-md-6 text-left text-white title-discover-origin_type2  mt-5">
                            <h1 class="mb-4">{{ $slide->{'title_' . $language} }}</h1>
                            <div class="text-left text-white desc-discover-origin">
                                <h5>{{ $slide->{'subtitle_' . $language} }}</h5>
                                <p>
                                    {{ $slide->{'content_' . $language} }}
                                </p>
                                <div class="w-100 float-left mt-2 hidden-768">
                                    <div class="row mt-5">
                                        <div class="col-lg-6 col-md-12 mb-2">
                                        <a href="{{ route('frontend.origin.index') }}"><button type="button" class="btn btn-oval w-100 btn-transparant">
                                                EXPLORE OTHER ORIGIN
                                            </button></a>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-2">
                                            <a href="{{ route('frontend.product.purchase', ['origin' => $origin->id]) }}"><button type="button" class="btn btn-oval w-100 btn-red">
                                                BROWSE PRODUCTS
                                            </button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-6">
                            <div class="img-origin">
                                <img src="{{asset($origin->bottom->url)}}"/>
                            </div>
                        </div>
                    </div>

                    <div class="row visible-768">
                        <div class="w-100 float-left mt-2 mb-2">
                            <div class="col-lg-6 col-md-12 col-sm-6 col-6 pr-md-3 pr-0 float-left mb-2">
                            <a href="{{ route('frontend.origin.index') }}"><button type="button" class="btn btn-oval btn-ori-font w-100 btn-transparant">
                                    EXPLORE OTHER ORIGIN
                                </button></a>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-6 col-6 pl-md-3 pl-3 float-left mb-2">
                                <a href="{{ route('frontend.product.purchase', ['origin' => $origin->id]) }}"><button type="button" class="btn btn-oval btn-ori-font w-100 btn-red">
                                    BROWSE PRODUCTS
                                </button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="discover discover-product discover-ori">
                <a href="#7" title="">
                    <p>Discover Sumba</p>
                    <img src="{{ asset('assets/img/down-button.png') }}" alt="">
                </a>
            </div> --}}
        </div>
    @else
        <div class="section fp-table about-area" id="origin_discover-{{ $i+1 }}" style="background: url({{ asset($slide->url) }});">
            <div class="fp-tableCell">
                <div class="container container-product">
                    <div class="row align-items-center d-flex minh-100vh">
                        <div class="col-lg-5 col-md-6 text-left title-discover-origin_type2">
                            <h1 class="mb-4">{{ $slide->{'title_' . $language} }}</h1>
                            <div class="text-left desc-discover-origin">
                                <h5>{{ $slide->{'subtitle_' . $language} }}</h5>
                                <p>
                                    {{ $slide->{'content_' . $language} }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="discover discover-product discover-ori">
                <a href="#{{ $i+2 }}" title="">
                    <img src="{{ asset('assets/img/down-button.png') }}" alt="">
                </a>
            </div>
        </div>
    @endif
@endforeach

@endsection

@section('footer')
@include('frontend/includes/footer')
@endsection

@section('custom_js')
<script src="{{ asset('assets/js/fullpage.min.js')}}"></script>
<script>
	$(document).ready(function() {
		$('#fullpage').fullpage({
			//options here
			anchors: ['1', '2', '3', '4', '5', '6','7'],
			autoScrolling:true,
            scrollHorizontally: true,
            scrollOverflow: true,
            scrollOverflowReset: true,
            scrollOverflowOptions: null
			// normalScrollElements: 'footer'
		});

		//methods
		$.fn.fullpage.setAllowScrolling(true);
	});
	// $(document).on('click', '#moveTo1', function(){
	//   fullpage_api.moveTo('page1', 1);
	// });

	// $(document).on('click', '#moveTo2', function(){
	//   fullpage_api.moveTo('page2', 2);
	// });
	// $(document).on('click', '#moveTo3', function(){
	//   fullpage_api.moveTo('page3', 3);
	// });
	// $(document).on('click', '#moveTo4', function(){
	//   fullpage_api.moveTo('page4', 4);
	// });
</script>
@endsection
