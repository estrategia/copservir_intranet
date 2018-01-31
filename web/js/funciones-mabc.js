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
      $('body').showLoading();
    },

    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        var elemento = '#tarea'+data.response;
        if (data.progreso < 100) {
          $(elemento).removeClass('slider danger col-md-8');
          $(elemento).addClass('slider primary col-md-8');
        }else{
          $(elemento).removeClass('slider primary col-md-8');
          $(elemento).addClass('slider danger col-md-8');
        }
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
        $('body').showLoading();
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
        $('body').showLoading();
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
        $('body').showLoading();
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
  return false;
});

//::::::::::::::::::::::
// CONTENIDO EMERGENTE
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
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $('#widget-popup').modal('hide');
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
});

/**
* peticion ajax para eliminar un destino de un contenido emergente
* @param idContenidoEmergente, idCiudad, idGrupo
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html para renderizar la grilla de los destinos
*/
$(document).on('click', "a[data-role='eliminarDestinoContenidoEmergente']", function() {

  var idContenidoEmergente = $(this).attr('data-contenido-emergente');
  var idCiudad = $(this).attr('data-ciudad');
  var idGrupo = $(this).attr('data-grupo');

  if(confirm("¿Estas seguro de querer eliminar?")) {

    $.ajax({
      type: 'POST',
      async: true,
      url: requestUrl + '/intranet/contenido-emergente/eliminar-contenido-emergente-destino',
      data: {idCiudad: idCiudad, idGrupo: idGrupo, idContenidoEmergente: idContenidoEmergente},
      dataType: 'json',
      beforeSend: function() {
        $('body').showLoading();
        $('#listaContenidoEmergente').remove();
      },
      complete: function(data) {
        $('body').hideLoading();
      },
      success: function(data) {
        if (data.result == "ok") {
          $('#destinosContenidoEmergente').append(data.response);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('body').hideLoading();
      }
    });
  }
  return false;
});

/**
* peticion ajax para agregar un destino a una campana
* @param datos del formulario
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html para renderizar la grilla de los destinos
*/
$(document).on('click', "a[data-role='agregar-destino-contenido-emergente']", function() {

  var form = $("#formEnviaDestinosContenidoEmergente");
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/contenido-emergente/agrega-destino-contenido-emergente',
    data: form.serialize(),
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
      $('#listaContenidoEmergente').remove();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
        if (data.result == "ok") {
          $('#destinosContenidoEmergente').append(data.response);
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

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
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
          $('body').append(data.response);
          $("#widget-enviarAmigo").modal("show");
      }else{
          alert(data.response);
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
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $("#widget-enviarAmigo").modal('hide');
      }else{
        if (data.error == 'campoVacio') {
          $('#inputUsuarios').addClass('form-group has-error');
          $('.error').text(data.text);
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
        $('body').showLoading();
        $('#listaCargos').remove();
      },
      complete: function(data) {
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
    });
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
      $('body').showLoading();
      $('#listaCargos').remove();
    },
    complete: function(data) {
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
        $('body').showLoading();
        $('#listaOfertas').remove();
      },
      complete: function(data) {
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
      $('body').showLoading();
      $('#listaOfertas').remove();
    },
    complete: function(data) {
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
      $( "#contenido-plantilla" ).empty();
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
    $.get( requestUrl +'/intranet/permisos/render-lista', { nombreRol: nombreRol } )
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
  var contenido = elemento.attr('data-content');
  if (contenido === '' || contenido === undefined) {
    $.ajax({
      type: 'GET',
      async: true,
      url: requestUrl +'/intranet/informacion-contacto-oferta/plantilla?id='+idOferta,
      dataType: 'json',
      beforeSend: function() {
        $('body').showLoading();
      },
      complete: function(data) {
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
      $('body').showLoading();
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
    dataType: 'json',
    beforeSend: function() {
      $("#widget-categoria").remove();
      $('body').showLoading();
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
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $("#menu-categoria-documento").remove();
        $('#container').append(data.response);
        $("#widget-categoria").modal("hide");
      }else{
        $("#widget-categoria").modal("hide");
        $('#widget-categoria').on('hidden.bs.modal', function (e) {
          $('#widget-categoria').remove();
          $("body").append(data.response);
          $("#widget-categoria").modal("show");
        });
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
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $("#menu-categoria-documento").remove();
        $('#container').append(data.response);
        $("#widget-categoria").modal("hide");
      }else{
        $("#widget-categoria").modal("hide");
        $('#widget-categoria').on('hidden.bs.modal', function (e) {
          $('#widget-categoria').remove();
          $("body").append(data.response);
          $("#widget-categoria").modal("show");
        });
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
      $('body').showLoading();
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
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $("#menu-categoria-documento").remove();
        $('#container').append(data.response);
        $("#widget-relaciona-documento").modal("hide");
      }else{
        $("#widget-relaciona-documento").modal("hide");
        $('#widget-relaciona-documento').on('hidden.bs.modal', function (e) {
          $('#widget-relaciona-documento').remove();
          $("body").append(data.response);
          $("#widget-relaciona-documento").modal("show");
        });
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

$(document).on('click', "button[data-role='edita-relacion']", function() {

  var idCategoriaDocumento = $(this).attr('data-categoria');

  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/categoria-documento/render-editar-relacion',
    data: {idCategoriaDocumento: idCategoriaDocumento},
    dataType: 'json',
    beforeSend: function() {
      $("#widget-relaciona-documento").remove();
      $('body').showLoading();
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

$(document).on('click', "button[data-role='guardar-edito-relacion']", function() {



  var idCategoriaDocumento = $(this).attr('data-categoria');
  var form = $("#formRelacionaCategoria");

  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/categoria-documento/guardar-edita-relacion?id='+idCategoriaDocumento,
    data: form.serialize(),
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $("#widget-relaciona-documento").modal("hide");
      }else{
        $("#widget-relaciona-documento").modal("hide");
        $('#widget-relaciona-documento').on('hidden.bs.modal', function (e) {
          $('#widget-relaciona-documento').remove();
          $('body').append(data.response);
          $("#widget-relaciona-documento").modal("show");
        });
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });

  console.log('cilck guarda edicion relacion');
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
      $('body').showLoading();
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
      $('body').showLoading();
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
      $('body').showLoading();
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
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $("#menu").remove();
        $('#container').append(data.response);
        $("#widget-opcion-menu").modal("hide");
      }else{
        $("#widget-opcion-menu").modal("hide");
        $('#widget-opcion-menu').on('hidden.bs.modal', function (e) {
          $("#widget-opcion-menu").remove();
          $('body').append(data.response);
          $("#widget-opcion-menu").modal("show");
        });
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
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $("#menu").remove();
        $('#container').append(data.response);
        $("#widget-opcion-menu").modal("hide");
      }else{
          $("#widget-opcion-menu").modal("hide");
          $('#widget-opcion-menu').on('hidden.bs.modal', function (e) {
            $('#widget-opcion-menu').remove();
            $('body').append(data.response);
            $("#widget-opcion-menu").modal("show");
          });
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
      $('body').showLoading();
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
* peticion ajax para renderizar el modal con el formulario para actualizar un modelo Opcion que es donde se
* guarda el enlace del item del menu
* @param idOpcion
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html del modal
*/
$(document).on('click', "button[data-role='editar-enlace']", function() {

  var idOpcion = $(this).attr('data-opcion');
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/sitio/render-editar-enlace',
    data: {idOpcion: idOpcion},
    dataType: 'json',
    beforeSend: function() {
      $("#widget-agregar-opcion-menu").remove();
      $('body').showLoading();
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
$(document).on('click', "button[data-role='guardar-edicion-enlace']", function() {

  var idOpcion = $(this).attr('data-opcion');
  var form = $("#formAgregarEnlace");
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/sitio/guardar-edita-opcion?id='+idOpcion,
    data: form.serialize(),
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $("#menu").remove();
        $('#container').append(data.response);
        $("#widget-agregar-opcion-menu").modal("hide");
      }else{
        $("#widget-agregar-opcion-menu").modal("hide");
        $('#widget-agregar-opcion-menu').on('hidden.bs.modal', function (e) {
          $('#widget-agregar-opcion-menu').remove();
          $('body').append(data.response);
          $("#widget-agregar-opcion-menu").modal("show");
        });
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
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $("#menu").remove();
        $('#container').append(data.response);
        $("#widget-agregar-opcion-menu").modal("hide");
      }else{
        $("#widget-agregar-opcion-menu").modal("hide");
        $('#widget-agregar-opcion-menu').on('hidden.bs.modal', function (e) {
          $('#widget-agregar-opcion-menu').remove();
          $('body').append(data.response);
          $("#widget-agregar-opcion-menu").modal("show");
        });
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
      $('body').showLoading();
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
$(document).on('click', "button[data-role='felicitar-cumpleanios']", function() {

  var formElement = document.getElementById("form-cumpleanios");
  var formData = new FormData(formElement);
  var id = $(this).attr('data-cumpleanios');
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
      $('html').showLoading();
      $('#form-cumpleanios .form-group.has-error .help-block').html('');
	  $('#form-cumpleanios .form-group.has-error').removeClass('has-error');
	  $('#div-felicitar-alert').html('');
	  $('#form-cumpleanios button[type=submit]').attr('disabled', 'disabled');
    },
    complete: function(data) {
      $('html').hideLoading();
	  $('#form-cumpleanios button[type=submit]').removeAttr('disabled');
    },
    success: function(data) {
      if (data.result == "ok") {
    	  $("#contenido-contenido").redactor('code.set', '');
    	  $('#contenido-imagenes').fileinput('reset'); 
    	  $('#contenido-imagenes').fileinput('reset').trigger('custom-event');
    	  $('#div-felicitar-alert').html(jsonToAlertMessage(data.response));
      }else if(data.result=="error"){
    	  $('#div-felicitar-alert').html(jsonToAlertMessage(data.response));
    	  if(data.validation){
    		  $.each(data.validation, function(element, error) {
    			  $('#form-cumpleanios .form-group.field-' + element + " .help-block").html(error);
                  $('#form-cumpleanios .form-group.field-' + element).addClass('has-error');
              });
    	  }
      }else{
    	  alert("Error no detectado");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('html').hideLoading();
    }
  });
  return false;
});

function jsonToAlertMessage(data){
	var html = '';
	$.each(data, function(i, item) {
		html += '<div role="alert" class="alert alert-'+item.alert+' alert-dismissible fade in">';
		html += '<button aria-label="Close" data-dismiss="alert" class="close" type="button"></button>';
		html += '<p>'+item.text+'</p>';
		html += '</div>';
	});
	return html;
}


/**
* peticion ajax para guardar una felicitacion de aniversario
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response =
*/

$(document).on('click', "button[data-role='felicitar-aniversario']", function() {
  var formElement = document.getElementById("form-aniversario");
  var formData = new FormData(formElement);
  var id = $(this).attr('data-aniversario');
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
        $('html').showLoading();
        $('#form-aniversario .form-group.has-error .help-block').html('');
  	  	$('#form-aniversario .form-group.has-error').removeClass('has-error');
  	  	$('#div-felicitar-alert').html('');
  	  	$('#form-aniversario button[type=submit]').attr('disabled', 'disabled');
    },
    complete: function(data) {
    	$('html').hideLoading();
  	  	$('#form-aniversario button[type=submit]').removeAttr('disabled');
    },
    success: function(data) {
    	if (data.result == "ok") {
      	  $("#contenido-contenido").redactor('code.set', '');
      	  $('#contenido-imagenes').fileinput('reset'); 
      	  $('#contenido-imagenes').fileinput('reset').trigger('custom-event');
      	  $('#div-felicitar-alert').html(jsonToAlertMessage(data.response));
        }else if(data.result=="error"){
      	  $('#div-felicitar-alert').html(jsonToAlertMessage(data.response));
      	  if(data.validation){
      		  $.each(data.validation, function(element, error) {
      			  $('#form-aniversario .form-group.field-' + element + " .help-block").html(error);
                    $('#form-aniversario .form-group.field-' + element).addClass('has-error');
                });
      	  }
        }else{
      	  alert("Error no detectado");
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('html').hideLoading();
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
        $('body').showLoading();
        $('#listaCampanas').remove();
      },
      complete: function(data) {
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
      $('body').showLoading();
      $('#listaCampanas').remove();
    },
    complete: function(data) {
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
        $('body').showLoading();
        $('#listaEventos').remove();
      },
      complete: function(data) {
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
      $('body').showLoading();
      $('#listaEventos').remove();
    },
    complete: function(data) {
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
  var url = $(this).attr('href');

  $.ajax({
    type: 'POST',
    async: true,
    url: url,
    data: {idContenido: idContenido, idEvento: idEvento},
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
      $('#contenidos-lista').remove();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
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
// RBAC
//::::::::::::::::::::::
/**
* peticion ajax para agregar un permiso a un rol
* @param datos del formulario
* @return data.result = json donde se especifica si todo se realizo bien
*         data.response = html para renderizar la grilla
*/

$(document).on('click', "a[data-role='eliminarPemisoRol']", function() {

  var url = $(this).attr('href');

  $.ajax({
    type: 'POST',
    async: true,
    url: url,
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
      $('#listaContenidoEmergente').remove();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
        if (data.result == "ok") {
          $('.permisos').remove();
          $('.lista-permisos').append(data.response);
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });

  return false;
});

//::::::::::::::::::::::
// MENU PORTALES
//::::::::::::::::::::::

$(document).on('click', "a[data-role='asignar-padre']", function() {

    var idPortal = $('#menuportales-idportal').val();
    var idMenuPortal = $(this).attr('data-menu-portal');

    // console.log(idMenuPortal);

    if ( idPortal != '') {
      construirModal(idPortal, idMenuPortal);
    }else{
        alert('Debes seleccionar un portal para poder asignar un padre al menu');
    }
    return false;

});

$(document).on('click', "a[data-role='ver-orden-menu']", function() {
    var idPortal = $('#menuportales-idportal').val();
    if ( idPortal != '') {
      $.ajax({
        type: 'GET',
        async: true,
        url: requestUrl + '/intranet/menu-portales/orden-menu?idPortal='+idPortal,
        dataType: 'json',
        beforeSend: function() {
          $('body').showLoading();
          $('#modal-menu .modal-content .modal-body').html("");
        },
        complete: function(data) {
          $('body').hideLoading();
        },
        success: function(data) {
            if (data.result == "ok") {
              $('#modal-menu').modal("show");
              $('#modal-menu .modal-content .modal-body').html(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('body').hideLoading();
        }
      });
    }else{
        alert('Debes seleccionar un portal para ver el menu');
    }
    return false;
   
});

function construirModal(idPortal, idMenuPortal) {

  $.ajax({
    type: 'GET',
    async: true,
    url: requestUrl + '/intranet/menu-portales/render-modal?idPortal='+idPortal,
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
      $('#listaContenidoEmergente').remove();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
        if (data.result == "ok") {
          $('#widget-submenu-portal').remove();
          $('body').append(data.response);


          $('#button'+idMenuPortal).remove();

          padre = $('#menuportales-idmenuportalpadre').val();
          $('#button'+padre).text('Asignado');

          $('#widget-submenu-portal').modal('show');
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
}

$(document).on('click', "button[data-role='asignar-submenu-portal']", function() {

  var idMenu = $(this).attr('data-menu');
  var texto = $(this).attr('data-texto');
  $('#submenu').val(texto);
  $('#menuportales-idmenuportalpadre').val(idMenu);
  $(this).text('seleccionado');
  $('#widget-submenu-portal').modal('hide');
  return false;
});

$(document).on('click', "#enviaFormularioMenuPortales", function() {
  $('#formMenuportales').submit();
});

//::::::::::::::::::::::
// OTROS
//::::::::::::::::::::::
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

//mostrar y ocultar formulario para publicar una noticia
var count = 1;
$(document).on('click', "#mostrarFormularioContenido", function() {

  $('#publicarContenido').toggle('slow');
  count ++;
  if (count % 2 === 0 ) {
      $("#mostrarFormularioContenido").text('ocultar formulario');
  }else{
      $("#mostrarFormularioContenido").text('crea una publicación');
  }

  return false;
});

/**
* Acciones que se ejecutan cuando el navegador cargue los scripts
*/
$(function() {

  $('.list-group-item').on('click', function() {
    $('.glyphicon', this)
      .toggleClass('glyphicon-chevron-right')
      .toggleClass('glyphicon-chevron-down');
  });
});

$( document ).ready(function() {

  // CAROUSEL CUMPLEAÑOS
  var owlCumple = $('#owl-Cumpleaños');
  owlCumple.owlCarousel({
    autoWidth: true,
    autoplay: true,
    autoplayTimeout:1000,
    autoplayHoverPause:true,
    responsiveClass:true,
    loop:true,
    items: 6,
    nav:true,
    dots: false,
    controls: true,
    navigationText: [
      "<i class='icon-chevron-left icon-white'></i>",
      "<i class='icon-chevron-right icon-white'></i>"
      ],
  });

  // EVENTOS PARA MOVER EL CAROUSEL CUMPLEAÑOS
  $('.owl-prev-Cumpleaños').click(function() {
    owlCumple.trigger('owl.prev');
  });

  $('.owl-next-Cumpleaños').click(function() {
    owlCumple.trigger('owl.next');
  });

  // CAROUSEL ANIVERSARIOS
  var owlAni = $('#owl-Aniversarios');

  owlAni.owlCarousel({
    autoWidth: true,
    autoplay: true,
    autoplayTimeout:1000,
    autoplayHoverPause:true,
    responsiveClass:true,
    loop:true,
    items: 6,
    nav:false,
    dots: false,
  });

  // EVENTOS PARA MOVER EL CAROUSEL ANIVERSARIOS
  $('.owl-prev-Aniversarios').click(function() {
    owlAni.trigger('owl.prev');
  });

  $('.owl-next-Aniversarios').click(function() {
    owlAni.trigger('owl.next');
  });

  // javascript para que se busque una noticia cuando presiona enter
  $('#busqueda').keypress(function(event) {
    if (event.which == 13) {
      event.preventDefault();
      $('#formBuscadorNoticias').submit();
    }
  });

});

$(document).on('click', 'button[data-role="eliminar-imagen-modulo-galeria"]', function () {
  var idImagen = $(this).attr('data-imagen');
  var idModulo = $(this).attr('data-modulo');
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/modulos-administrables/eliminar-imagen',
    data: {idImagen: idImagen, idModulo: idModulo},
    beforeSend: function() {
      $('body').showLoading();
    },
    success: function(data) {
        var data = $.parseJSON(data);
        if (data.result == "ok") {
          $("#lista-imagenes-modulo-galeria").html(data.response);
        } else if (data.result == "error") {
          console.log('error');
        }
    },
    complete: function() {
      $('body').hideLoading();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR);
    }
  });
});

$(document).on('click', 'button[data-role="editar-imagen-modulo-galeria"]', function () {
  var idImagen = $(this).attr('data-imagen');
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/modulos-administrables/editar-imagen',
    data: {idImagen: idImagen},
    beforeSend: function() {
      $('body').showLoading();
    },
    success: function(data) {
        var data = $.parseJSON(data);
        if (data.result == "ok") {
          $("#div-editar-imagen").html(data.response);
          $("#modal-editar-imagen").modal('show');
        } else if (data.result == "error") {
          console.log('error');
        }
    },
    complete: function() {
      $('body').hideLoading();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR);
    }
  });
});

$(document).on('click', 'button[data-role="guardar-cambios-imagen"]', function () {
  // var idImagen = $(this).attr('data-imagen');
  var data = $("#form-editar-imagen").serialize();
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/modulos-administrables/guardar-cambios-imagen',
    data: data,
    beforeSend: function() {
      $('body').showLoading();
    },
    success: function(data) {
        var data = $.parseJSON(data);
        if (data.result == "ok") {
          $("#lista-imagenes-modulo-galeria").html(data.response);
          $("#modal-editar-imagen").modal('hide');
        } else if (data.result == "error") {
          console.log('error');
        }
    },
    complete: function() {
      $('body').hideLoading();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR);
    }
  });
});

$(document).on('click', "button[data-role='modulo-crear']", function() {

  var idCurso = $(this).attr('data-curso');
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/formacioncomunicaciones/curso/render-modal-crear-modulo?idCurso=' + idCurso,
    dataType: 'json',
    beforeSend: function() {
      $("#widget-modulo").remove();
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $('body').append(data.response);
        $("#widget-modulo").modal("show");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

$(document).on('click', "a[data-role='modulo-editar']", function() {

  var idModulo = $(this).attr('data-modulo-id');
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/formacioncomunicaciones/curso/render-modal-editar-modulo?idModulo=' + idModulo,
    dataType: 'json',
    beforeSend: function() {
      $("#widget-modulo").remove();
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $('body').append(data.response);
        $("#widget-modulo").modal("show");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

$(document).on('click', "button[data-role='crear-modulo']", function() {

  var form = $("#form-modulo");
  var idCurso = $("#contenido-curso").attr('data-curso-id');
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/formacioncomunicaciones/curso/crear-modulo?idCurso=' + idCurso,
    data: form.serialize(),
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $("#contenido-curso").remove();
        $('#container').append(data.response);
        $("#widget-modulo").modal("hide");
      }else{
        $("#widget-modulo").modal("hide");
        $('#widget-modulo').on('hidden.bs.modal', function (e) {
          $('#widget-modulo').remove();
          $("body").append(data.response);
          $("#widget-modulo").modal("show");
        });
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

$(document).on('click', "button[data-role='actualizar-modulo']", function() {

  var idModulo = $(this).attr('data-modulo');
  var idCurso = $("#contenido-curso").attr('data-curso-id');
  var form = $("#form-modulo");
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/formacioncomunicaciones/curso/actualizar-modulo?idModulo=' + idModulo + '&' + 'idCurso=' + idCurso,
    data: form.serialize(),
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $('#contenido-curso').remove();
        $('#container').append(data.response);
        $("#widget-modulo").modal("hide");
      }else{
        $("#widget-modulo").modal("hide");
        $('#widget-modulo').on('hidden.bs.modal', function (e) {
          $('#widget-modulo').remove();
          $("body").append(data.response);
          $("#widget-modulo").modal("show");
        });
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

$(document).on('click', "a[data-role='agregar-capitulo']", function() {

  var idModulo = $(this).attr('data-modulo-id');
  var idCurso = $("#contenido-curso").attr('data-curso-id');
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/formacioncomunicaciones/curso/render-modal-crear-capitulo?idModulo=' + idModulo + '&' + 'idCurso=' + idCurso,
    dataType: 'json',
    beforeSend: function() {
      $("#widget-capitulo").remove();
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $('body').append(data.response);
        $("#widget-capitulo").modal("show");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

$(document).on('click', "button[data-role='crear-capitulo']", function() {

  var form = $("#form-capitulo");
  var idCurso = $("#contenido-curso").attr('data-curso-id');
  // console.log(form.serialize());
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/formacioncomunicaciones/curso/crear-capitulo?idCurso=' + idCurso,
    data: form.serialize(),
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $("#contenido-curso").remove();
        $('#container').append(data.response);
        $("#widget-capitulo").modal("hide");
      }else{
        $("#widget-capitulo").modal("hide");
        $('#widget-capitulo').on('hidden.bs.modal', function (e) {
          $('#widget-capitulo').remove();
          $("body").append(data.response);
          $("#widget-capitulo").modal("show");
        });
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

$(document).on('click', "a[data-role='capitulo-editar']", function() {

  var idCapitulo = $(this).attr('data-capitulo-id');
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/formacioncomunicaciones/curso/render-modal-editar-capitulo?idCapitulo=' + idCapitulo,
    dataType: 'json',
    beforeSend: function() {
      $("#widget-capitulo").remove();
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $('body').append(data.response);
        $("#widget-capitulo").modal("show");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

$(document).on('click', "button[data-role='actualizar-capitulo']", function() {

  var idCapitulo = $(this).attr('data-capitulo');
  var idCurso = $("#contenido-curso").attr('data-curso-id');
  var form = $("#form-capitulo");
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/formacioncomunicaciones/curso/actualizar-capitulo?idCapitulo=' + idCapitulo + '&' + 'idCurso=' + idCurso,
    data: form.serialize(),
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $('#contenido-curso').remove();
        $('#container').append(data.response);
        $("#widget-capitulo").modal("hide");
      }else{
        $("#widget-capitulo").modal("hide");
        $('#widget-capitulo').on('hidden.bs.modal', function (e) {
          $('#widget-capitulo').remove();
          $("body").append(data.response);
          $("#widget-capitulo").modal("show");
        });
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

$(document).on('click', "a[data-role='agregar-contenido']", function() {

  var idCapitulo = $(this).attr('data-capitulo-id');
  var idCurso = $("#contenido-curso").attr('data-curso-id');
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/formacioncomunicaciones/curso/render-modal-crear-contenido?idCapitulo=' + idCapitulo + '&' + 'idCurso=' + idCurso,
    dataType: 'json',
    beforeSend: function() {
      $("#widget-contenido").remove();
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $('body').append(data.response);
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        $("#widget-contenido").modal("show");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

$(document).on('click', "button[data-role='crear-contenido']", function() {

  var form = $("#form-contenido");
  var idCurso = $("#contenido-curso").attr('data-curso-id');
  var idCapitulo = $(this).attr('data-capitulo-id');
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/formacioncomunicaciones/curso/crear-contenido?idCurso=' + idCurso + '&' + 'idCapitulo=' + idCapitulo,
    data: form.serialize(),
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $("#contenido-curso").remove();
        $('#container').append(data.response);
        $("#widget-contenido").modal("hide");
      }else{
        $("#widget-contenido").modal("hide");
        $('#widget-contenido').on('hidden.bs.modal', function (e) {
          $('#widget-contenido').remove();
          $("body").append(data.response);
          $("#widget-contenido").modal("show");
        });
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

// var tiempoActual = null;

// $(document).ready(function () {
//   tiempoActual = new Date();
// });

// $(document).ready(function () {
//   $("#marcador-leido").one('inview', function () {
//     var idContenido = $(this).attr('data-contenido-id');
//     var tiempoLectura = Math.round( (new Date() - tiempoActual) / 1000);
//     $.ajax({
//       type: 'POST',
//       async: true,
//       url: requestUrl + '/intranet/formacioncomunicaciones/contenido/marcar-leido?id=' + idContenido,
//       dataType: 'json',
//       data: {tiempoLectura: tiempoLectura},
//       beforeSend: function() {
//         $('body').showLoading();
//       },
//       complete: function(data) {
//         $('body').hideLoading();
//       },
//       success: function(data) {
//         if (data.result == "ok") {
//           console.log('Leido');
//           mostrarMensajeCuestionario(data.response.preguntaCuestionario);
//         }else{
//           console.log('No Leido');
//         }
//       },
//       error: function(jqXHR, textStatus, errorThrown) {
//         $('body').hideLoading();
//       }
//     });
//   // return false;
//   });
// });

// function mostrarMensajeCuestionario(idCuestionario) {
//   if (idCuestionario != false) {
//     var redirecciona = confirm("Felicitaciones, ha completado el curso. ¿Desea realizar la prueba de conocimiento ahora?");
//     if (redirecciona == true) {
//       window.location.href = requestUrl + '/intranet/formacioncomunicaciones/cuestionario/aplicar-cuestionario?id=' + idCuestionario;
//     }
//   }
// }

$(document).ready(function () {
  $("input[name='paqueteContenido']").on('filepreajax', function (event, previewId, index) {
    $('#btn-actualizar-contenido').addClass('disabled');
  });

  $("input[name='paqueteContenido']").on('fileuploaded', function (event, data, previewId, index) {
    $('#btn-actualizar-contenido').removeClass('disabled');
    var html = "<iframe class='iframe-contenido-curso' src=" + data.response.response.iframeSrc + "> <iframe>";
    $("#contenido-contenido").redactor('insert.htmlWithoutClean', html);
  });

  $("input[name='paqueteContenido']").on('fileunlock', function (event, filestack, extraData) {
    $('#btn-actualizar-contenido').removeClass('disabled');
  });
});

$(document).on('click', "input[data-role='toogle-collapsible']", function() {
  if ($(this).attr('data-valor') == 1) {
    $(this).attr('data-valor', 0);
    $(this).val('Colapsar');
    $('.list-group.collapse').addClass('in');
  }
  else if ($(this).attr('data-valor') == 0) {
    $(this).val('Expandir');
    $(this).attr('data-valor', 1);
    $('.list-group.collapse').removeClass('in');
  }
  return false; 
});

$(document).on('change', "#parametrospuntos-tipoparametro", function () {
  if ($(this).val() == 1) {
    $('.field-parametrospuntos-condicion').addClass('hidden');
  } else if ($(this).val() == 2) {
    $('.field-parametrospuntos-condicion').removeClass('hidden');
  }
});

$(document).on('click', "a[data-role='modal-padre-categoria']", function () {
  $.ajax({
    type: 'GET',
    async: true,
    url: requestUrl + '/intranet/formacioncomunicaciones/categorias-premios/render-modal-asignar-padre',
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
        if (data.result == "ok") {
          $('#modal-asignar-categoria-padre').remove();
          $('body').append(data.response);
          $('#modal-asignar-categoria-padre').modal('show');
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
});

$(document).on('click', "a[data-role='categoria-padre-asignar']", function () {
  var idCategoria = $(this).attr('data-id-categoria');
  var nombreCategoria = $(this).attr('data-nombre-categoria');
  $('#categoriaspremios-idcategoriapadre').val(idCategoria);
  $('#premio-idcategoria').val(idCategoria);
  $("a[data-role='modal-padre-categoria']").text(nombreCategoria);
  $('#modal-asignar-categoria-padre').modal('hide');
  return false;
});

$(document).on('click', "a[data-role='categoria-padre-eliminar']", function () {
  $("a[data-role='modal-padre-categoria']").text('Asignar');
  $('#categoriaspremios-idcategoriapadre').val(null);
  return false;
})

$(document).on('click', "button[data-role='agregar-contacto-categoria']", function () {
  if ($('#modal-agregar-contacto-categoria').length == 0) {
    $.ajax({
      type: 'GET',
      async: true,
      url: requestUrl + '/intranet/formacioncomunicaciones/contacto-categoria/render-modal-agregar-contacto',
      dataType: 'json',
      beforeSend: function() {
        $('body').showLoading();
      },
      complete: function(data) {
        $('body').hideLoading();
      },
      success: function(data) {
          if (data.result == "ok") {
            // $('#modal-asignar-categoria-padre').remove();
            $('body').append(data.response);
            }
          $('#modal-agregar-contacto-categoria').modal('show');
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('body').hideLoading();
      }
    });
  } else {
    $('#modal-agregar-contacto-categoria').modal('show');  
  }
});

$(document).on('click', "button[data-role='crear-contacto-categoria']", function () {
  var idCategoria = $("button[data-role='agregar-contacto-categoria']").attr('data-id-categoria');
  var numeroDocumento = $("#selector-usuarios-contacto").val();
  // console.log(idCategoria, numeroDocumento);
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/formacioncomunicaciones/contacto-categoria/crear',
    data: {idCategoria, numeroDocumento},
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
        if (data.result == "ok") {
          $('#lista-contactos-categoria').html(data.response);
        }
        $('#modal-agregar-contacto-categoria').modal('hide');
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
})

$(document).on('click', "a[data-role='eliminar-contacto-categoria']", function () {
  var idCategoria = $(this).attr('data-id-categoria');
  var numeroDocumento = $(this).attr('data-numero-documento');
  // console.log(idCategoria, numeroDocumento);
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/formacioncomunicaciones/contacto-categoria/eliminar',
    data: {idCategoria, numeroDocumento},
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
        if (data.result == "ok") {
          $('#lista-contactos-categoria').html(data.response);
          // $('body').append(data.response);
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
});

$(document).on('click', "a[data-role='ver-traza']", function() {
  var idRedencion = $(this).attr('data-id-redencion');
  $.ajax({
    type: 'GET',
    async: true,
    url: requestUrl + '/intranet/formacioncomunicaciones/redencion/render-modal-traza?idRedencion=' + idRedencion,
    dataType: 'json',
    beforeSend: function() {
      $("#widget-traza").remove();
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $('body').append(data.response);
        $("#widget-traza").modal("show");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

$(document).on('click', "button[data-role='ver-puntos-usuario']", function() {
  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/formacioncomunicaciones/reportes/render-modal-puntos-usuario',
    dataType: 'json',
    beforeSend: function() {
      $("#widget-puntos-usuario").remove();
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      if (data.result == "ok") {
        $('body').append(data.response);
        $("#widget-puntos-usuario").modal("show");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

$(document).ready(function () {
  $('.rotor-cursos').owlCarousel({
      singleItem:true,
      loop:true,
      // navigation:true,
      // pagination: true,
      center: true,
      // dots: true,
      autoPlay: true,
      // autoplayTimeout: 3000,
      
  });
})

// Organigrama 
 // var organigrama_config = {
 //     chart: {
 //         container: "#organigrama",
 //         connectors: {
 //           type: "step"
 //         }
 //     }
 //   };
 
 // $(document).ready(function () {
 //   $.ajax({
 //     type: 'GET',
 //     async: true,
 //     url: requestUrl + '/intranet/organigrama/consultar',
 //     // data: {idCategoria, numeroDocumento},
 //     dataType: 'json',
 //     beforeSend: function() {
 //       $('body').showLoading();
 //     },
 //     complete: function(data) {
 //       $('body').hideLoading();
 //     },
 //     success: function(data) {
 //         if (data.result == "ok") {
 //           organigrama_config.nodeStructure = data.response;
 //           var organigrama = new Treant(organigrama_config, null, $);
 //         }
 //     },
 //     error: function(jqXHR, textStatus, errorThrown) {
 //       $('body').hideLoading();
 //     }
 //   });
 // })
 
 // $(document).on('click', '.node', function () {
 //   var numeroDocumento = $(this).attr('id');
 //   var expandido = $(this).attr('data-expandido');
 //   if(expandido != 1) {
 //     $.ajax({
 //       type: 'GET',
 //       async: true,
 //       url: requestUrl + '/intranet/organigrama/colaboradores?numeroDocumento=' + numeroDocumento,
 //       // data: {idCategoria, numeroDocumento},
 //       dataType: 'json',
 //       beforeSend: function() {
 //         $('body').showLoading();
 //       },
 //       complete: function(data) {
 //         $('body').hideLoading();
 //       },
 //       success: function(data) {
 //           if (data.result == "ok") {
 //             organigrama_config.nodeStructure = data.response;
 //             organigrama = new Treant(organigrama_config, null, $);
 //           }
 //             $('#'+numeroDocumento).attr('data-expandido', '1');
 //       },
 //       error: function(jqXHR, textStatus, errorThrown) {
 //         $('body').hideLoading();
 //       }
 //     });
 //   }
 // });

// Simulador Servicop
var ordenItemsSimulador = [
   'input[name="plazo"]',
   'input[name="valor"]',
   // 'div#widget-garantias',
   // 'div#widget-garantias-combinadas',
   'div#garantias',
   // 'div#widget-parametros',
   // 'div#widget-codeudor',
   // 'div#widget-cuotas-extra',
   // 'div#cuotas'
];

var contadorFormularioSimulador = 0;

function desactivarInputs() {
  $.each(ordenItemsSimulador, function (index, selector) {
    var elemento = $(selector);
    elemento.hide();
    var elementos = $(selector + ' input');
    $.each(elementos, function (index, elementoInterno) {
      elemento.hide();
    })
  })
  $('button[data-role="simular-credito"]').attr('disabled', true);
  $('button[data-role="simular-credito"]').removeClass('btn-primary');
  $('button[data-role="simular-credito"]').addClass('btn-default');
  $('button[data-role="campo-siguiente"]').hide();

}

function activarSiguienteItemSimulador() {
  // console.log('Antes: ' + contadorFormularioSimulador);
  if (contadorFormularioSimulador == (ordenItemsSimulador.length)) {
    $('button[data-role="simular-credito"]').attr('disabled', false);
    $('button[data-role="simular-credito"]').removeClass('btn-default');
    $('button[data-role="simular-credito"]').addClass('btn-primary');
  }
  $(ordenItemsSimulador[contadorFormularioSimulador]).show().focus();
  $(ordenItemsSimulador[contadorFormularioSimulador] + ' input').show().focus();
  var nombre = $(ordenItemsSimulador[contadorFormularioSimulador]).attr('name');
  if (nombre == undefined) {
    nombre = $(ordenItemsSimulador[contadorFormularioSimulador] + ' input').attr('name');
  }
  $('button[data-role="campo-siguiente"][data-campo="' + nombre + '"]').show();
  // $(ordenItemsSimulador[contadorFormularioSimulador] + ' input');
  contadorFormularioSimulador++;
  // console.log('Despues ' + contadorFormularioSimulador);
}

function inicializarFormularioSimulador() {
  desactivarInputs();
  contadorFormularioSimulador = 0;
  $(ordenItemsSimulador[contadorFormularioSimulador]).show();
  $(ordenItemsSimulador[contadorFormularioSimulador] + ' input').show();
  var nombre = $(ordenItemsSimulador[contadorFormularioSimulador]).attr('name');
  if (nombre == undefined) {
    nombre = $(ordenItemsSimulador[contadorFormularioSimulador] + ' input').attr('name');
  }
  $('button[data-role="campo-siguiente"][data-campo="' + nombre + '"]').show();
  $.each(ordenItemsSimulador, function (index, selector) {
    var input = $(selector);
    var inputs = $(selector + ' input[type="text"]');
    var radios = $(selector + ' input[type="radio"]');
    var checks = $(selector + ' input[type="checkbox"]');
    input.on('keypress', function (e) {
      if (e.which === 13) {
        activarSiguienteItemSimulador();
        input.off('keypress');
      }
    });
    inputs.on('keypress', function (e) {
      if (e.which === 13) {
        activarSiguienteItemSimulador();
        inputs.off('keypress');
      }
    });
    radios.on('change', function (e) {
      activarSiguienteItemSimulador();
      radios.off('change');
      checks.off('change');
    });
    checks.on('change', function (e) {
      activarSiguienteItemSimulador();
      radios.off('change');
      checks.off('change');
    });
  })
  contadorFormularioSimulador = 1;
}

function validarAntiguedadCredito(idCredito) {
  var numeroDocumento = $('input[name="numeroDocumento"]').val();
  $.ajax({
    type: 'GET',
    async: true,
    data: {numeroDocumento: numeroDocumento, idCredito: idCredito },
    url: requestUrl + '/intranet/servicop/creditos/simulador/validar-antiguedad',
    dataType: 'json',
    beforeSend: function () {
      $('body').showLoading();
    },
    complete: function (data) {
      $('body').hideLoading();
    },
    success: function (data) {
      if (data.response == 0) {
        alert('No cumple con la antiguedad requerida para aplicar a esta linea de credito');
        desactivarInputs();
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
}

function validarAntiguedadCargo(idCredito) {
  var numeroDocumento = $('input[name="numeroDocumento"]').val();
  $.ajax({
    type: 'GET',
    async: true,
    data: {numeroDocumento: numeroDocumento, idCredito: idCredito },
    url: requestUrl + '/intranet/servicop/creditos/simulador/validar-cargo',
    dataType: 'json',
    beforeSend: function () {
      $('body').showLoading();
    },
    complete: function (data) {
      $('body').hideLoading();
    },
    success: function (data) {
      if (data.response == 0) {
        alert('No cumple con el cargo requerido para aplicar a esta linea de credito');
        desactivarInputs();
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
}

$('button[data-role="campo-siguiente"]').on("click", function (e) {
  e.preventDefault();
  activarSiguienteItemSimulador();
});

$('button[data-role="limpiar-formulario"]').on("click", function (e) {
  location.reload(true);
});

$('select[name="tipoLineaCredito"]').on("change", function (e) {
  var idTipoLineaCredito = $(this).val();
  $.ajax({
    type: 'GET',
    async: true,
    data: { idTipoLineaCredito: idTipoLineaCredito },
    url: requestUrl + '/intranet/servicop/creditos/simulador/render-select-lineas-credito',
    dataType: 'json',
    beforeSend: function () {
      $('body').showLoading();
    },
    complete: function (data) {
      $('body').hideLoading();
    },
    success: function (data) {
      $('#select-linea-credito').html(data.response);
      $('#widget-descripcion').html("");
      $('input[name="valor"]').val("");
      $('input[name="plazo"]').val("");
      $('input[name="interesMensual"]').val("");
      $('input[name="cupoMaximo"]').val("");
      $('input[name="plazoMaximo"]').val("");
      $('#forms-cuotas-extra').html("");
      $('#widget-parametros').html("");
      $('#widget-garantias').html("");
      $('#widget-garantias-combinadas').html("");
      $('#widget-cuotas-extra').html("");
      $('#widget-codeudor').hide();
      $('input.formatear-numero').numeric({allowMinus: false});
      $('input[name="nivel-endeudamiento-cuota"]').val(0);
      inicializarFormularioSimulador();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

function mostrarParametrosGenerales() {
  $('div[data-role="parametros-usuario-credito"][data-id-garantia="0"]').removeClass('hidden');
}

$('select[name="lineaCredito"]').on("change", function(e) {
  var idCredito = $(this).val();
  var credito = $('#form-creditos').serialize();
  $.ajax({
    type: 'POST',
    async: true,
    data: {idCredito: idCredito},
    url: requestUrl + '/intranet/servicop/creditos/simulador/render-widgets',
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      $('#widget-info-basica').html(data.response.infoBasica);
      $('#widget-cuotas-extra').html(data.response.tiposCuotaExtra);
      $('#widget-garantias').html(data.response.garantiasNoCombinadas);
      $('#widget-garantias-combinadas').html(data.response.garantiasCombinadas);
      $('#widget-parametros').html(data.response.parametros);
      $('#widget-descripcion').html(data.response.descripcion);
      $('input[name="valor"]').val("");
      $('input[name="plazo"]').val("");
      $('#forms-cuotas-extra').html("");
      $('input[name="nivel-endeudamiento-cuota"]').val(0);
      $('#widget-codeudor').hide();
      // consultarCupoMaximo(idCredito);
      // mostrarParametrosGenerales();
      $('input.formatear-numero').numeric({allowMinus: false});
      inicializarFormularioSimulador();
      validarAntiguedadCredito(idCredito);
      validarAntiguedadCargo(idCredito);
      preSeleccionarGarantia();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

function preSeleccionarGarantia() {
  var cantidadGarantias = $('#widget-garantias input').length;
  var cantidadGarantiasCombinadas = $('#widget-garantias-combinadas input').length;
  console.log(cantidadGarantias);
  console.log(cantidadGarantiasCombinadas);
  if (cantidadGarantias == 1 && cantidadGarantiasCombinadas == 0) {
    $('#widget-garantias input').prop('checked',true).trigger('click');
  } 
  if (cantidadGarantias == 0 && cantidadGarantiasCombinadas == 1) {
    $('#widget-garantias-combinadas input').prop("checked", true).trigger('click');
  }
}

// function consultarCupoMaximo(idCredito) {
//   var credito = $('#form-creditos').serialize();
//   $.ajax({
//     type: 'POST',
//     async: true,
//     data: {datos: credito},
//     url: requestUrl + '/intranet/servicop/creditos/simulador/consultar-cupo-maximo',
//     dataType: 'json',
//     beforeSend: function() {
//       $('body').showLoading();
//     },
//     complete: function(data) {
//       $('body').hideLoading();
//     },
//     success: function(data) {
//       $('input[name="cupoMaximo"]').val(data.response);
//       $('input[name="cupoMaximo"]').number(true,0);
//       if (data.response == 0) {
//         $('#container-cupo-maximo').hide();
//       } else {
//         $('#container-cupo-maximo').show();
//       }
//       //$('#widget-garantias-combinadas').html(data.response.garantiasCombinadas);
//     },
//     error: function(jqXHR, textStatus, errorThrown) {
//       $('body').hideLoading();
//     }
//   });
//   return false;
// }

function consultarCupoMaximo(idCredito) {
  $.ajax({
    type: 'GET',
    async: true,
    data: {idCredito: idCredito},
    url: requestUrl + '/intranet/servicop/creditos/simulador/consultar-cupo-maximo',
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      $('input[name="cupoMaximo"]').val(data.response);
      $('input[name="cupoMaximo"]').number(true,0);
      //$('#widget-garantias-combinadas').html(data.response.garantiasCombinadas);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
}

$(document).on('keyup', 'input[name="plazo"]', function () {
  var plazoMaximo = parseInt($('input[name="plazoMaximo"]').val());
  var actual = parseInt($(this).val());
  if(actual > plazoMaximo) {
    $(this).val(plazoMaximo);
  }else if($(this).val() < 0){
    $(this).val(0);
  }
});

// $(document).on('keyup', 'input[name="valor"]', function () {
//   var cupoMaximo = parseInt($('input[name="cupoMaximo"]').val());
//   var actual = parseInt($(this).val());
//   if(actual > cupoMaximo) {
//     $(this).val(cupoMaximo);
//   }else if($(this).val() < 0){
//     $(this).val(0);
//   }
// });

$(document).on('keyup', 'input[data-role="cuota-extra-valor"]', function () {
  var cupoMaximo = parseInt($(this).attr('data-maximo'));
  var actual = parseInt($(this).val());
  if(actual > cupoMaximo) {
    $(this).val(cupoMaximo);
  }else if($(this).val() < 0){
    $(this).val(0);
  }
});

$(document).on('click', "button[data-role='consultar']", function() {
  var plazo = 30;
  var idCuota = 1;
  $.ajax({
    type: 'GET',
    async: true,
    data: {idCuota: idCuota, plazo: plazo},
    url: requestUrl + '/intranet/servicop/creditos/simulador/render-form-cuota-extra',
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      $('#forms-cuotas-extra').append(data.response);
      $('input.formatear-numero').numeric({allowMinus: false});
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

// if (-1 != $.inArray(...))

function mostrarParametroGarantia(idGarantia) {
  $('div[data-role="parametros-usuario-credito"]').addClass('hidden');
  $('div[data-role="parametros-usuario-credito"][data-id-garantia="0"]').removeClass('hidden');
  $('div[data-role="parametros-usuario-credito"][data-id-garantia="'+ idGarantia +'"]').removeClass('hidden');
  $('input.formatear-numero').number(true,0);
}

function mostrarParametroGarantiaCombinadas() {
  $('div[data-role="parametros-usuario-credito"]').addClass('hidden');
  var selected = [];
  $('#widget-garantias-combinadas input:checked').each(function() {
    selected.push($(this).attr('name'));
  });
  $('div[data-role="parametros-usuario-credito"][data-id-garantia="0"]').removeClass('hidden');
  for (var i = selected.length - 1; i >= 0; i--) {
    var idGarantia = selected[i].slice(-1);
    $('div[data-role="parametros-usuario-credito"][data-id-garantia="'+ idGarantia +'"]').removeClass('hidden');
  }
  $('input.formatear-numero').number(true,0);
}

$(document).on('click', '#widget-cuotas-extra :checkbox', function () {
    var idCuota = $(this).attr('data-cuota-extra-id');
    if (!$(this).is(':checked')) {
      removerCuota(idCuota);
    } else {
      crearFormCuota(idCuota);
    }
});

$(document).on('click', '#widget-garantias :radio', function () {
    $('#widget-garantias-combinadas :checkbox').removeAttr("checked");
    if ($(this).attr('data-solicita-codeudor') == 1) {
      renderSelectCodeudor();
    } else {
      ocultarSelectCodeudor();
    }
    var idCredito = $('#selector-lineas-credito').val();
    // consultarCupoMaximo(idCredito);
    mostrarParametroGarantia($(this).val());
});

$(document).on('click', '#widget-garantias-combinadas :checkbox', function () {
    $('#widget-garantias :radio').attr('checked',false);
    if ($(this).attr('data-solicita-codeudor') == 1) {
      renderSelectCodeudor();
    } else {
      ocultarSelectCodeudor();
    }
    var idCredito = $('#selector-lineas-credito').val();
    // consultarCupoMaximo(idCredito);
    mostrarParametroGarantiaCombinadas();
});

function renderSelectCodeudor() {
  $('#widget-codeudor').show();
}

function ocultarSelectCodeudor() {
  $('#widget-codeudor').hide();
  $('#selector-codeudor').val('').trigger('change');
}

function crearFormCuota(idCuota) {
  var plazo = $('input[name="plazo"]').val();
  $.ajax({
    type: 'GET',
    async: true,
    data: {idCuota: idCuota, plazo: plazo},
    url: requestUrl + '/intranet/servicop/creditos/simulador/render-form-cuota-extra',
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      $('#forms-cuotas-extra').append(data.response);
      $('.formatear-numero').number(true,0);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
}

function removerCuota (idCuota) {
  $('#form-cuota-' + idCuota).remove();
}

function consultarNivelEndeudamientoCuota(cuotaQuincenal) {
  $.ajax({
      type: 'GET',
      async: true,
      data: {cuotaQuincenal: cuotaQuincenal},
      url: requestUrl + '/intranet/servicop/creditos/reportes/calcular-nivel-endeudamiento-cuota',
      dataType: 'json',
      beforeSend: function() {
        $('body').showLoading();
      },
      complete: function(data) {
        $('body').hideLoading();
      },
      success: function(data) {
        if (data.result == 'ok') {
          $('input[name="nivel-endeudamiento-cuota"]').val(data.response);
        } else {
          $('input[name="nivel-endeudamiento-cuota"]').val(0);
        }
        console.log(data);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('body').hideLoading();
      }
    });
}

$(document).on('click', 'button[data-role="simular-credito"]', function () {
  var credito = $('#form-creditos').serialize();
  var plazo = $('input[name="plazo"]').val();
  var valor = $('input[name="valor"]').val();
  if (plazo <= 0 || valor <= 0) {
    alert('Los campos Plazo y Valor a solicitar son requeridos');
  } else {

    // console.log(credito);
    $.ajax({
      type: 'POST',
      async: true,
      data: {datos: credito},
      url: requestUrl + '/intranet/servicop/creditos/simulador/simular',
      dataType: 'json',
      beforeSend: function() {
        $('body').showLoading();
      },
      complete: function(data) {
        $('body').hideLoading();
      },
      success: function(data) {
        if (data.result == 'ok') {
          $('input[name="valor-cuota"]').val(data.response).trigger('change');
          consultarNivelEndeudamientoCuota(data.response);
          // alert('Simulación completada. Ahora puede realizar la solicitud del credito');
        } else {
          $('input[name="valor-cuota"]').val(0).trigger('change');
          alert(data.response);
        }
        // console.log(data);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('body').hideLoading();
      }
    });
  }
})

$(document).on('change', 'input[name="valor-cuota"]', function () {
  var valor = $(this).val();
  // console.log(valor);
  if (valor == null || valor == 0 || valor == undefined) {
    $('button[data-role="solicitar-credito"]').attr('disabled', true);
    $('button[data-role="solicitar-credito"]').removeClass('btn-primary');
    $('button[data-role="solicitar-credito"]').addClass('btn-default');
  } else {
    $('button[data-role="solicitar-credito"]').removeAttr('disabled');
    $('button[data-role="solicitar-credito"]').removeClass('btn-default');
    $('button[data-role="solicitar-credito"]').addClass('btn-primary');
  }
})

$(document).on('change', '#form-creditos input, textarea', function () {
  $('#valor-cuota').val(0).trigger('change');
}) 

$(document).on('click', 'button[data-role="solicitar-credito"]', function () {
  if (confirm("Esta seguro que desea realizar la solicitud de credito?") == true) {
    var credito = $('#form-creditos').serialize();
    $.ajax({
      type: 'POST',
      async: true,
      data: {datos: credito},
      url: requestUrl + '/intranet/servicop/creditos/solicitudes/crear',
      dataType: 'json',
      beforeSend: function() {
        $('body').showLoading();
      },
      complete: function(data) {
        $('body').hideLoading();
      },
      success: function(data) {
        // $('input[name="valor-cuota"]').val(data.response);
        if (data.result == 'ok' && data.response != null) {
          console.log(data);
          alert('La solicitud fue generada con éxito');
          window.location.href = requestUrl + '/intranet/servicop/creditos/solicitudes/detalle?idSolicitud=' + data.response.idSolicitud;
        }
        if (data.result == 'error') {
          alert(data.response.response);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('body').hideLoading();
      }
    });
  } else {
    $('input[name="nivel-endeudamiento-cuota"]').val(0);  
    $('input[name="valor-cuota"]').val(0).trigger('change');
    $('input[name="plazo"]').val(0);
    $('input[name="valor"]').val(0);
  }
})

$('select[id="tipo-linea-credito-detalle"]').on("change", function (e) {
  var idTipoLineaCredito = $(this).val();
  $.ajax({
    type: 'GET',
    async: true,
    data: { idTipoLineaCredito: idTipoLineaCredito },
    url: requestUrl + '/intranet/servicop/creditos/default/render-select-linea',
    dataType: 'json',
    beforeSend: function () {
      $('body').showLoading();
    },
    complete: function (data) {
      $('body').hideLoading();
    },
    success: function (data) {
      $('#select-detalle-linea').html(data.response);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

// Carga de documentos Creditos
var forms = $('form.cargar-documento');
forms.on('submit', function(ev) {
  var oData = new FormData(this);
  $.ajax({
    type: 'POST',
    async: true,
    data: oData,
    url: requestUrl + '/intranet/servicop/creditos/solicitudes/cargar-documento',
    dataType: 'json',
    contentType: false,
    processData: false,
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      // console.log(oData.get('idSolicitud'));
      if (data.result == 'ok') {
        alert('Se ha cargado correctamente el documento');
        $('button[data-id-documento="'+ oData.get('idSolitudDocumento') +'"]').removeClass('hidden');
        // alert('Usted puede hacer seguimiento de su solicitud de crédito por la opción Historial de la solicitud de crédito');
        // renderWidgetDocumentos(oData.get('idSolicitud'));

        // console.log("renderizado");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  ev.preventDefault();
  // return false;
});

// function asignarEventListenerDocumentosCreditos() {
//   // forms = $('form.cargar-documento');
//   // console.log("forms");
//   forms.on('submit', function(ev) {
//     var oData = new FormData(this);
//     console.log(data.get('idSolicitud'));
//     $.ajax({
//       type: 'POST',
//       async: true,
//       data: oData,
//       url: requestUrl + '/intranet/servicop/creditos/solicitudes/cargar-documento',
//       dataType: 'json',
//       contentType: false,
//       processData: false,
//       beforeSend: function() {
//         $('body').showLoading();
//       },
//       complete: function(data) {
//         $('body').hideLoading();
//       },
//       success: function(data) {
//         // console.log(oData.get('idSolicitud'));
//         if (data.result == 'ok') {
//           alert('Se ha cargado correctamente el documento');
//           // alert('Usted puede hacer seguimiento de su solicitud de crédito por la opción Historial de la solicitud de crédito');
//           renderWidgetDocumentos(oData.get('idSolicitud'));
//           // console.log("renderizado");
//         }
//       },
//       error: function(jqXHR, textStatus, errorThrown) {
//         $('body').hideLoading();
//       }
//     });
//     ev.preventDefault();
//     return false;
//   });
// }

// asignarEventListenerDocumentosCreditos();

function renderWidgetDocumentos(idSolicitud) {

  $.ajax({
    type: 'POST',
    async: true,
    url: requestUrl + '/intranet/servicop/creditos/solicitudes/render-widget-documentos?idSolicitud=' + idSolicitud,
    dataType: 'json',
    contentType: false,
    processData: false,
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      // console.log(data);
      if (data.result == 'ok') {
        $('div[data-role="widgetDocumentosSolicitudCredito"').html(data.response);
        // asignarEventListenerDocumentosCreditos();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
}

  
$(document).ready(function () {
  $('body').on('beforeSubmit', 'form#form-resena', function () {
      var form = $(this);
      // return false if form still have some validation errors
      $.ajax({
        type: 'POST',
        async: true,
        data: form.serialize(),
        url: requestUrl + '/intranet/formacioncomunicaciones/contenido/crear-resena',
        dataType: 'json',
        beforeSend: function() {
          $('body').showLoading();
        },
        complete: function(data) {
          $('body').hideLoading();
        },
        success: function(data) {
          // $('input[name="valor-cuota"]').val(data.response);
          $('#resumen-resenas-contenido').html(data.response.resumen);
          $('#comentarios-contenido').html(data.response.resenas);
          $('#crear-resena').html(data.response.promedio);
          $('#form-resena')[0].reset();
          $('#modal-form-calificacion').modal('hide');
          var $input = $('input[name="rating_1"]'); // or $('#input-id')
          $input.rating({
            'displayOnly' : true,
              'showClear': false,
              'showCaption' : false,
              'filledStar' : '<i class="glyphicon glyphicon-star"></i>',
              'emptyStar' : '<i class="glyphicon glyphicon-star-empty"></i>',
              'size' : 'xs'
          });
          alert('Calificación guardada correctamente');
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('body').hideLoading();
        }
      });
          // submit form
      return false;
   });
});


// Contribuciones Servicop
$('select[name="contribucion"]').on("change", function(e) {
  var idContribucion = $(this).val();
  $.ajax({
    type: 'GET',
    async: true,
    data: {idContribucion: idContribucion},
    url: requestUrl + '/intranet/servicop/contribuciones/solicitudes/render-widget-parentesco',
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      $('#widget-parentesco-contribucion').html(data.response);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});

$(document).on('change', 'select[name="id-parentesco"]', function () {
  var idParentesco = $(this).val();
  $.ajax({
      type: 'GET',
      async: true,
      data: {idParentesco: idParentesco},
      url: requestUrl + '/intranet/servicop/contribuciones/solicitudes/render-widget-beneficiario',
      dataType: 'json',
      beforeSend: function() {
        $('body').showLoading();
      },
      complete: function(data) {
        $('body').hideLoading();
      },
      success: function(data) {
        $('#widget-beneficiario-contribucion').html(data.response);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('body').hideLoading();
      }
    });
});

$(document).on('click', 'button[data-role="solicitar-contribucion"]', function () {
  var form = $('#form-solicitar-contribucion').serialize();
  $.ajax({
      type: 'POST',
      async: true,
      data: {datos: form},
      url: requestUrl + '/intranet/servicop/contribuciones/solicitudes/solicitar',
      dataType: 'json',
      beforeSend: function() {
        $('body').showLoading();
      },
      complete: function(data) {
        $('body').hideLoading();
      },
      success: function(data) {
        // $('#widget-beneficiario-contribucion').html(data.response);
        if (data.result == 'ok') {
          window.location.href = requestUrl + '/intranet/servicop/contribuciones/solicitudes/detalle?idSolicitudContribucion=' + data.response.idSolicitudContribucion;
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('body').hideLoading();
      }
    });
  return false;
});

var forms = $('form.cargar-documento-contribuciones');
if (forms != null) {
  for (var i = 0; i < forms.length; i++) {
    var form = forms[i];
    form.addEventListener('submit', function(ev) {
      var oData = new FormData(this);
      $.ajax({
        type: 'POST',
        async: true,
        data: oData,
        url: requestUrl + '/intranet/servicop/contribuciones/solicitudes/cargar-documento',
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function() {
          $('body').showLoading();
        },
        complete: function(data) {
          $('body').hideLoading();
        },
        success: function(data) {
          console.log(data);
          if (data.result == 'ok') {
            alert('Se ha cargado correctamente el documento');
          }
          // ToDo: Actualizar boton de descargar documento
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('body').hideLoading();
        }
      });
      ev.preventDefault();
    }, false)
  };
};

$(document).on('click', 'button[data-role="radicar-contribucion"]', function () {
  var idSolicitud = $(this).attr('data-id-solicitud');
  $.ajax({
      type: 'POST',
      async: true,
      data: {idSolicitud: idSolicitud},
      url: requestUrl + '/intranet/servicop/contribuciones/solicitudes/radicar',
      dataType: 'json',
      beforeSend: function() {
        $('body').showLoading();
      },
      complete: function(data) {
        $('body').hideLoading();
      },
      success: function(data) {
        alert(data.response);
        actualizarWidgetDocumentosSolicitudContribucion();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('body').hideLoading();
      }
    });
  return false;
});

$(document).on('click', 'button[data-role="radicar-credito"]', function () {
  var idSolicitud = $(this).attr('data-id-solicitud');
  if (confirm("¿Esta seguro que desea confirmar la solicitud?")) {
    $.ajax({
        type: 'POST',
        async: true,
        data: {idSolicitud: idSolicitud},
        url: requestUrl + '/intranet/servicop/creditos/solicitudes/radicar',
        dataType: 'json',
        beforeSend: function() {
          $('body').showLoading();
        },
        complete: function(data) {
          $('body').hideLoading();
        },
        success: function(data) {
          alert(data.response);
          if (data.result == 'ok') {
            actualizarWidgetDocumentosSolicitudCredito();
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('body').hideLoading();
        }
      });
    return false;
  }
});


$(document).ready(function () {
  $('input.formatear-numero').number(true,0);
  $('a[data-pop-over="popover"').popover();
});

function actualizarWidgetDocumentosSolicitudCredito() {
  var idSolicitud = $('button[data-role="radicar-credito"]').attr('data-id-solicitud');
  $.ajax({
      type: 'GET',
      async: true,
      data: {idSolicitud: idSolicitud},
      url: requestUrl + '/intranet/servicop/creditos/solicitudes/render-widget-documentos',
      dataType: 'json',
      beforeSend: function() {
        $('body').showLoading();
      },
      complete: function(data) {
        $('body').hideLoading();
      },
      success: function(data) {
        $('div[data-role="widgetDocumentosSolicitudCredito"').html(data.response);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('body').hideLoading();
      }
    });
}

function actualizarWidgetDocumentosSolicitudContribucion() {
  var idSolicitud = $('button[data-role="radicar-contribucion"]').attr('data-id-solicitud');
  $.ajax({
      type: 'GET',
      async: true,
      data: {idSolicitud: idSolicitud},
      url: requestUrl + '/intranet/servicop/contribuciones/solicitudes/render-widget-documentos',
      dataType: 'json',
      beforeSend: function() {
        $('body').showLoading();
      },
      complete: function(data) {
        $('body').hideLoading();
      },
      success: function(data) {
        $('div[data-role="widgetDocumentosSolicitudContribucion"').html(data.response);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('body').hideLoading();
      }
    });
}

$(document).on('click', 'button[data-role="descargar-documento-creditos"]', function (e) {
  e.preventDefault();
  var idSolicitudDocumento = $(this).attr('data-id-documento');
  window.location = requestUrl + '/intranet/servicop/creditos/solicitudes/descargar-archivo?idSolicitudDocumento=' + idSolicitudDocumento;
  return false;
})

$(document).on('click', 'button[data-role="descargar-formato-creditos"]', function (e) {
  e.preventDefault();
  var idSolicitudDocumento = $(this).attr('data-id-documento');
  window.location = requestUrl + '/intranet/servicop/creditos/solicitudes/descargar-formato?idSolicitudDocumento=' + idSolicitudDocumento;
  return false;
})

$(document).on('click', 'button[data-role="descargar-documento-contribuciones"]', function (e) {
  e.preventDefault();
  var idSolicitudDocumento = $(this).attr('data-id-documento');
  window.location = requestUrl + '/intranet/servicop/contribuciones/solicitudes/descargar-archivo?idSolicitudDocumento=' + idSolicitudDocumento;
  return false;
})
