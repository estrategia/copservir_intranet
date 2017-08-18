//::::::::::::::::::::::
// LINEAS DE TIEMPO
//::::::::::::::::::::::

/*
 * peticion ajax para cambiar de linea de tiempo
 */

function cambiarTimeline(lineaTiempo, href) {

    $.ajax({
        type: 'GET',
        async: true,
        url: requestUrl + '/intranet/sitio/cambiar-linea-tiempo',
        data: {lineaTiempo: lineaTiempo},
        dataType: 'json',
        beforeSend: function () {
            $('html').showLoading();
        },
        complete: function (data) {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == "ok") {
                $(".lineastiempo").html("");
                $(href).html(data.response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
        }
    });
}

$(document).on('click', "a[data-role='cambiar-timeline']", function () {
    var lineaTiempo = $(this).attr('data-timeline');
    var href = $(this).attr('href');
    cambiarTimeline(lineaTiempo, href);
});

$(document).on('click', "a[data-role='agregar-destino-contenido']", function () {

    $.ajax({
        type: 'GET',
        async: true,
        url: requestUrl + '/intranet/contenido/agregar-destino',
        dataType: 'json',
        beforeSend: function () {
            $('html').showLoading()
        },
        complete: function (data) {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == "ok") {
                $("#contenido-destino").append(data.response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();

        }
    });
    return false;
});

$(document).on('click', "a[data-role='ver-contenido-administrable']", function () {

    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/intranet/modulos-administrables/ver-contenido',
        dataType: 'json',
        data: {contenido: $(this).attr('data-contenido')},
        beforeSend: function () {
            $('html').showLoading();
            $("#modal-contenido-administrable").remove();
        },
        complete: function (data) {
            $('html').hideLoading();

        },
        success: function (data) {
            $('body').append(data);
            $("#modal-contenido-administrable").modal("show");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
        }
    });
    return false;
});

$(document).on('change', "#premio-tiporedimir", function () {
	
    if($(this).val() == 2){
        $("#cuestionario_redimir").css('display','block');
        $("#puntos_redimir").css('display','none');
    }else{
    	$("#cuestionario_redimir").css('display','none');
        $("#puntos_redimir").css('display','block');
    }
    
});

$(document).on('click', "a[data-role='quitar-destino-contenido']", function () {
    $($(this).attr('data-row')).remove();
    return false;
});


/*
 * peticion ajax para guardar un contenido de una publicacion
 */
$(document).on('click', "a[data-role='guardar-contenido']", function () {

    var formElement = document.getElementById("form-contenido-publicar");
    var formData = new FormData(formElement);
    var href = $(this).attr('data-href');
    var files = $('#contenido-imagenes').fileinput('getFileStack');

    if (files.length > 0) {
        $.each(files, function (key, data) {
            formData.append('imagenes[]', data, files[key].name);
        });
    }

    $.ajax({
        type: 'POST',
        processData: false,
        contentType: false,
        url: requestUrl + '/intranet/sitio/guardar-contenido',
        data: formData,
        dataType: 'json',
        beforeSend: function () {
            $('html').showLoading();
        },
        complete: function (data) {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == "ok") {
                $(".lineastiempo").html("");
                $(href).html(data.response);
                $('#publicarContenido').toggle('slow');
                $("#mostrarFormularioContenido").text('ocultar formulario')
            }

            if (data.result == 'error') {
              alert('Error:'+ data.error);
              $('html').hideLoading();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            alert(jqXHR.responseText);
        }
    });

    return false;
});

/*
 * peticion ajax para guardar un contenido de una publicacion en el template
 * publicar portales.
 */
