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
* funcion con una peticion ajax para redenrizar el modal donde se seleccionaran los amigos a
* quienes deseo compartir el clasificado
* @param idClasificado
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
* @param datos formulario
* @return data.result = json donde se especifica si todo se realizo bien
*/
$(document).on('click', "button[data-role='enviar-amigos']", function() {

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
* peticion ajax para eliminar un cargo de un grupo de interes
* @param idCargo, idGrupo
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
* @param idGrupo, datos formulario
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html para renderizar el modal
*/

$(document).on('click', "a[data-role='agregar-cargo']", function() {

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
* @param idOferta, idCiudad, idGrupo
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html para renderizar la grilla de los destinos
*/
$(document).on('click', "a[data-role='eliminarDestino']", function() {

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
* peticion ajax para agregar destino  a una oferta laboral
* @param datos del formulario
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
          $('#destinosOfertas').append(data.response);
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
    if (data.result === 'ok') {
      $( "#contenido-plantilla" ).append( data.response );
      $( "#plantilla" ).show();
    }
  }
);
}

/**
* peticion ajax para mostrar la lista de permisos que tiene un rol cuando lo seleccionan
* @param id = identificador de la oferta laboral
* @return retorna el contenido de la plantilla
*/
function getListaPermisos(nombreRol) {

  if (nombreRol) {
    $.get( requestUrl +'/intranet/sitio/render-lista-permisos', { nombreRol: nombreRol } )
    .done(function( data ) {
      if (data.result === 'ok') {
        $( "#lista-permisos" ).append( data.response );
      }
    });
  }

}

/**
* peticion ajax para mostrar la plantilla de una oferta en un popover en el home, si la peticion ya se hizo no la hace mas
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
* @param categoriaPadre
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html del modal
*/
$(document).on('click', "button[data-role='categoria-crear']", function() {

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
* @param idCategoria
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html del modal
*/
$(document).on('click', "button[data-role='categoria-editar']", function() {

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
* @param datos del formulario
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html de la vista
*/
$(document).on('click', "button[data-role='guardar-categoria']", function() {

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
* peticion ajax para actualizar un modelo existente CategoriaDocumento
* @param idCategoria
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html de la vista
*/
$(document).on('click', "button[data-role='actualizar-categoria']", function() {

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
* @param idCategoria
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html del modal
*/
$(document).on('click', "button[data-role='relaciona-documento']", function() {

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
* @param datos formulario
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html del modal
*/
$(document).on('click', "button[data-role='guardar-relacion']", function() {

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
* @param idCategoria, idDocumento = identificadores de los elemntos a relacionar
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html de la vista
*/
$(document).on('click', "button[data-role='no-relaciona-documento']", function() {

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
* funcion con peticion ajax donde se pide el documento para crear su plantilla
* @param id = identificador del documento
* @return retorna el contenido de la plantilla
*/
function getPlantillaDocumento(id) {

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
  var url = $(this).attr('href');
  window.location.replace(url);
});

//::::::::::::::::::::::
// MENU
//::::::::::::::::::::::

/**
* peticion ajax para renderizar el modal con el formulario para crear un modelo Menu
* @param idPadre
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html del modal
*/
$(document).on('click', "button[data-role='opcion-menu-render-crear']", function() {

  var idPadre = $(this).attr('data-padre');
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/sitio/render-crear-opcion-menu',
    data: {idPadre: idPadre},
    dataType: 'json',
    beforeSend: function() {
      $("#widget-opcion-menu").remove();
      $('body').showLoading()
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $('body').append(data.response);
        $("#widget-opcion-menu").modal("show");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

/**
* peticion ajax para renderizar el modal con el formulario para editar un modelo Menu
* @param idMenu
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html del modal
*/
$(document).on('click', "button[data-role='opcion-menu-render-actualizar']", function() {

  var idMenu = $(this).attr('data-opcion');
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/sitio/render-editar-opcion-menu?id='+idMenu,
    dataType: 'json',
    beforeSend: function() {
      $("#widget-opcion-menu").remove();
      $('body').showLoading()
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $('body').append(data.response);
        $("#widget-opcion-menu").modal("show");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

/**
* peticion ajax para guardar un nuevo modelo Menu
* @param datos del formulario
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html de la vista
*/
$(document).on('click', "button[data-role='guardar-opcion-menu']", function() {

  var form = $("#formMenu");
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/sitio/crear-opcion-menu',
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
        $("#menu").remove();
        $('#container').append(data.response);
        $("#widget-opcion-menu").modal("hide");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

/**
* peticion ajax para actualizar un modelo existente Menu
* @param idMenu, datos del formulario
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html de la vista
*/

$(document).on('click', "button[data-role='actualizar-opcion-menu']", function() {

  var idMenu = $(this).attr('data-opcion');
  var form = $("#formMenu");
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/sitio/actualizar-opcion-menu?id='+idMenu,
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
        $("#menu").remove();
        $('#container').append(data.response);
        $("#widget-opcion-menu").modal("hide");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

/**
* peticion ajax para renderizar el modal con el formulario para crear un modelo Opcion que es donde se
* guarda el enlace del item del menu
* @param idMenu
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html del modal
*/
$(document).on('click', "button[data-role='agregar-enlace-menu']", function() {

  var idMenu = $(this).attr('data-opcion');
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/sitio/render-agregar-enlace',
    data: {idMenu: idMenu},
    dataType: 'json',
    beforeSend: function() {
      $("#widget-agregar-opcion-menu").remove();
      $('body').showLoading()
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $('body').append(data.response);
        $("#widget-agregar-opcion-menu").modal("show");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

/**
* peticion ajax para guardar un modelo Opcion que es donde se guarda el enlace del item del menu
* @param
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html vista menuAdmin
*/

$(document).on('click', "button[data-role='guardar-enlace']", function() {


  var form = $("#formAgregarEnlace");
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/sitio/guardar-opcion-menu',
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
        $("#menu").remove();
        $('#container').append(data.response);
        $("#widget-agregar-opcion-menu").modal("hide");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

/**
* peticion ajax eliminar un modelo Opcion que es donde se guarda el enlace del item del menu
* @param idOpcion
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html de la vista menuAdmin
*/

$(document).on('click', "button[data-role='quitar-enlace-menu']", function() {

  var idOpcion = $(this).attr('data-opcion');
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/sitio/eliminar-enlace-menu',
    data: {idOpcion: idOpcion},
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading()
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $("#menu").remove();
        $('#container').append(data.response);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

//::::::::::::::::::::::
// CUMPLEAÑOS
//::::::::::::::::::::::
/**
* peticion ajax para guardar una felicitacion de cumpleaños
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response =
*/
$(document).on('click', "button[data-role='felicitaCumpleaños']", function() {

  var formElement = document.getElementById("formCumpleanos");
  var formData = new FormData(formElement);
  var id = $(this).attr('data-cumpleanos');
  var files = $('#contenido-imagenes').fileinput('getFileStack');

  if (files.length > 0) {
    $.each(files, function (key, data) {
          formData.append('imagenes[]', data, files[key].name);
    });
  }

  $.ajax({
    type: 'POST',
    processData: false,
    contentType:false,
    url: requestUrl + '/intranet/sitio/felicitar-cumpleanos?id='+id,
    data: formData,
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading()
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $("#felicitar").remove();
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
* peticion ajax para guardar una felicitacion de aniversario
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response =
*/

$(document).on('click', "button[data-role='felicitaAniversario']", function() {

  var formElement = document.getElementById("formAniversario");
  var formData = new FormData(formElement);
  var id = $(this).attr('data-aniversario');
  console.log(id);
  var files = $('#contenido-imagenes').fileinput('getFileStack');

  if (files.length > 0) {
    $.each(files, function (key, data) {
          formData.append('imagenes[]', data, files[key].name);
    });
  }

  $.ajax({
    type: 'POST',
    processData: false,
    contentType:false,
    url: requestUrl + '/intranet/sitio/felicitar-aniversario?id='+id,
    data: formData,
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading()
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $("#felicitar").remove();
        $('#container').append(data.response);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

//::::::::::::::::::::::
// CAMPAÑAS
//::::::::::::::::::::::
/**
* peticion ajax para eliminar un destino de una campana
* @param idOferta, idCiudad, idGrupo
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html para renderizar la grilla de los destinos
*/
$(document).on('click', "a[data-role='eliminarDestinoCampana']", function() {

  var idCampana = $(this).attr('data-campana');
  var idCiudad = $(this).attr('data-ciudad');
  var idGrupo = $(this).attr('data-grupo');

  if(confirm("¿Estas seguro de querer eliminar?")) {

    $.ajax({
      type: 'POST',
      async: true,
      url: requestUrl + '/intranet/publicaciones-campanas/eliminar-campana-destino',
      data: {idCiudad: idCiudad, idGrupo: idGrupo, idCampana: idCampana},
      dataType: 'json',
      beforeSend: function() {
        //    Loading.show();
        $('body').showLoading();
        $('#listaCampanas').remove();
      },

      complete: function(data) {
        //   Loading.hide();
        $('body').hideLoading();
      },
      success: function(data) {
        if (data.result == "ok") {
          $('#destinosCampana').append(data.response);
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
* peticion ajax para agregar un destino a una campana
* @param datos del formulario
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html para renderizar la grilla de los destinos
*/
$(document).on('click', "a[data-role='agregar-destino-campana']", function() {

  var form = $("#formEnviaDestinosCampana");
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/publicaciones-campanas/agrega-destino-campana',
    data: form.serialize(),
    dataType: 'json',
    beforeSend: function() {
      //    Loading.show();
      $('body').showLoading();
      $('#listaCampanas').remove();
    },

    complete: function(data) {
      //   Loading.hide();
      $('body').hideLoading();
    },
    success: function(data) {

        if (data.result == "ok") {
          $('#destinosCampana').append(data.response);
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

//::::::::::::::::::::::
// EVENTOS CALENDARIO
//::::::::::::::::::::::
/**
* peticion ajax para eliminar un destino de una oferta laboral
* @param idOferta, idCiudad, idGrupo
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html para renderizar la grilla de los destinos
*/
$(document).on('click', "a[data-role='eliminarDestinoEventoCalendario']", function() {

  var idEvento = $(this).attr('data-evento');
  var idCiudad = $(this).attr('data-ciudad');
  var idGrupo = $(this).attr('data-grupo');

  if(confirm("¿Estas seguro de querer eliminar?")) {

    $.ajax({
      type: 'POST',
      async: true,
      url: requestUrl + '/intranet/calendario/eliminar-evento-destino',
      data: {idCiudad: idCiudad, idGrupo: idGrupo, idEvento: idEvento},
      dataType: 'json',
      beforeSend: function() {
        //    Loading.show();
        $('body').showLoading();
        $('#listaEventos').remove();
      },

      complete: function(data) {
        //   Loading.hide();
        $('body').hideLoading();
      },
      success: function(data) {
        if (data.result == "ok") {
          $('#destinosEventos').append(data.response);
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
* peticion ajax para agregar un destino a un evento
* @param datos del formulario
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html para renderizar la grilla de los destinos
*/
$(document).on('click', "a[data-role='agregar-destino-evento-calendario']", function() {

  var form = $("#formEnviaDestinosEventos");

  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/calendario/agrega-destino-evento',
    data: form.serialize(),
    dataType: 'json',
    beforeSend: function() {
      //    Loading.show();
      $('body').showLoading();
      $('#listaEventos').remove();
    },

    complete: function(data) {
      //   Loading.hide();
      $('body').hideLoading();
    },
    success: function(data) {

        if (data.result == "ok") {
          $('#destinosEventos').append(data.response);
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});


$(document).on('click', "a[data-role='asignar-contenido-evento-calendario']", function() {

  var idContenido = $(this).attr('data-contenido');
  var idEvento = $('#modelo').attr('data-evento');
  var url = $(this).attr('href')

  $.ajax({
    type: 'POST',
    async: true,
    url: url, //requestUrl + '/intranet/calendario/asignar-contenido-evento',
    data: {idContenido: idContenido, idEvento: idEvento},
    dataType: 'json',
    beforeSend: function() {
      //    Loading.show();
      $('body').showLoading();
      $('#contenidos-lista').remove();
    },

    complete: function(data) {
      //   Loading.hide();
      $('body').hideLoading();
    },
    success: function(data) {

      if (data.result == "ok") {
        //location.reload();
        $('#lista-contenido-asignar').append(data.response);

      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

//::::::::::::::::::::::
// OTROS
//::::::::::::::::::::::

$(document).on('click', "#enviaFormularioMenuPortales", function() {
  //console.log('dio click envia formulario');
  $('#formMenuportales').submit();
});

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
