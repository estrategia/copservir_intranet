//::::::::::::::::::::::
// TAREAS
//::::::::::::::::::::::

/**
* peticion ajax guardar el progreso del slider de una tarea
* @param idTarea, progresoTarea
* @return data.result = json donde se especifica si todo se realizo bien,
*/
$(document).on('slideStop', "input[data-role='slider-tarea']", function() {

    var idTarea = $(this).attr('data-tarea');
    var progresoTarea = $(this).val();

    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/intranet/tareas/actualizar-progreso',
        data: {idTarea: idTarea, progresoTarea: progresoTarea, flagHome: false},
        dataType: 'json',
        beforeSend: function() {
          $('body').showLoading()
        },

        complete: function(data) {
          $('body').hideLoading();
        },
        success: function(data) {
            if (data.result == "ok") {
                //console.log('progreso actualizado');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
           $('body').hideLoading();
        }
    });
});

/**
* peticion ajax cuando checkea una tarea en el home
* @param idTarea
* @return data.result = json donde se especifica si todo se realizo bien,
          data.response = html para renderizar las tareas del home
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
            $('body').showLoading()
          },

          complete: function(data) {
             $('body').hideLoading();
          },
          success: function(data) {

              if (data.result == "ok") {

                  $('#widget-tareas').html(data.response);
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              $('body').hideLoading();
          }
      });

    }

    /// si check
    if ($(this).is(':Checked')) {
      $.ajax({
          type: 'POST',
          async: true,
          url: requestUrl + '/intranet/tareas/actualizar-progreso',
          data: {idTarea: idTarea, progresoTarea: 100, flagHome: true},
          dataType: 'json',
          beforeSend: function() {
            $('body').showLoading()
          },

          complete: function(data) {
             $('body').hideLoading();
          },
          success: function(data) {
              if (data.result == "ok") {
                  $('#widget-tareas').html(data.response);
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              $('body').hideLoading();
          }
      });
    }
});

/**
* peticion ajax para inactivar una tarea
* @param idTarea, location = indica de donde se genera la peticion si de la vista listar =>no se manda valor,  del home => 1
* @return data.result = json donde se especifica si todo se realizo bien,
          data.response = html para renderizar las tareas
*/

$(document).on('click', "a[data-role='inactivarTarea']", function() {


    var idTarea = $(this).attr('data-tarea');
    var location = $(this).attr('data-location');

    if(confirm("¿Estas seguro de querer ocultar de manera permanente esta tarea??")) {

          $.ajax({
              type: 'POST',
              async: true,
              url: requestUrl + '/intranet/tareas/eliminar',
              data: {idTarea: idTarea, location: location},
              dataType: 'json',
              beforeSend: function() {
                $('body').showLoading()
              },

              complete: function(data) {
                 $('body').hideLoading();
              },
              success: function(data) {
                  if (data.result == "ok") {
                      //console.log('tarea inactiva');
                      $('#widget-tareas').html(data.response);
                      //$('#widget-tareas').html(data.response);
                  }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  $('body').hideLoading();
              }
          })
    }

    return false;
});

//::::::::::::::::::::::
// CONTENIDO EMERGENTE INDEX
//::::::::::::::::::::::

/**
* Peticion para deshabilitar el modal que sale en el index cuando me logueo
* @param idPopup,
* @return data.result = json donde se especifica si todo se realizo bien,
*/

