var map;
var marker;
var infowindow = new google.maps.InfoWindow();

function initMap() {
  var uluru = {lat: 4.704009, lng: -74.042832};
  map = new google.maps.Map(document.getElementById('map'), {
    zoom: 6,
    center: uluru
  });
};

initMap();

function addMark(lat, lon, name) {
  marker = new google.maps.Marker({
    position: new google.maps.LatLng(lat, lon),
    map: map
  });

  google.maps.event.addListener(marker, 'click', (function(marker, name) {
    return function() {
      infowindow.setContent(name);
      infowindow.open(map, marker);
    }
  })(marker, name));
  infowindow.open(map, marker);
  infowindow.setContent(name);
}

