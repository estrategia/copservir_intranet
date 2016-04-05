//::::::::::::::::::::::
// TAREAS
//::::::::::::::::::::::

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
                //console.log('progreso actualizado');
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

/**
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
                      //console.log('tarea inactiva');
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

//::::::::::::::::::::::
// POPUP INDEX
//::::::::::::::::::::::

/**
* Peticion para deshabilitar el modal
*/

$(document).on('click', "button[data-role='inactiva-popup']", function() {

      var idPopup = $(this).attr('data-contenido');
      //console.log('click desactivar modal');
      //console.log(idPopup);

      $.ajax({
          type: 'POST',
          async: true,
          url: requestUrl + '/intranet/sitio/inactiva-popup',
          data: {idPopup: idPopup},
          dataType: 'json',
          beforeSend: function() {
          //    Loading.show();
          },

          complete: function(data) {
           //   Loading.hide();
          },
          success: function(data) {
              if (data.result == "ok") {
                  //console.log('popup inactiva');
                  $('#widget-popup').modal('hide');
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
          }
      })
});

//::::::::::::::::::::::
// BUSQUEDA NOTICIAS
//::::::::::::::::::::::

/**
* javascript para que se busque una noticia cuando presiona enter
*/
$( document ).ready(function() {

  $('#busqueda').keypress(function(event) {

        if (event.which == 13) {
            event.preventDefault();
            $('#formBuscadorNoticias').submit();
        }
    });

});

/**
* funcion para mapear la imagen segun su json
* @param jsonGrafica = json con la imagen mapeada, patron = patron de busqueda, valorGrafica = valores de la grafica, flag = bandera que indica los parametros de la url
* @return pega la el html de la imagen mapeada en el contenedor
*/
function makeMap(jsonGrafica, patron, valorGrafica, flag) {

  var a = ''; // para referenciar si la url tiene año
  var m = ''; // para referenciar si la url tiene mes
  var d = ''; // para referenciar si la url tiene dia
  var tamValorGrafica = valorGrafica.length;
  var mapBox = $('.map-img');
  var jsonObj = false;
  var mapString = "";
  jsonObj = jsonGrafica;

  if (typeof JSON != 'object') {
    alert("Please enter a valid JSON response string.");
    return;
  } else if (!jsonObj.chartshape) {
    alert("No map elements");
    return;
  }

  mapString = "<map name='archivo-timeline'>";
  var area = false;
  var chart = jsonObj.chartshape;
  var count = 0;
  for (var i = 0; i < chart.length; i++) {

    area = chart[i];

    if (i>tamValorGrafica) {

      if (flag === 'a') {
          a = valorGrafica[count]['etiqueta'];
      }

      if (flag === 'am') {
          a = valorGrafica[count]['anio'];
          m = valorGrafica[count]['etiqueta'];
      }

      if (flag === 'amd') {
          a = valorGrafica[count]['anio'];
          m = valorGrafica[count]['mes'];
          d = valorGrafica[count]['etiqueta'];
      }

      mapString += "\n  <area name='"  + area.name + "' shape='"  + area.type
        + "' coords='" + area.coords.join(",") + "' href=\""+requestUrl+"/intranet/contenido/busqueda?busqueda="+patron+"&a="+a+"&m="+m+"&d="+d+"\"  title=''>";

      count ++;

    }else{

      mapString += "\n  <area name='"  + area.name + "' shape='"  + area.type
        + "' coords='" + area.coords.join(",") + "' title=''>";
    }
  }
  mapString += "\n</map>";
  mapBox.append(mapString);
}

/**
* funcion con una peticion ajax para redenrizar el modal donde se seleccionaran los amigos a quienes deseo compartir el clasificado
* @param none
* @return data.result = json donde se especifica si todo se realizo bien,
          data.response = html para renderizar el modal con el formulario para buscar amigos s
*/

$(document).on('click', "button[data-role='widget-enviarAmigo']", function() {

  var idClasificado = $(this).attr('data-clasificado');
  $.ajax({
      type: 'GET',
      async: true,
      url: requestUrl + '/intranet/usuario/modal-amigos?idClasificado='+idClasificado,
      dataType: 'json',
      beforeSend: function() {
      //    Loading.show();
      },

      complete: function(data) {
       //   Loading.hide();
      },
      success: function(data) {
          if (data.result == "ok") {
              //console.log('progreso actualizado');
              if (data.result == "ok") {
                $('body').append(data.response);
                $("#widget-enviarAmigo").modal("show");
              }
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {

      }
  });

});


/**
* funcion con una peticion ajax para registrar a que amigos se envia el clasificado y su respectiva notificaion
* @param none
* @return data.result = json donde se especifica si todo se realizo bien
*/
$(document).on('click', "button[data-role='enviar-amigos']", function() {
  //console.log('click');
  //$('#formEnviarAmigo').submit();
  var form = $("#formEnviarAmigo");

  $.ajax({
      type: 'POST',
      async: true,
      url: requestUrl + '/intranet/contenido/enviar-amigo',
      data: form.serialize(),
      dataType: 'json',
      beforeSend: function() {
      //    Loading.show();
      },

      complete: function(data) {
       //   Loading.hide();
      },
      success: function(data) {
          if (data.result == "ok") {
              $("#widget-enviarAmigo").modal('hide');
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {

      }
  });

  return false;
});



//::::::::::::::::::::::
// GRUPOS DE INTERES
//::::::::::::::::::::::

/**
* peticion ajax para eliminar un cargo de un frupo de interes
* @param none
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html para renderizar la grilla de los cargos de nuevo
*/
$(document).on('click', "a[data-role='eliminarCargoGrupo']", function() {

    var idCargo = $(this).attr('data-cargo');
    var idGrupo = $(this).attr('data-grupo');

    if(confirm("¿Estas seguro de querer eliminar este cargo de este grupo de interes?")) {

          $.ajax({
              type: 'POST',
              async: true,
              url: requestUrl + '/intranet/grupo-interes/eliminar-cargo',
              data: {idCargo: idCargo, idGrupo: idGrupo},
              dataType: 'json',
              beforeSend: function() {
              //    Loading.show();
                    $('body').showLoading();
                    $('#listaCargos').remove();
              },

              complete: function(data) {
                   //   Loading.hide();
                   $('body').hideLoading();
              },
              success: function(data) {
                  if (data.result == "ok") {
                      $('#cargosGrupo').append(data.response);
                  }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  $('body').hideLoading();
              }
          })

    }

    return false;
});

/**
* peticion ajax para
* @param none
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html para renderizar el modal
*/

$(document).on('click', "a[data-role='agregar-cargo']", function() {
    console.log('dio click');

    var idGrupo = $(this).attr('data-grupo');
    var form = $("#formEnviaCargos");

    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/intranet/grupo-interes/agrega-cargo?idGrupo='+idGrupo,
        data: form.serialize(),
        dataType: 'json',
        beforeSend: function() {
        //    Loading.show();
              $('body').showLoading();
              $('#listaCargos').remove();
        },

        complete: function(data) {
         //   Loading.hide();
            $('body').hideLoading();
        },
        success: function(data) {
            if (data.result == "ok") {
                //console.log('progreso actualizado');
                if (data.result == "ok") {
                  $('#cargosGrupo').append(data.response);
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('body').hideLoading();
        }
    });

    return false;
});
