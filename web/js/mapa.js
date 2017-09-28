function initMap() {
    geocoder = new google.maps.Geocoder();
    var map = new google.maps.Map(document.getElementById('map'), {
//      center: {lat: -33.8688, lng: 151.2195},
      center: {lat: -0.1806532, lng: -78.46783820000002},
      zoom: 13
    });
    var input = document.getElementById('searchInput');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);

    var infowindow = new google.maps.InfoWindow();
    
//        var ll  = new google.maps.LatLng(52, 0.054);
    var marker = new google.maps.Marker({
//            position: ll,
        map: map,
        anchorPoint: new google.maps.Point(0, -29),
        draggable: true
    });

    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }
  
        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        marker.setIcon(({
            url: place.icon,
            draggable: true,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
        }));
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
    
        var address = '';
        if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }
    
        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);
      
        //Location details
        for (var i = 0; i < place.address_components.length; i++) {
            if(place.address_components[i].types[0] == 'postal_code'){
                document.getElementById('postal_code').innerHTML = place.address_components[i].long_name;
            }
            if(place.address_components[i].types[0] == 'country'){
                document.getElementById('country').innerHTML = place.address_components[i].long_name;
            }
        }
        /***************Actualizo la nueva latitud y longitud en las cajas de texto al mover el marker **********************/
                google.maps.event.addListener(marker, 'dragend', function (event) {
                     geocodePosition(marker.getPosition());
                    document.getElementById('lat').innerHTML = this.getPosition().lat();
                    document.getElementById('lon').innerHTML = this.getPosition().lng();
                    $('#geodestino-latitud').val(this.getPosition().lat());
                    $('#geodestino-longitud').val(this.getPosition().lng());
                });
                
                function geocodePosition(pos) {
                        geocoder.geocode({
                          latLng: pos
                        }, function(responses) {
                          if (responses && responses.length > 0) {
                            marker.formatted_address = responses[0].formatted_address;
                          } else {
                            marker.formatted_address = 'Cannot determine address at this location.';
                          }
                          infowindow.setContent(marker.formatted_address + "<br>coordinates: " + marker.getPosition().toUrlValue(6));
                          infowindow.open(map, marker);
                          document.getElementById('location').innerHTML = marker.formatted_address;
                          var location = document.getElementById('location').innerHTML = marker.formatted_address; 
                          $('#geodestino-lugar').val(location);
                        }); 
                }                
        /***************Fin Actualizo la nueva latitud y longitud en las cajas de texto al mover el marker **********************/

        document.getElementById('location').innerHTML = place.formatted_address;        
        document.getElementById('lat').innerHTML = place.geometry.location.lat();
        document.getElementById('lon').innerHTML = place.geometry.location.lng();
                        
//        Seteo de variables
        var lat = document.getElementById('lat').innerHTML = place.geometry.location.lat();
        var lon = document.getElementById('lon').innerHTML = place.geometry.location.lng();
        var location = document.getElementById('location').innerHTML = place.formatted_address;        
        $('#destino-latitud').val(lat);
        $('#destino-longitud').val(lon);
        $('#destino-direccion_destino').val(location);
    });
}