$(document).on('click', "button[data-role='inactiva-popup']", function() {

      var idPopup = $(this).attr('data-contenido');

      $.ajax({
          type: 'POST',
          async: true,
          url: requestUrl + '/intranet/contenido-emergente/inactiva-contenido-emergente',
          data: {idPopup: idPopup},
          dataType: 'json',
          beforeSend: function() {
            $('body').showLoading()
          },

          complete: function(data) {
             $('body').hideLoading();
          },
          success: function(data) {
              if (data.result == "ok") {
                  //console.log('popup inactiva');
                  $('#widget-popup').modal('hide');
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              $('body').hideLoading();
          }
      })
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
          data.response = html para renderizar el modal con el formulario para buscar amigos
*/

$(document).on('click', "button[data-role='widget-enviarAmigo']", function() {

  var idClasificado = $(this).attr('data-clasificado');
  $.ajax({
      type: 'GET',
      async: true,
      url: requestUrl + '/intranet/usuario/modal-amigos?idClasificado='+idClasificado,
      dataType: 'json',
      beforeSend: function() {
        $('body').showLoading()
      },

      complete: function(data) {

         $('body').hideLoading();
         //$("#widget-enviarAmigo").remove();
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
          $('body').hideLoading();
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

        $('body').showLoading()
      },

      complete: function(data) {
         $('body').hideLoading();
      },
      success: function(data) {
          if (data.result == "ok") {
              $("#widget-enviarAmigo").modal('hide');
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          $('body').hideLoading();
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
                      $('#select2-agregaCargos-container').attr('title','');
                      $('#select2-agregaCargos-container').text('');
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
* peticion ajax para agregar un cargo a un grupo de interes
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
                  $('#select2-agregaCargos-container').attr('title','');
                  $('#select2-agregaCargos-container').text('');
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

//::::::::::::::::::::::
// OFERTAS LABORALES
//::::::::::::::::::::::

/**
* peticion ajax para eliminar un destino de una oferta laboral
* @param none
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html para renderizar la grilla de los destinos
*/
$(document).on('click', "a[data-role='eliminarDestino']", function() {
  console.log('click');

    var idOferta = $(this).attr('data-oferta');
    var idCiudad = $(this).attr('data-ciudad');
    var idGrupo = $(this).attr('data-grupo');

    if(confirm("¿Estas seguro de querer eliminar?")) {

          $.ajax({
              type: 'POST',
              async: true,
              url: requestUrl + '/intranet/ofertas-laborales/eliminar-oferta-destino',
              data: {idCiudad: idCiudad, idGrupo: idGrupo, idOferta: idOferta},
              dataType: 'json',
              beforeSend: function() {
              //    Loading.show();
                    $('body').showLoading();
                    $('#listaOfertas').remove();
              },

              complete: function(data) {
                   //   Loading.hide();
                   $('body').hideLoading();
              },
              success: function(data) {
                  if (data.result == "ok") {

                      $('#select2-Grupo_-container').attr('title','');
                      $('#select2-Grupo_-container').text('');
                      $('#select2-ciudad_-container').attr('title','');
                      $('#select2-ciudad_-container').text('');
                      $('#destinosOfertas').append(data.response);
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
* peticion ajax para agregar un cargo a un grupo de interes
* @param none
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html para renderizar el modal
*/
$(document).on('click', "a[data-role='agregar-destino-oferta']", function() {

    var form = $("#formEnviaDestinosOferta");

    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/intranet/ofertas-laborales/agrega-destino-oferta',
        data: form.serialize(),
        dataType: 'json',
        beforeSend: function() {
        //    Loading.show();
              $('body').showLoading();
              $('#listaOfertas').remove();
        },

        complete: function(data) {
         //   Loading.hide();
            $('body').hideLoading();
        },
        success: function(data) {
            if (data.result == "ok") {
                //console.log('progreso actualizado');
                if (data.result == "ok") {
                  $('#select2-Grupo_-container').attr('title','');
                  $('#select2-Grupo_-container').text('');
                  $('#select2-ciudad_-container').attr('title','');
                  $('#select2-ciudad_-container').text('');
                  $('#destinosOfertas').append(data.response);
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('body').hideLoading();
        }
    });

    return false;
});


/**
* peticion ajax para mostrar el contenido de las plantillas en las ofertas laborales
* @param id = identificador de la oferta laboral
* @return retorna el contenido de la plantilla
*/
function getPlantilla(id) {
  $.get( requestUrl +'/intranet/informacion-contacto-oferta/plantilla', { id: id } )
      .done(function( data ) {
          console.log(data);
          if (data.result === 'ok') {
            console.log(data.response);
            $( "#contenido-plantilla" ).append( data.response );
            $( "#plantilla" ).show();
          }

      }
  );
}

/**
* peticion ajax para mostrar la plantilla de una oferta en un popove en el home
* @param idOferta
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html de la platilla
*/
$(document).on('click', "a[data-role='contacto-oferta']", function() {

    var idOferta = $(this).attr('data-oferta');
    var elemento = $(this);
    var contenido = elemento.attr('data-content')
    if (contenido === '' || contenido === undefined) {
        $.ajax({

            type: 'GET',
            async: true,
            url: requestUrl +'/intranet/informacion-contacto-oferta/plantilla?id='+idOferta,
            dataType: 'json',
            beforeSend: function() {
            //    Loading.show();
                  $('body').showLoading();
            },

            complete: function(data) {
             //   Loading.hide();
                $('body').hideLoading();
            },
            success: function(data) {
                if (data.result == "ok") {
                  elemento.attr('data-content',
                      ''+data.response);

                  elemento.popover('toggle');
                  elemento.popover('show');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('body').hideLoading();
            }
        });
     }

    return false;
});

//::::::::::::::::::::::
// CATEGORIA DOCUMENTO
//::::::::::::::::::::::

/**
* peticion ajax para renderizar el modal con el formulario para crear un modelo CategoriaDocumento
* @param categoriaPadre = indica si tiene una categoria padre s
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html del modal
*/
$(document).on('click', "button[data-role='categoria-crear']", function() {

  console.log('click crear');
  var categoriaPadre = $(this).attr('data-padre');

  $.ajax({
      type: 'POST',
      async: true,
      url: requestUrl + '/intranet/categoria-documento/render-crear-categoria',
      data: {categoriaPadre: categoriaPadre},
      dataType: 'json',
      beforeSend: function() {
        $("#widget-categoria").remove();
        $('body').showLoading()
      },

      complete: function(data) {
         $('body').hideLoading();
      },
      success: function(data) {
          if (data.result == "ok") {
            $('body').append(data.response);
            $("#widget-categoria").modal("show");
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          $('body').hideLoading();
      }
  });

  return false;
});

/**
* peticion ajax para renderizar el modal con el formulario para editar un modelo CategoriaDocumento
* @param idCategoria = indica la categoria que se va a editar
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html del modal
*/
$(document).on('click', "button[data-role='categoria-editar']", function() {

  console.log('click editar');

  var idCategoria = $(this).attr('data-categoria');

  $.ajax({
      type: 'POST',
      async: true,
      url: requestUrl + '/intranet/categoria-documento/render-editar-categoria?id='+idCategoria,
      //data: form.serialize(),
      dataType: 'json',
      beforeSend: function() {
        $("#widget-categoria").remove();
        $('body').showLoading()
      },

      complete: function(data) {
         $('body').hideLoading();
      },
      success: function(data) {
          if (data.result == "ok") {
            $('body').append(data.response);
            $("#widget-categoria").modal("show");
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          $('body').hideLoading();
      }
  });

  return false;
});

/**
* peticion ajax para guardar un nuevo modelo CategoriaDocumento
* @param
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html de la vista
*/
$(document).on('click', "button[data-role='guardar-categoria']", function() {

  console.log('click guardar');
  var form = $("#formCategoria");

  $.ajax({
      type: 'POST',
      async: true,
      url: requestUrl + '/intranet/categoria-documento/crear-categoria',
      data: form.serialize(),
      dataType: 'json',
      beforeSend: function() {

        $('body').showLoading()
      },

      complete: function(data) {
         $('body').hideLoading();
      },
      success: function(data) {
          if (data.result == "ok") {
            $("#menu-categoria-documento").remove();
            $('#container').append(data.response);
            $("#widget-categoria").modal("hide");
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          $('body').hideLoading();
      }
  });

  return false;
});


/**
* peticion ajax para guardar un modelo existente CategoriaDocumento
* @param idCategoria = indica cual es la categoria a editar
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html de la vista
*/
$(document).on('click', "button[data-role='actualizar-categoria']", function() {

  console.log('click editar');

  var idCategoria = $(this).attr('data-categoria');
  var form = $("#formCategoria");

  $.ajax({
      type: 'POST',
      async: true,
      url: requestUrl + '/intranet/categoria-documento/actualizar-categoria?id='+idCategoria,
      data: form.serialize(),
      dataType: 'json',
      beforeSend: function() {

        $('body').showLoading()
      },

      complete: function(data) {
         $('body').hideLoading();
      },
      success: function(data) {
          if (data.result == "ok") {
            $("#menu-categoria-documento").remove();
            $('#container').append(data.response);
            $("#widget-categoria").modal("hide");
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          $('body').hideLoading();
      }
  });

  return false;
});

/**
* peticion ajax para renderizar el modal con el formulario para relacionar una CategoriaDocumento y un Documento
* @param
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html del modal
*/
$(document).on('click', "button[data-role='relaciona-documento']", function() {

  console.log('click relacionar');

  var idCategoria = $(this).attr('data-categoria');

  $.ajax({
      type: 'POST',
      async: true,
      url: requestUrl + '/intranet/categoria-documento/render-relacionar-documento',
      data: {idCategoria: idCategoria},
      dataType: 'json',
      beforeSend: function() {
        $("#widget-relaciona-documento").remove();
        $('body').showLoading()
      },

      complete: function(data) {
         $('body').hideLoading();
      },
      success: function(data) {
          if (data.result == "ok") {
            $('body').append(data.response);
            $("#widget-relaciona-documento").modal("show");
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          $('body').hideLoading();
      }
  });

  return false;
});

/**
* peticion ajax para guardar un modelo CategoriaDocumentoDetalle = relacion entre un CategoriaDocumento y Documento
* @param
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html del modal
*/
$(document).on('click', "button[data-role='guardar-relacion']", function() {

  console.log('click guardar relacion');

  //var idCategoria = $(this).attr('data-categoria');
  var form = $("#formRelacionaCategoria");

  $.ajax({
      type: 'POST',
      async: true,
      url: requestUrl + '/intranet/categoria-documento/guardar-relacion-documento',
      data: form.serialize(),
      dataType: 'json',
      beforeSend: function() {

        $('body').showLoading()
      },

      complete: function(data) {
         $('body').hideLoading();
      },
      success: function(data) {
          if (data.result == "ok") {
            $("#menu-categoria-documento").remove();
            $('#container').append(data.response);
            $("#widget-relaciona-documento").modal("hide");
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          $('body').hideLoading();
      }
  });

  return false;
});


/**
* peticion ajax eliminar la relacion entre una CategoriaDocumento y un Documento
* @param
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html de la vista
*/
$(document).on('click', "button[data-role='no-relaciona-documento']", function() {

  console.log('click no relaciona');

  var idCategoria = $(this).attr('data-categoria');
  var idDocumento = $(this).attr('data-documento');

  $.ajax({
      type: 'POST',
      async: true,
      url: requestUrl + '/intranet/categoria-documento/eliminar-relacion-documento',
      data: {idCategoria: idCategoria, idDocumento: idDocumento},
      dataType: 'json',
      beforeSend: function() {

        $('body').showLoading()
      },

      complete: function(data) {
         $('body').hideLoading();
      },
      success: function(data) {
          if (data.result == "ok") {
            $("#menu-categoria-documento").remove();
            $('#container').append(data.response);
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          $('body').hideLoading();
      }
  });

  return false;
});


/**
* funcion con peticion ajax donde se pid el el documento para crear su plantilla
* @param id = identificador del documento
* @return retorna el contenido de la plantilla
*/
function getPlantillaDocumento(id) {
  console.log(id);
  $.get( requestUrl +'/intranet/categoria-documento/plantilla-documento', { idDocumento: id } )
      .done(function( data ) {

          if (data.result === 'ok') {

            $( "#contenido-plantilla" ).append( data.response );
          }
      });
}

//---------------------------------
// funcion que por ahora redirige a el detalle del documento
$(document).on('click', "a[data-role='hola']", function() {
  console.log('click');
  var url = $(this).attr('href');
  window.location.replace(url);
});

// ------------

/**
* Acciones que se ejecutan cuando el navegador cargue los scripts
* @param none
* @return none
*/
$( document ).ready(function() {

  // carousel cumpleaños
  $("#owl-Cumpleaños").owlCarousel({
    //margin:10,
    items: 4,
    autoWidth: true,
    autoplay: true,
    autoplayTimeout:1000,
    autoplayHoverPause:true,
    responsiveClass:true,
    loop:true,
  });

  // carousel aniversarios
  $("#owl-Aniversarios").owlCarousel({
    //margin:10,
    items: 4,
    autoWidth: true,
    autoplay: true,
    autoplayTimeout:1000,
    autoplayHoverPause:true,
    responsiveClass:true,
    loop:true,
  });

  // carousel portales
  $("#owl-example").owlCarousel();

  // javascript para que se busque una noticia cuando presiona enter
  $('#busqueda').keypress(function(event) {

        if (event.which == 13) {
            event.preventDefault();
            $('#formBuscadorNoticias').submit();
        }
    });

});
