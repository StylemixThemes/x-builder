"use strict";

document.body.addEventListener("stm_gmap_api_loaded", initMap, false);
var map = '';
var latlng = '';
var default_marker_icon = 'https://via.placeholder.com/1x1';

function initMap(e) {
  var $ = jQuery;
  $('.x_gmap').each(function () {
    var $this = $(this);
    var module_id = $this.data('module');
    var zoom = parseFloat(window[module_id].zoom);
    var lat = parseFloat(window[module_id].lat);
    var lng = parseFloat(window[module_id].lng);
    var offset_x = window[module_id].offset_x ? parseFloat(window[module_id].offset_x) : 0;
    var offset_y = window[module_id].offset_y ? parseFloat(window[module_id].offset_y) : 0;
    latlng = new google.maps.LatLng(lat, lng);
    var place = {
      lat: lat,
      lng: lng
    };
    map = new google.maps.Map(document.getElementById(module_id), {
      zoom: zoom,
      scrollwheel: false,
      center: place,
      disableDefaultUI: true,
      styles: [{
        "featureType": "all",
        "elementType": "labels.text.fill",
        "stylers": [{
          "saturation": 36
        }, {
          "lightness": 40
        }, {
          "hue": "#3900ff"
        }, {
          "gamma": "0.22"
        }]
      }, {
        "featureType": "all",
        "elementType": "labels.text.stroke",
        "stylers": [{
          "visibility": "on"
        }, {
          "color": "#000000"
        }, {
          "lightness": 16
        }]
      }, {
        "featureType": "all",
        "elementType": "labels.icon",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "administrative",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#000000"
        }, {
          "lightness": 20
        }]
      }, {
        "featureType": "administrative",
        "elementType": "geometry.stroke",
        "stylers": [{
          "color": "#000000"
        }, {
          "lightness": 17
        }, {
          "weight": 1.2
        }]
      }, {
        "featureType": "administrative",
        "elementType": "labels",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "administrative.country",
        "elementType": "all",
        "stylers": [{
          "visibility": "simplified"
        }]
      }, {
        "featureType": "administrative.country",
        "elementType": "geometry",
        "stylers": [{
          "visibility": "simplified"
        }]
      }, {
        "featureType": "administrative.country",
        "elementType": "labels.text",
        "stylers": [{
          "visibility": "simplified"
        }]
      }, {
        "featureType": "administrative.province",
        "elementType": "all",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "administrative.locality",
        "elementType": "all",
        "stylers": [{
          "visibility": "simplified"
        }, {
          "saturation": "-100"
        }, {
          "lightness": "30"
        }]
      }, {
        "featureType": "administrative.neighborhood",
        "elementType": "all",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "administrative.land_parcel",
        "elementType": "all",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [{
          "visibility": "simplified"
        }, {
          "gamma": "0.00"
        }, {
          "lightness": "74"
        }]
      }, {
        "featureType": "landscape",
        "elementType": "geometry",
        "stylers": [{
          "color": "#000000"
        }, {
          "lightness": 20
        }]
      }, {
        "featureType": "landscape.man_made",
        "elementType": "all",
        "stylers": [{
          "lightness": "3"
        }]
      }, {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "poi",
        "elementType": "geometry",
        "stylers": [{
          "color": "#000000"
        }, {
          "lightness": 21
        }]
      }, {
        "featureType": "road",
        "elementType": "geometry",
        "stylers": [{
          "visibility": "simplified"
        }]
      }, {
        "featureType": "road.highway",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#000000"
        }, {
          "lightness": 17
        }]
      }, {
        "featureType": "road.highway",
        "elementType": "geometry.stroke",
        "stylers": [{
          "color": "#000000"
        }, {
          "lightness": 29
        }, {
          "weight": 0.2
        }]
      }, {
        "featureType": "road.arterial",
        "elementType": "geometry",
        "stylers": [{
          "color": "#000000"
        }, {
          "lightness": 18
        }]
      }, {
        "featureType": "road.local",
        "elementType": "geometry",
        "stylers": [{
          "color": "#000000"
        }, {
          "lightness": 16
        }]
      }, {
        "featureType": "transit",
        "elementType": "geometry",
        "stylers": [{
          "color": "#000000"
        }, {
          "lightness": 19
        }]
      }, {
        "featureType": "water",
        "elementType": "geometry",
        "stylers": [{
          "color": "#000000"
        }, {
          "lightness": 17
        }]
      }]
    });
    new google.maps.Marker({
      position: place,
      map: map,
      icon: default_marker_icon
    });

    if (offset_x || offset_y) {
      google.maps.event.addListenerOnce(map, "projection_changed", function () {
        stmOffsetCenter(map, latlng, offset_x, offset_y);
      });
    }
  });
  google.maps.event.addListenerOnce(map, 'tilesloaded', function () {
    var $map_marker = $('body').find('img[src="' + default_marker_icon + '"]');
    if ($map_marker.hasClass('stm_map_marker')) return true;
    $map_marker.addClass('stm_map_marker');
    $map_marker.closest('div').addClass('stm_map_marker_holder');
    $('<div class="x_map_marker sbc_a sbc_b"><div class="sbc sbc_a sbc_b"></div></div>').insertAfter(".stm_map_marker");
  });
}

function stmOffsetCenter(map, latlng, offsetx, offsety) {
  var scale = Math.pow(2, map.getZoom());
  var worldCoordinateCenter = map.getProjection().fromLatLngToPoint(latlng);
  var pixelOffset = new google.maps.Point(offsetx / scale || 0, offsety / scale || 0);
  var worldCoordinateNewCenter = new google.maps.Point(worldCoordinateCenter.x - pixelOffset.x, worldCoordinateCenter.y + pixelOffset.y);
  var newCenter = map.getProjection().fromPointToLatLng(worldCoordinateNewCenter);
  map.setCenter(newCenter);
}