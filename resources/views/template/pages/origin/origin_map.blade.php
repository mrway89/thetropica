@extends('template/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="section fp-table about-home origin-1" id="origin-1">
    <div class="container container-product mt-container">
        <div class="row">
            <div class="col-md-4 text-left text-white ">
                <h1 class="mt-sm-5 mt-5 mb-4 title-orimap">Discover The Origin</h1>
                <div class="text-left text-white p-smaller desc-origin-map">
                    <p>Each point represent the origin where our products come from.
                     Click to learn more about certain origin. Let's Explore!</p>
                     <ul class="list-unstyled list-menu-ori nav hidden-768" id="nav-tab" role="tablis">
                        @foreach($origin as $key => $value)
                        <li><a class="nav-link" onclick="change_bg('{{asset('assets/img/map_origin_change.jpg')}}')" data-toggle="tab" href="#origin_{{$key}}" role="tab">{{$value}}</a></li>
                        @endforeach
                     </ul>
                     <ul class="list-unstyled list-menu-ori nav visible-768" id="nav-tab" role="tablis">
                        @foreach($origin as $key => $value)
                            <li><a class="nav-link" href="{{url('frontend/origin/discover')}}" role="tab">{{$value}}</a></li>
                        @endforeach
                     </ul>
                </div>
            </div>
            <div class="col-md-8 text-white">
                <div class="tab-content" id="nav-tabContent">
                    @foreach($origin as $key => $value)
                    <div class="box-origin text-center float-right tab-pane fade" role="tabpanel" id="origin_{{$key}}">
                        <h4>Truly Enchanting</h4>
                        <h1>{{$value}}</h1>
                        <p>The people of of Sumba are the guardians of the land for generations, nurfaring nature as much
                            as if has give in from of the best of chasew nuts in the region with the highest quality in the purest form.
                        </p>
                        <a href="{{url('frontend/origin/discover')}}"><button type="button" class="btn-oval mt-2 btn-transparant btn">DISCOVER SUMBA</button></a>
                    </div>
                    @endforeach
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
<script src="{{ asset('assets/js/fullpage.min.js')}}"></script>
<script>
	$(document).ready(function() {
		$('#fullpage').fullpage({
			//options here
			anchors: ['1', '2', '3', '4', '5', '6'],
			autoScrolling:true,
			scrollHorizontally: true,
			// normalScrollElements: 'footer'
		});

		//methods
		$.fn.fullpage.setAllowScrolling(true);
	});
	$(document).on('click', '#moveTo1', function(){
	  fullpage_api.moveTo('page1', 1);
	});

	$(document).on('click', '#moveTo2', function(){
	  fullpage_api.moveTo('page2', 2);
	});
    function change_bg(bg){
        $('#origin-1').css({"background":"url('"+ bg +"')",});
    }
</script>
@endsection
