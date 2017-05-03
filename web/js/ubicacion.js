var lat = 4.704009;
var lng = -74.042832;
var locationMarker;
var map;

function inicializarMapa(){
    var mapProp = {
       center: new google.maps.LatLng(lat, lng),
       zoom:6,
       mapMarker: false,
       disableDefaultUI:true,       
       zoomControl:true,
       zoomControlOptions: {style:google.maps.ZoomControlStyle.LARGE},
       mapTypeId: google.maps.MapTypeId.ROADMAP
     };

    map = new google.maps.Map(document.getElementById("map"), mapProp);

    locationMarker = new google.maps.Marker({position: new google.maps.LatLng(parseFloat(lat), parseFloat(lng)),
        map: map, draggable: true, animation: google.maps.Animation.DROP
    });

    google.maps.event.addListener(map, 'bounds_changed', function(){
        locationMarker.setPosition(map.getCenter());
    });
}

google.maps.event.addDomListener(window, 'load', inicializarMapa); 


function resizeMap() {
   if(typeof map =="undefined") return;
   setTimeout( function(){resizingMap();} , 400);
}

function resizingMap() {
   if(typeof map =="undefined") return;
   var center = map.getCenter();
   google.maps.event.trigger(map, "resize");
   map.setCenter(center); 
}