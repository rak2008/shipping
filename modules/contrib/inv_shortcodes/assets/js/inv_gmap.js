jQuery(document).ready(function ($) {
    $('.inv-gmap-shortcode').each(function () {
        var $map = $(this),
        mapid = $map.attr('id'),
        $markers = $map.find('.inv-gmap-marker');
        var type = $map.data('type') || '';
        var zoom = $map.data('zoom') || 14;
        var geocoder = new google.maps.Geocoder();
        var map;
        var markers = [];
		var infowindow = new google.maps.InfoWindow();
            
        function create_marker($marker, map) {
            var marker_position = new google.maps.LatLng($marker.data('latitude'), $marker.data('longitude'));
            var marker = new google.maps.Marker({
                position: marker_position,
                map: map,
                icon: $marker.data('icon')||'',
                animation: google.maps.Animation.DROP,
                title: $(this).data('title')
            });
            marker.setMap(map);
            var $info = $('<div class="infobox" style="width:300px;"></div>');
            if ($marker.data('image') || false) {
                $info.append('<img class="alignleft img-responsive" src="' + $marker.data('image') + '" alt="">');
            }
            if ($marker.data('title') || false) {
                $info.append('<h3 class="title"><a href="' + '#' + '">' + $marker.data('title') + '</a></h3>');
            }
            $info.append('<p style="margin-left:100px;">' + $marker.text() + '</p>');
            if ($marker.data('phone') || false) {
                $info.append('<p  style="margin-left:100px;"><span class="fa fa-phone"></span> ' + $marker.data('phone') + '</p>');
            }
            google.maps.event.addListener(marker, 'click', (function (marker) {
                return function () {
                    infowindow.setContent('<div class="infobox">' + $info.html() + '</div>');
                    infowindow.open(map, marker);
                }
            })(marker));
        }

        function initialize() {
            var mapOptions = {
                scrollwheel: false,
                zoom: zoom
            };
            var map_center = false;
            if (type == 'color') {
                mapOptions.styles = [{
                    "stylers": [{
                        "hue": Drupal.settings.drupalexp.base_color
                    }, {
                        "gamma": 1
                    }]
                }];
            }
            map = new google.maps.Map(document.getElementById(mapid), mapOptions);
            $markers.each(function (i) {
                var $this = $(this);
                if ($this.data('latitude') == '' || $this.data('longitude') == '') {
                    geocoder.geocode({
                        'address': $(this).text()
                    }, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                        	if(!map_center){
                        		map.setCenter(results[0].geometry.location);
                        		map_center = true;
                        	}
                            $this.data({
                                latitude: results[0].geometry.location.lat(),
                                longitude: results[0].geometry.location.lng()
                            });
                            create_marker($this,map);
                        }
                    });
                }else{
                	if(!map_center){
                		map.setCenter(new google.maps.LatLng($this.data('latitude'), $this.data('longitude')));
                		map_center = true;
                	}
                	create_marker($this,map);
                }
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    });
});