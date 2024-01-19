<!-- Modal -->
<div class="modal fade" id="editPinpoint" tabindex="-1" role="dialog" aria-labelledby="editPinpointLabel" aria-hidden="true">
    <div class="modal-dialog modal-full modal-pinpoint modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-body py-3">
            <button type="button" class="close btn-closemodal" data-dismiss="modal"><p class="mt-0">&times;</p></button>
            <h5 class="text-mb-center text-left mb-3">Pinpoint Location</h5>
            <input id="address_map_type" type="hidden">
            <input id="pac-input" class="controls form-control input-bg-search mt-3" type="text" placeholder="Search Box">
            <div id="map"></div>
            <div class="address-map px-3 py-2">
                <img src="{{ asset('assets/img/pinpoint.png') }}" class="mr-2" alt=""><span class="mt-2" id="map_street_name"></span class="mt-2">
            </div>
            <input type="hidden" id="temp_id">
            <input type="hidden" id="temp_lat">
            <input type="hidden" id="temp_long">
            <input type="hidden" id="temp_state">
        </div>
    </div>
</div>
</div>

<script>
function initAutocomplete() {
    var geocoder = new google.maps.Geocoder();

    if ($('#address_map_type').val() == 'new') {
    var initAddress = new google.maps.Geocoder();
    var formAddress = $('#address_input_form').val();
    if ($('#city-state').val() !== '') {
        var formCity = $('#city-state').select2('data')['text'];
    } else {
        var formCity = 'jakarta';
    }

    initAddress.geocode( { 'address':   formAddress + ', ' + formCity + ', indonesia'}, function(results, status) {
        if (status == 'OK') {
        map.setCenter(results[0].geometry.location);
        } else {
        alert('Geocode was not successful for the following reason: ' + status);
        }
    });
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: new google.maps.LatLng(-6.169758224410621,106.83104761007766),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.LEFT_BOTTOM
            },
        fullscreenControl: false
    });
    } else {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: new google.maps.LatLng(-6.169758224410621,106.83104761007766),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.LEFT_BOTTOM
            },
        fullscreenControl: false
    });

    }


    $('<div/>').addClass('centerMarker').appendTo(map.getDiv())
    .click(function(){
        $('#editPinpoint').modal('hide');
        if ($('#address_map_type').val() == 'new') {
        $('#addAddress').modal('show');
        } else {
        $('#editAddress').modal('show');
        }
    });

    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    map.addListener('center_changed', function() {
    document.getElementById('latitude').value = map.getCenter().lat();
    document.getElementById('longitude').value = map.getCenter().lng();
    var latlng = {lat: map.getCenter().lat(), lng: parseFloat(map.getCenter().lng())};

    geocoder.geocode({
        'latLng': latlng
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
        if (results[0]) {
            $('#map_street_name').html(results[0].formatted_address);
        }
        }
    });
    });
    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
          document.getElementById('latitude').value = map.getCenter().lat();
          document.getElementById('longitude').value = map.getCenter().lng();
    });

    searchBox.addListener('places_changed', function()
    {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        var bounds = new google.maps.LatLngBounds();

        places.forEach(function(place)
        {
            if (!place.geometry) {
            console.log("Returned place contains no geometry");
            return;
            }

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

function initEditFormMap() {
    var geocoder = new google.maps.Geocoder();
    var currentLat = $('#edit_latitude').val();
    var currentLong = $('#edit_longitude').val();

    if (currentLat !== '' && currentLong !== '') {
    var currentCoor = currentLat + ',' + currentLong;
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 19,
        center: {lat: parseFloat(currentLat), lng: parseFloat(currentLong)},
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.LEFT_BOTTOM
            },
        fullscreenControl: false
    });
    } else {

    var initAddress = new google.maps.Geocoder();
    var currentCity = $('#edit_address_state').val();

    initAddress.geocode( { 'address':   currentCity + ', indonesia'}, function(results, status) {
        if (status == 'OK') {
        map.setCenter(results[0].geometry.location);
        } else {
        alert('Geocode was not successful for the following reason: ' + status);
        }
    });
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: new google.maps.LatLng(-6.169758224410621,106.83104761007766),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.LEFT_BOTTOM
            },
        fullscreenControl: false
    });
    }


    $('<div/>').addClass('centerMarker').appendTo(map.getDiv())
    .click(function(){
        $('#editPinpoint').modal('hide');
        $('#editAddress').modal('show');
    });

    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    map.addListener('center_changed', function() {
    document.getElementById('edit_latitude').value = map.getCenter().lat();
    document.getElementById('edit_longitude').value = map.getCenter().lng();
    var latlng = {lat: map.getCenter().lat(), lng: parseFloat(map.getCenter().lng())};

    geocoder.geocode({
        'latLng': latlng
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
        if (results[0]) {
            $('#map_street_name').html(results[0].formatted_address);
        }
        }
    });
    });
    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
        document.getElementById('latitude').value = map.getCenter().lat();
        document.getElementById('longitude').value = map.getCenter().lng();
    });

    searchBox.addListener('places_changed', function()
    {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        var bounds = new google.maps.LatLngBounds();

        places.forEach(function(place)
        {
            if (!place.geometry) {
            console.log("Returned place contains no geometry");
            return;
            }

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

function initEditMap() {
    var geocoder = new google.maps.Geocoder();
    var currentLat = $('#temp_lat').val();
    var currentLong = $('#temp_long').val();

    if (currentLat !== '' && currentLong !== '') {
    var currentCoor = currentLat + ',' + currentLong;
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 19,
        center: {lat: parseFloat(currentLat), lng: parseFloat(currentLong)},
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.LEFT_BOTTOM
            },
        fullscreenControl: false
    });
    } else {
        var initAddress = new google.maps.Geocoder();
        var currentCity = $('#temp_state').val();

        initAddress.geocode( { 'address':   currentCity + ', indonesia'}, function(results, status) {
            if (status == 'OK') {
            map.setCenter(results[0].geometry.location);
            } else {
            alert('Geocode was not successful for the following reason: ' + status);
            }
        });
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: new google.maps.LatLng(-6.169758224410621,106.83104761007766),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.LEFT_BOTTOM
                },
            fullscreenControl: false
        });
    }


    $('<div/>').addClass('centerMarker').appendTo(map.getDiv())
    .click(function(){
        $.ajax({
            type: 'POST',
            url: '{{ route('frontend.user.address.pinpoint.update') }}',
            data:
            {
                "id": $('#temp_id').val(),
                "lat": $('#temp_lat').val(),
                "long": $('#temp_long').val(),
                "_token" : "{{ csrf_token() }}"
            },
            success: function (respond) {
                var message = respond.message;
                if (respond.status) {
                    location.reload();
                } else {
                    swal("Error", respond.message, "error");
                }
            }
        });
        $('#editPinpoint').modal('hide');
    });

    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    map.addListener('center_changed', function() {
    document.getElementById('temp_lat').value = map.getCenter().lat();
    document.getElementById('temp_long').value = map.getCenter().lng();
    var latlng = {lat: map.getCenter().lat(), lng: parseFloat(map.getCenter().lng())};

    geocoder.geocode({
        'latLng': latlng
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
        if (results[0]) {
            $('#map_street_name').html(results[0].formatted_address);
        }
        }
    });
    });
    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
        document.getElementById('latitude').value = map.getCenter().lat();
        document.getElementById('longitude').value = map.getCenter().lng();
    });

    searchBox.addListener('places_changed', function()
    {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        var bounds = new google.maps.LatLngBounds();

        places.forEach(function(place)
        {
            if (!place.geometry) {
            console.log("Returned place contains no geometry");
            return;
            }

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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKcgmzuGrRPykWiFNS3uH5bxXG93wo264&libraries=places" async defer></script>