$(document).on('click', "a[data-role='guardar-contenido-publicar-portales']", function () {

    var formElement = document.getElementById("form-contenido-publicar-portales");
    var formData = new FormData(formElement);
    var href = $(this).attr('data-href');
    var files = $('#contenido-imagenes').fileinput('getFileStack');

    if (files.length > 0) {
        $.each(files, function (key, data) {
            formData.append('imagenes[]', data, files[key].name);
        });
    }

    $.ajax({
        type: 'POST',
        processData: false,
        contentType: false,
        url: requestUrl + '/intranet/sitio/publicar-portales-crear',
        data: formData,
        dataType: 'json',
        beforeSend: function () {
            $('html').showLoading();
        },
        complete: function (data) {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == "ok") {
              $('.publicar-portales').remove();
              $('.formulario').append(data.response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            $("#btnAgregarContenido").attr('disabled', false);
        }
    });

    return false;
});

$(document).on('click', "a[data-role='actualizar-contenido-publicar-portales']", function () {

    var idNoticia = $(this).attr('data-noticia');
    var formElement = document.getElementById("form-contenido-publicar-portales");
    var formData = new FormData(formElement);
    var href = $(this).attr('data-href');
    var files = $('#contenido-imagenes').fileinput('getFileStack');

    if (files.length > 0) {
        $.each(files, function (key, data) {
            formData.append('imagenes[]', data, files[key].name);
        });
    }

    $.ajax({
        type: 'POST',
        processData: false,
        contentType: false,
        url: requestUrl + '/intranet/sitio/publicar-portales-actualizar?id='+idNoticia,
        data: formData,
        dataType: 'json',
        beforeSend: function () {
            $('html').showLoading();
        },
        complete: function (data) {
            $('html').hideLoading();
            location.reload();
        },
        success: function (data) {
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            $("#btnAgregarContenido").attr('disabled', false);
        }
    });
    return false;
});

//::::::::::::::::::::::
// MENU
//::::::::::::::::::::::
/*
 * peticion ajax para cambiar agregar una opcion del menu
 */
$(document).on('click', "input[data-role='agregar-opcion']", function () {

    var idMenu = $(this).attr('data-id');
    var isChecked = ($(this).is(':checked')) ? 1 : 0;

    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/intranet/sitio/agregar-opcion-menu',
        data: {idMenu: idMenu, value: isChecked},
        dataType: 'json',
        beforeSend: function () {
            $('html').showLoading();
        },
        complete: function (data) {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == "ok") {
              $('.list-menu-corporativo').remove();
              $(data.response).insertAfter('#list-menu-corporativo');
              $.Webarch.init();
              //document.insertBefore(data.response, document.getElementById('list-menu-corporativo'));
            }else{
                alert(data.response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
        }
    });
});

$(document).on('click', "a[data-role='me-gusta-contenido']", function () {

    var idContenido = $(this).attr('data-contenido');
    var val = $(this).attr('data-value');

    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/intranet/sitio/me-gusta-contenido',
        data: {idContenido: idContenido, value: val},
        dataType: 'json',
        beforeSend: function () {
            $('html').showLoading()
        },
        complete: function (data) {
            $('html').hideLoading();

        },
        success: function (data) {
            if (data.result == "ok") {
                $('#numero-megusta-ajax_' + idContenido).addClass('badge badge-info pull-right');
                $('#numero-megusta-ajax_' + idContenido).html(data.response);
                console.log(data.response);
                if (val == 1) {
                    $("#megusta_" + idContenido).css('display', 'none');
                    $("#no_megusta_" + idContenido).css('display', '');
                } else {
                    $("#no_megusta_" + idContenido).css('display', 'none');
                    $("#megusta_" + idContenido).css('display', '');
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();

        }
    });
});

