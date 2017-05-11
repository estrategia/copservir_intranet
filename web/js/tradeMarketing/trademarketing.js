/**
 * Muestra las observaciones pertenecientes a una variable determinada
 */
$(document).on('click', 'button[data-accion="ver-observaciones"]', function () {
  var idAsignacion = $(this).attr('data-asignacion'),
      idVariable = $(this).attr('data-variable'),
      contenidoHtml = '';
  $.ajax({
    type: 'POST',
    dataType : 'json',
    async: true,
    url: requestUrl + '/trademarketing/asignacion-punto-venta/listar-observaciones',
    data: {idVariable: idVariable, idAsignacion: idAsignacion},
    beforeSend: function() {
      // Loading.show();
    },
    success: function(data) {
      if (data.length == 0) {
        contenidoHtml = '<li><p>Sin observaciones</p></li>';
      } else {
        for (var i = 0; i < data.length; i++) {
          var observacion = data[i];
          contenidoHtml += '<li><p>'+ observacion.descripcion +'</p></li>';
        }
      }
      $('#listado-observaciones .modal-body #listado').html(contenidoHtml);
      $('#listado-observaciones').modal('show');
      // Loading.hide();
    },
    error: function(data) {
      alert('Error, intente de nuevo');
      // Loading.hide();
    }
  });
  return false;
});