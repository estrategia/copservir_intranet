$('.ad-gallery').adGallery({
    loader_image: requestUrl + '/libs/visita-medica/ad-gallery/loader.gif',
    update_window_hash: false,
    width: 400,
    height: 300,
    thumb_opacity: 0.7,
    hooks: {
        displayDescription: function(image) {}
    }
});

$('[data-toggle="tooltip"]').tooltip();

// $(document).ready(function(){
$('#help-ubicacion').Chocolat();
$('#help-consulta').Chocolat();
$('#help-reportes').Chocolat();
$('#help-mi-cuenta').Chocolat();
$('#help-contacto').Chocolat();
// });

function crearSelectSectores(sectores) {
    var options = '<select style="width: 100%;" id="sector-selector" onchange="centrarMapaSector()">';
    options += "<option value=''> Selecciona un sector </option>";
    for (var i = sectores.length - 1; i >= 0; i--) {
      sector = sectores[i];
      options += "<option value="+ sector.codigoSector +" data-latitud-sector="+ sector.latitudGoogle +" data-longitud-sector="+ sector.longitudGoogle +"> " + sectores[i].nombreSector + " </option>";
    }
    options += '</select>';
    return options;
  }

function centrarMapaSector() {
  var latitud = $('#sector-selector option:selected').data('latitud-sector');
  var longitud = $('#sector-selector option:selected').data('longitud-sector');
  // console.log(latitud);
  // console.log(longitud);
  // console.log($('#sector-selector').val());
  map.setCenter(new google.maps.LatLng(parseFloat(latitud), parseFloat(longitud)));
  map.setZoom(12);
}
$(document).ready(function () {
  $('#busqueda-results').dataTable({
    searching: false,
    info: true,
    lengthChange: true,
    language: {
      lengthMenu: "Mostrando _MENU_ elementos",
      info: "Mostrando _START_ a _END_ de _TOTAL_ elementos",
      paginate : {
        previous: "Anterior",
        next : "Siguiente"
      }
    }
  });
});