$(document).on('click', "button[data-role='guardar-comentario-contenido']", function () {

    var idContenido = $(this).attr('data-contenido');
    var comentario = $('#comentario_' + idContenido).val();

    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/intranet/sitio/guardar-comentario',
        data: {idContenido: idContenido, comentario: comentario},
        dataType: 'json',
        beforeSend: function () {
            $('html').showLoading()
            $('#comentario_' + idContenido).prop('disabled', true);
            $(".comentar").attr('disabled', true);
        },
        complete: function (data) {
            $('html').hideLoading();
            $(".comentar").attr('disabled', false);
            $('#comentario_' + idContenido).prop('disabled', false);
        },
        success: function (data) {
            if (data.result == "ok") {
                $("#contenido_" + idContenido).html(data.response);
            }

        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            $('#comentario_' + idContenido).prop('disabled', false);
            $(".comentar").attr('disabled', false);
        }
    });
});

$(document).on('click', 'a[data-role="listado-me-gusta-contenido"]', function () {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/contenido/listado-me-gusta-contenido',
        data: {render: true, idContenido: $(this).attr('data-contenido')},
        beforeSend: function () {
            $("#modal-me-gusta-contenido").remove();
            $('html').showLoading()
        },
        complete: function () {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == 'ok') {
                $('body').append(data.response);
                $("#modal-me-gusta-contenido").modal("show");
            } else {
                alert(data.response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});

$(document).on('click', 'a[data-role="listado-comentarios-contenido"]', function () {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/contenido/listado-comentarios-contenido',
        data: {render: true, idContenido: $(this).attr('data-contenido')},
        beforeSend: function () {
            $("#modal-comentarios-contenido").remove();
            $('html').showLoading()
        },
        complete: function () {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == 'ok') {
                $('body').append(data.response);
                $("#modal-comentarios-contenido").modal("show");
            } else {
                alert(data.response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();

            alert('Error: ' + errorThrown);
        }
    });
    return false;
});

// renderiza el modal del denuncio contenido
$(document).on('click', 'a[data-role="denunciar-contenido"]', function () {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/contenido/denunciar-contenido',
        data: {render: true, idContenido: $(this).attr('data-contenido'), idLineaTiempo: $(this).attr('data-linea-tiempo')},
        beforeSend: function () {
            $("#modal-comentarios-contenido").remove();
            $('html').showLoading()
        },
        complete: function () {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == 'ok') {
                $('.div-modal-denuncio-contenido').append(data.response);
                $("#modal-contenido-denuncio").modal("show");
            } else {
                alert(data.response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});

//guarda el denuncio de un contenido
$(document).on('click', 'button[data-role="guardar-denuncio-contenido"]', function () {

    var form = $("#form-contenido-denuncio")
    var elemento = $(this).attr('data-linea-tiempo');

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/contenido/guardar-denuncio-contenido',
        data: form.serialize(),
        beforeSend: function () {
            $('html').showLoading();
        },
        complete: function () {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == 'ok') {
                $("#lt" + elemento).html(data.response);
                $("#modal-contenido-denuncio").modal("hide");
            } else {
                $("#modal-contenido-denuncio").modal("hide");
                $('#modal-contenido-denuncio').on('hidden.bs.modal', function (e) {
                  $(".div-modal-denuncio-contenido").html(data.response);
                  $("#modal-contenido-denuncio").modal("show");
                })
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
        }
    });
    return false;
});

$(document).on('click', 'a[data-role="eliminar-comentario"]', function () {

    var idComentario = $(this).attr("data-comentario");
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/contenido/eliminar-comentario',
        data: {idComentario: idComentario},
        beforeSend: function () {
            $('html').showLoading()
        },
        complete: function () {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == 'ok') {
                $("#numero-comentarios_"+data.idContenido).empty();
                $("#numero-comentarios_"+data.idContenido).append(data.numeroComentarios);
                $("#comentarios_contenido").html(data.response);
            } else {
                alert(data.response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});

// renderiza el modal para eliminar un comentario
$(document).on('click', 'a[data-role="denunciar-comentario"]', function () {

    var idComentario = $(this).attr("data-comentario");
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/contenido/denunciar-comentario',
        data: {idComentario: idComentario},
        beforeSend: function () {
            $("#modal-comentario-denuncio").remove();
            $('html').showLoading()
        },
        complete: function () {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == 'ok') {
                $("#modal-comentarios-contenido").modal('hide');
                $('body').append(data.response);
                $("#modal-comentario-denuncio").modal('show');
            } else {
                alert(data.response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});

// guarda el denuncio de un comentario
$(document).on('click', 'button[data-role="guardar-denuncio-comentario"]', function () {

    var form = $("#form-comentario-denuncio")
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/contenido/guardar-denuncio-comentario',
        data: form.serialize(),
        beforeSend: function () {
            $('html').showLoading()
        },
        complete: function () {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == 'ok') {
                $("#modal-comentario-denuncio").modal('hide');
            } else {
                $("#modal-comentario-denuncio").modal("hide");
                $('#modal-comentario-denuncio').on('hidden.bs.modal', function (e) {
                  $('#modal-comentario-denuncio').remove();
                  $("body").append(data.response);
                  $("#modal-comentario-denuncio").modal("show");
                })
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});

$(document).on('click', 'a[data-role="quitar-elemento"]', function () {

    var elemento = $(this).attr('data-elemento');
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/sitio/quitar-elemento',
        data: {elemento: elemento, opcion: 2},
        beforeSend: function () {
            $('html').showLoading();
        },
        complete: function () {
            $('html').hideLoading();
        },
        success: function (data) {
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});

$(document).on('click', 'input[data-role="toggle-elemento"]', function () {

    var elemento = $(this).attr('data-elemento');
    var opcion = $(this).prop('checked') ? 1 : 2;

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/sitio/quitar-elemento',
        data: {elemento: elemento, opcion: opcion},
        beforeSend: function () {
            $('html').showLoading()
        },
        complete: function () {
            $('html').hideLoading();
        },
        success: function (data) {
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();

            alert('Error: ' + errorThrown);
        }
    });

});

$(document).on('click', 'a[data-role="agregar-modulo"]', function () {

    var idModulo = $(this).attr('data-modulo');
    var idGrupo = $("#idGrupo").val();

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/modulos-administrables/agregar-modulo',
        data: {idModulo: idModulo, idGrupo: idGrupo},
        beforeSend: function () {
            $('html').showLoading()
        },
        complete: function () {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == 'ok') {
                $("#tabla_agregados").yiiGridView("applyFilter");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});

$(document).on('click', 'a[data-role="eliminar-modulo"]', function () {

    var idModulo = $(this).attr('data-modulo');
    var idGrupo = $("#idGrupo").val();

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/modulos-administrables/eliminar-modulo',
        data: {idModulo: idModulo, idGrupo: idGrupo},
        beforeSend: function () {
            $('html').showLoading()
        },
        complete: function () {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == 'ok') {
                $("#tabla_agregados").yiiGridView("applyFilter");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});

$(document).on('click', 'a[data-role="editar-modulo"]', function () {

    var idModulo = $(this).attr('data-modulo');
    var idGrupo = $("#idGrupo").val();
    var orden = $("#orden_" + idModulo).val();

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/modulos-administrables/editar-modulo',
        data: {idModulo: idModulo, idGrupo: idGrupo, orden: orden},
        beforeSend: function () {
            $('html').showLoading()
        },
        complete: function () {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == 'ok') {
                $("#tabla_agregados").yiiGridView("applyFilter");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});



$('#selectCiudadVisualizacion').change(function() {
   $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/intranet/sitio/cambiar-ciudad-visualizacion',
        data: {codigoCiudad: $(this).val()},
        dataType: 'json',
        beforeSend: function () {
            $('html').showLoading();

        },
        complete: function (data) {
            $('html').hideLoading();
        },
        success: function (data) {
            console.log(data);
            location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            alert('Error: ' + errorThrown);
        }
   });
console.log($(this).val());
});


$(document).on('click', 'a[data-role="redimir-premio"]', function () {

	var idPremio = $(this).attr('data-premio');
    var cantidad = $("#cantidad_"+idPremio).val();

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/formacioncomunicaciones/premios/verificar-redimir',
        data: {idPremio: idPremio, cantidad: cantidad},
        beforeSend: function () {
            $('html').showLoading()
        },
        complete: function () {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == 'ok') {
            	alert(data.response);
            }else{
            	alert(data.response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});


$(document).on('click','button[data-role="tramitar-redenciones"]',function() {
	var keys = $('#gridRedenciones').yiiGridView('getSelectedRows');
	var estado = $(this).attr('data-estado');
	var observaciones = $("#observacion").val();
	var fechaEntrega = $("#fecha_entrega").val();
	$.post({
	   url: requestUrl + '/intranet/formacioncomunicaciones/premios/cambiar-estado-redencion',
	   dataType: 'json',
	   data: {premios: keys, estado:estado,fechaEntrega:fechaEntrega,observaciones:observaciones},
	   success: function(data) {
	      if (data.result === 'ok') {
	    	  
	    	  $("#gridRedenciones").yiiGridView("applyFilter");
	      }else{
	    	  alert(data.response);
	      }
	   },
	});
});



$(document).on('click', 'button[data-role="guardarRespuesta"]', function () {

    var form = $("#formOpciones");
   
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/formacioncomunicaciones/cuestionario/guardar-opcion-respuesta',
        data: form.serialize(),
        beforeSend: function () {
            $('html').showLoading()
        },
        complete: function () {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == 'ok') {
                $("#opciones-agregadas").yiiGridView("applyFilter");
            }else{
            	alert(data.response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});

$(document).on('click', 'button[data-role="guardarRespuestaFalsoVerdadero"]', function () {

    var form = $("#formOpciones");
   
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/formacioncomunicaciones/cuestionario/guardar-opcion-respuesta',
        data: form.serialize(),
        beforeSend: function () {
            $('html').showLoading()
        },
        complete: function () {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == 'ok') {
                $("#opciones-agregadas").yiiGridView("applyFilter");
            }else{
            	alert(data.response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});

$(document).on('click', 'button[data-role="guardarPreguntaCompletar"]', function () {

    var form = $("#formOpciones");
   
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/formacioncomunicaciones/cuestionario/guardar-pregunta-completar',
        data: form.serialize(),
        beforeSend: function () {
            $('html').showLoading()
        },
        complete: function () {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == 'ok') {
                $("#preguntas-agregadas").yiiGridView("applyFilter");
            }else{
            	alert(data.response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});

$(document).on('click', 'a[data-role="eliminar-opcion"]', function () {

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/formacioncomunicaciones/cuestionario/eliminar-opcion',
        data: {idOpcionRespuesta:$(this).attr('data-opcion-respuesta')},
        beforeSend: function () {
            $('html').showLoading()
        },
        complete: function () {
            $('html').hideLoading();
        },
        success: function (data) {
            if (data.result == 'ok') {
                $("#opciones-agregadas").yiiGridView("applyFilter");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});

$(document).on('click', 'a[data-role="agregar-opciones-completar"]', function () {

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/formacioncomunicaciones/cuestionario/agregar-opciones-completar',
        data: {idPregunta:$(this).attr('data-pregunta')},
        beforeSend: function () {
        	$('html').showLoading();
        	$("#modal-opciones-completar").remove();
        },
        complete: function () {
            $('html').hideLoading();
        },
        success: function (data) {
        	$('body').append(data.response);
        	$("#modal-opciones-completar").modal("show");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});

$(document).on('click', 'button[data-role="guardar-respuesta-completar"]', function () {

	  var form = $("#form-opciones-completar");

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/formacioncomunicaciones/cuestionario/guardar-opcion-completar',
        data: form.serialize(),
        beforeSend: function () {
        	$('html').showLoading();
        },
        complete: function () {
            $('html').hideLoading();
        },
        success: function (data) {
        	if(data.result == 'ok'){
        		$("#tabla-opciones").html(data.response);
        	}else{
        		alert(data.response);
        	}
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});

$(document).on('click', 'a[data-role="editar-opcion"]', function () {

  $.ajax({
      type: 'POST',
      dataType: 'json',
      async: true,
      url: requestUrl + '/intranet/formacioncomunicaciones/cuestionario/editar-opcion-modal',
      data: {idOpcionRespuesta: $(this).attr('data-opcion-respuesta')},
      beforeSend: function () {
    		$('html').showLoading();
        	$("#modal-editar-opciones").remove();
      },
      complete: function () {
          $('html').hideLoading();
      },
      success: function (data) {
      	if(data.result == 'ok'){
      		$('body').append(data.response);
        	$("#modal-editar-opciones").modal("show");
      	}else{
      		alert(data.response);
      	}
      },
      error: function (jqXHR, textStatus, errorThrown) {
          $('html').hideLoading();
          alert('Error: ' + errorThrown);
      }
  });
  return false;
});

$(document).on('click', 'button[data-role="actualizar-opcion-respuesta"]', function () {

	  $.ajax({
	      type: 'POST',
	      dataType: 'json',
	      async: true,
	      url: requestUrl + '/intranet/formacioncomunicaciones/cuestionario/guardar-opcion-editar',
	      data: $("#form-opciones-editar").serialize(),
	      beforeSend: function () {
	    		$('html').showLoading();
	      },
	      complete: function () {
	          $('html').hideLoading();
	      },
	      success: function (data) {
	      	if(data.result == 'ok'){
	      		$("#modal-editar-opciones").remove();
	      		$("#opciones-agregadas").yiiGridView("applyFilter");
	      	}else{
	      		alert(data.response);
	      	}
	      },
	      error: function (jqXHR, textStatus, errorThrown) {
	          $('html').hideLoading();
	          alert('Error: ' + errorThrown);
	      }
	  });
	  return false;
	});

$(document).on('change', '#cuestionario-idcurso', function () {
	 $.ajax({
	      type: 'POST',
	      dataType: 'json',
	      async: true,
	      url: requestUrl + '/intranet/formacioncomunicaciones/cuestionario/buscar-contenidos',
	      data: {idCurso: $(this).val()},
	      beforeSend: function () {
	    		$('html').showLoading();
	      },
	      complete: function () {
	          $('html').hideLoading();
	      },
	      success: function (data) {
	      	if(data.result == 'ok'){
	      		$("#cuestionario-idcontenido").html(data.response);
	      	}else{
	      		alert(data.response);
	      	}
	      },
	      error: function (jqXHR, textStatus, errorThrown) {
	          $('html').hideLoading();
	          alert('Error: ' + errorThrown);
	      }
	  });
	
});

$(document).on('click', 'a[data-role="visualizar-pregunta"]', function () {

	  $.ajax({
	      type: 'POST',
	      dataType: 'json',
	      async: true,
	      url: requestUrl + '/intranet/formacioncomunicaciones/cuestionario/visualizar-pregunta-demo',
	      data: {idPregunta: $(this).attr('data-pregunta')},
	      beforeSend: function () {
	    		$('html').showLoading();
	    		$("#modal-visualizacion-pregunta").remove();
	      },
	      complete: function () {
	          $('html').hideLoading();
	      },
	      success: function (data) {
	      	if(data.result == 'ok'){
	      		$('body').append(data.response);
	      		$("#modal-visualizacion-pregunta").modal('show');
	      	}else{
	      		alert(data.response);
	      	}
	      },
	      error: function (jqXHR, textStatus, errorThrown) {
	          $('html').hideLoading();
	          alert('Error: ' + errorThrown);
	      }
	  });
	  return false;
	});
