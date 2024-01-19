<!-- Modal -->
<div class="modal fade" id="editPinpoint" tabindex="-1" role="dialog" aria-labelledby="editPinpointLabel" aria-hidden="true">
  <div class="modal-dialog modal-full modal-pinpoint modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-body py-3">
        <button type="button" class="close btn-closemodal" data-dismiss="modal"><p class="mt-0">&times;</p></button>
        <h5 class="text-mb-center text-left mb-3">Edit Pinpoint</h5>
        <input id="pac-mobile " class="pac-input form-control controls input-bg-search  mt-3 mb-2 visible-480" type="text" placeholder="Search Box">
        <div class="text-mb-center text-left"><p class="label-12">Please make sure that the location you pinpoint is the same as the address you mentioned.</p></div>
        <input id="pac-input" class="controls form-control input-bg-search mt-3 hidden-480" type="text" placeholder="Search Box">
        <div id="map"></div>
        <div class="address-map px-3 py-2">
          <img src="{{ asset('assets/img/pinpoint.png') }}" class="mr-2" alt=""><span class="mt-2">Jalan Bacang 8A, Kebayoran Baru, 12121</span class="mt-2">
        </div>
      </div>
    </div>
  </div>
</div>

 <script>
      // This example adds a search box to a map, using the Google Place Autocomplete
      // feature. People can enter geographical searches. The search box will return a
      // pick list containing a mix of places and predicted search terms.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -6.21462, lng: 106.84513},
          zoom: 11,
          mapTypeId: 'roadmap',
          mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.LEFT_BOTTOM
            },
          fullscreenControl: false
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
          document.getElementById('latitude').value = map.getCenter().lat();
          document.getElementById('longitude').value = map.getCenter().lng();
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              // icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKcgmzuGrRPykWiFNS3uH5bxXG93wo264&libraries=places&callback=initAutocomplete"
         async defer></script>
