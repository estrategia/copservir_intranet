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

    console.log('movio slider');
    var idTarea = $(this).attr('data-tarea');
    var progresoTarea = $(this).val();
    console.log(idTarea);
    console.log(progresoTarea);

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

    console.log('checkea');
    var idTarea = $(this).attr('data-tarea');
    console.log(idTarea);

    //si chekea
    console.log();

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
                  console.log('progreso actualizado');
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {

          }
      })
    }else {
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
                  console.log('ultimo estado');
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {

          }
      })
    }

});

/*
* peticion ajax para inactivar una tarea
*/

$(document).on('click', "a[data-role='inactivarTarea']", function() {

    console.log('click');
    var idTarea = $(this).attr('data-tarea');
    console.log(idTarea);
    var location = $(this).attr('data-location');
    if (true) {

    }

    if(confirm("¿Estas seguro de querer ocultar de manera permanente esta tarea??")) {
        console.log('envio ajax');

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
                  }
              },
              error: function(jqXHR, textStatus, errorThrown) {

              }
          })
    }

    return false;


});
