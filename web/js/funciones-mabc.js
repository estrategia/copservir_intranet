//::::::::::::::::::::::
// TAREAS
//::::::::::::::::::::::

// solo deberia ser en tareas donde aparece el slider
 $( document ).ready(function() {
     $('.slider-element').slider();
 });

/*
* peticion ajax guardar el progreso del slider de una tarea
*/
$(document).on('slideStop', "input[data-role='slider-tarea']", function() {

    var idTarea = $(this).attr('data-tarea');
    var progresoTarea = $(this).val();

    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/intranet/tareas/actualizar-progreso',
        data: {idTarea: idTarea, progresoTarea: progresoTarea},
        dataType: 'json',
        beforeSend: function() {
        //    Loading.show();
        },

        complete: function(data) {
         //   Loading.hide();
        },
        success: function(data) {
            if (data.result == "ok") {
                console.log('progreso actualizado');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {

        }
    });
});

/*
* peticion ajax cuando checkea una tarea en el home
*/

$(document).on('change', "input[data-role='tarea-check']", function() {

    var idTarea = $(this).attr('data-tarea');

    //si uncheck
    if (!$(this).is(':Checked')) {


      $.ajax({
          type: 'POST',
          async: true,
          url: requestUrl + '/intranet/tareas/uncheck-home',
          data: {idTarea: idTarea},
          dataType: 'json',
          beforeSend: function() {
          //    Loading.show();
          },

          complete: function(data) {
           //   Loading.hide();
          },
          success: function(data) {

              if (data.result == "ok") {

                  $('#widget-tareas').html(data.response);
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {

          }
      });

    }

    /// si check
    if ($(this).is(':Checked')) {
      $.ajax({
          type: 'POST',
          async: true,
          url: requestUrl + '/intranet/tareas/actualizar-progreso',
          data: {idTarea: idTarea, progresoTarea: 100},
          dataType: 'json',
          beforeSend: function() {
          //    Loading.show();
          },

          complete: function(data) {
           //   Loading.hide();
          },
          success: function(data) {
              if (data.result == "ok") {
                  $('#widget-tareas').html(data.response);
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {

          }
      });

    }



});

/*
* peticion ajax para inactivar una tarea
*/

$(document).on('click', "a[data-role='inactivarTarea']", function() {


    var idTarea = $(this).attr('data-tarea');

    var location = $(this).attr('data-location');
    if (true) {

    }

    if(confirm("¿Estas seguro de querer ocultar de manera permanente esta tarea??")) {

          $.ajax({
              type: 'POST',
              async: true,
              url: requestUrl + '/intranet/tareas/eliminar',
              data: {idTarea: idTarea, location: location},
              dataType: 'json',
              beforeSend: function() {
              //    Loading.show();
              },

              complete: function(data) {
               //   Loading.hide();
              },
              success: function(data) {
                  if (data.result == "ok") {
                      console.log('tarea inactiva');
                      $('#widget-tareas').html(data.response);
                      //$('#widget-tareas').html(data.response);
                  }
              },
              error: function(jqXHR, textStatus, errorThrown) {

              }
          })
    }

    return false;
});
