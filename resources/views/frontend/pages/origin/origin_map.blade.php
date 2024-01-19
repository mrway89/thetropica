@extends('frontend/layouts/main')

@section('custom_css')
<style type="text/css">
  html { height: 100% }
  body { height: 90%; margin: 0; padding: 0 }
  #map_canvas { height: 100% }
  .mps_vs {
    font-weight: bold;
    color: #9C7862;
    font-family: "Nothing You Could Do", Sans-serif;
    font-size: 18px;
}

.mps_cv {
    margin-top: 10px;
    color: #404143;
    font-size: 14px;
    font-weight: 500;
    text-transform: capitalize;
}
  
</style>
@endsection
<script type="text/javascript"
    src="http://maps.googleapis.com/maps/api/js?key=AIzaSyB1tbIAqN0XqcgTR1-FxYoVTVq6Is6lD98&sensor=false">
</script>
<script type="text/javascript">

var locations = [
  ['Bangka', -2.133333, 106.116669, 'Honey Multifloral'],
  ['Jambi, Kerinci', -1.609972, 103.607254, 'Mist Cinnamon'],
  ['Riau, Kuansing', 0.533505, 101.447403, 'Honey Multifloral'],
  ['Sumatera Barat', -0.626439, 100.117958, 'Hand Sanitizer (Lemon)'],
  ['Sumatera Utara', 1.749987, 98.776703, 'Hand Sanitizer (Orange)'],
  ['Kapuas Hulu', 0.840424, 112.802539, 'Honey Multifloral'],
  ['Borneo Barat', -0.725078, 110.676842, 'Hand Sanitizer (Cucumber)'],
  ['Sulawesi Selatan', -5.135399, 119.423790, 'Honey Multifloral'],
  ['Pulau Buru', -3.414725, 126.628732, 'Cajeput Oil & Telon Oil'],
  ['Pulau Alor', -8.276727, 124.744169, 'Turmenic'],
  ['Kupang', -10.166264, 123.595861, 'Lontar Sugar'],
  ['Pulau Rote', -10.687599, 123.192296, 'Honey Multifloral'],
  ['Tabanan', -8.537565, 115.124091, 'Mist Cinnamon'],
  ['Karang Anyar', -7.599385, 110.947698, 'Ginger Concentrate'],
  ['Merapi', -7.543571, 110.444081, 'Honey Monofloral'],
  ['Jawa Barat', -6.93597, 107.580309, 'Hand Sanitizer (Lemongrass)'],
   ['Ujung Kulon', -6.776444, 105.586903, 'Honey Multifloral']
  ];

  function initialize() {

    var myOptions = {
      center: new google.maps.LatLng(-8.276727, 124.744169),
      zoom: 4.8,
      mapTypeId: google.maps.MapTypeId.ROADMAP

    };
    var map = new google.maps.Map(document.getElementById("default_map"),
        myOptions);

    setMarkers(map,locations)

  }



  function setMarkers(map,locations){

      var marker, i

	for (i = 0; i < locations.length; i++)
	 {  

	 var loan = locations[i][0]
	 var lat = locations[i][1]
	 var long = locations[i][2]
	 var add =  locations[i][3]

	 latlngset = new google.maps.LatLng(lat, long);

	  var marker = new google.maps.Marker({  
			  map: map, title: loan , position: latlngset  
			});
			map.setCenter(marker.getPosition())


			var content = "<span class='mps_vs'>" + loan + "</span><br /><span class='mps_cv'>" + add + "</span>" 

	  var infowindow = new google.maps.InfoWindow()

	google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
			return function() {
			   infowindow.setContent(content);
			   infowindow.open(map,marker);
			};
		})(marker,content,infowindow)); 

	  }
  }

  </script>


@section('content')
<div class="content-area">
    
<center><h1 class="mb-md-5 mb-1">Discover The Origins</h1></center>	
<div id="default_map" style="width:100%; height:100%"></div>

</div>


<!--<div class="section fp-table about-home origin-1" style="background: url({{asset($content->url)}});">
    <div class="container container-product pt-5">
        <div class="row">
            <div class="col-md-6 text-left text-white  mt-5">
                <h1 class="mt-sm-5 mt-5 mb-4 title-orimap">{{ $content->{'title_' . $language} }}</h1>
                <div class="text-left text-white p-smaller desc-origin-map">
                    <p>{!! $content->{'content_' . $language} !!}</p>
                    <ul class="list-unstyled list-menu-ori nav hidden-768" id="nav-tab" role="tablis">
                        @foreach($origins as $key => $origin)
                        <li><a class="nav-link" onclick="change_bg('{{ asset($origin->map) }}')" data-toggle="tab" href="#origin_{{$key}}" role="tab">{{ ucwords($origin->village) }}</a></li>
                        @endforeach
                    </ul>
                    <ul class="list-unstyled list-menu-ori nav visible-768" id="nav-tab" role="tablis">
                        @foreach($origins as $key => $origin)
                            <li><a class="nav-link" href="{{ route('frontend.origin.detail', $origin->slug) }}" role="tab">{{ ucwords($origin->village) }}</a></li>
                        @endforeach
                    </ul>
                </div>

            </div>
            <div class="col-md-6 text-white ">
                <div class="tab-content" id="nav-tabContent">
                    @foreach($origins as $key => $origin)
                    <div class="box-origin text-center float-right tab-pane fade" role="tabpanel" id="origin_{{$key}}">
                        <h4>{{ $origin->{'title_' . $language} }}</h4>
                        <h1>{{ ucwords($origin->village) }}</h1>
                        <p>
                            {{ $origin->{'description_' . $language} }}
                        </p>
                        @if ($content_check[$origin->id])
                        <a href="{{ route('frontend.origin.detail', $origin->slug) }}"><button type="button" class="btn-oval mt-2 btn-transparant btn">DISCOVER {{ strtoupper($origin->village) }}</button></a>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
			
        </div>
    </div>
</div>-->

@endsection

@section('footer')
@include('frontend/includes/footer')
@endsection

@section('custom_js')
