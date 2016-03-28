/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 //::::::::::::::::::::::
 // LINEAS DE TIEMPO
 //::::::::::::::::::::::

/*
* peticion ajax para cambiar de linea de tiempo
*/
$(document).on('click', "a[data-role='cambiar-timeline']", function() {

    var lineaTiempo = $(this).attr('data-timeline');
    var href = $(this).attr('href');
    $.ajax({
        type: 'GET',
        async: true,
        url: requestUrl + '/intranet/sitio/cambiar-linea-tiempo',
        data: {lineaTiempo: lineaTiempo},
        dataType: 'json',
        beforeSend: function() {
        //    Loading.show();
        },

        complete: function(data) {
         //   Loading.hide();
        },
        success: function(data) {
            if (data.result == "ok") {
                $(".lineastiempo").html("");
                $(href).html(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {

        }
    });
});

$(document).on('click', "a[data-role='agregar-destino-contenido']", function() {

    $.ajax({
        type: 'GET',
        async: true,
        url: requestUrl + '/intranet/contenido/agregar-destino',

        dataType: 'json',
        beforeSend: function() {
        //    Loading.show();
        },

        complete: function(data) {
         //   Loading.hide();
        },
        success: function(data) {
            if (data.result == "ok") {
                $("#contenido-destino").append(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {

        }
    });
    return false;
});

$(document).on('click', "a[data-role='quitar-destino-contenido']", function() {
    $($(this).attr('data-row')).remove();
    return false;
});


/*
* peticion ajax para guardar un contenido de una publicacion
*/
$(document).on('click', "a[data-role='guardar-contenido']", function() {

    var form = $("#form-contenido-publicar");
    var href = $(this).attr('data-href');
    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/intranet/sitio/guardar-contenido',
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
                $("#modal-contenido-publicar").modal('hide')
                $(".lineastiempo").html("");
                $(href).html(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {

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
$(document).on('click', "input[data-role='agregar-opcion']", function() {

    var idMenu = $(this).attr('data-id');
    var isChecked = ($(this).is(':checked'))?1:0;

    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/intranet/sitio/agregar-opcion-menu',
        data: {idMenu: idMenu, value: isChecked },
        dataType: 'json',
        beforeSend: function() {
        //    Loading.show();
        },

        complete: function(data) {
         //   Loading.hide();
        },
        success: function(data) {
            if (data.result == "ok") {

            }
        },
        error: function(jqXHR, textStatus, errorThrown) {

        }
    });
});


$(document).on('click', "a[data-role='me-gusta-contenido']", function() {

    var idContenido = $(this).attr('data-contenido');
    var val = $(this).attr('data-value');

    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/intranet/sitio/me-gusta-contenido',
        data: {idContenido: idContenido, value:val },
        dataType: 'json',
        beforeSend: function() {
        //    Loading.show();
        },

        complete: function(data) {
         //   Loading.hide();
        },
        success: function(data) {
            if (data.result == "ok") {
                $('#numero-megusta_'+idContenido).html(data.response);

                if(val == 1){
                    $("#megusta_"+idContenido).css('display','none');
                    $("#no_megusta_"+idContenido).css('display','');
                }else{
                    $("#no_megusta_"+idContenido).css('display','none');
                    $("#megusta_"+idContenido).css('display','');
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {

        }
    });
});

$(document).on('click', "button[data-role='guardar-comentario-contenido']", function() {

    var idContenido = $(this).attr('data-contenido');
    var comentario = $('#comentario_'+idContenido).val();


    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/intranet/sitio/guardar-comentario',
        data: {idContenido: idContenido, comentario:comentario },
        dataType: 'json',
        beforeSend: function() {
        //    Loading.show();
            $('#comentario_'+idContenido).prop('disabled',true);
        },

        complete: function(data) {
         //   Loading.hide();
            $('#comentario_'+idContenido).prop('disabled',false);
        },
        success: function(data) {
            if (data.result == "ok") {
               $("#contenido_"+idContenido).html(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#comentario_'+idContenido).prop('disabled',false);
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
            //Loading.show();
        },
        complete: function () {
            //Loading.hide();
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
            //Loading.hide();
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
            //Loading.show();
        },
        complete: function () {
            //Loading.hide();
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
            //Loading.hide();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});


$(document).on('click', 'a[data-role="denunciar-contenido"]', function () {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/contenido/denunciar-contenido',
        data: {render: true, idContenido: $(this).attr('data-contenido'), idLineaTiempo: $(this).attr('data-linea-tiempo')},
        beforeSend: function () {
            $("#modal-comentarios-contenido").remove();
            //Loading.show();
        },
        complete: function () {
            //Loading.hide();
        },
        success: function (data) {
            if (data.result == 'ok') {
                $('body').append(data.response);
                $("#modal-contenido-denuncio").modal("show");

            } else {
                alert(data.response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //Loading.hide();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});


$(document).on('click', 'button[data-role="guardar-denuncio-contenido"]', function () {

    var form = $("#form-contenido-denuncio")
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/contenido/guardar-denuncio-contenido',
        data: form.serialize(),
        beforeSend: function () {

            //Loading.show();
        },
        complete: function () {
            //Loading.hide();
        },
        success: function (data) {
            if (data.result == 'ok') {

                $("#lt"+$(this).attr('data-linea-tiempo')).html(data.response);
                $("#modal-contenido-denuncio").modal("hide");

            } else {
                alert(data.response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //Loading.hide();
            alert('Error: ' + errorThrown);
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
        data: {idComentario: idComentario },
        beforeSend: function () {

            //Loading.show();
        },
        complete: function () {
            //Loading.hide();
        },
        success: function (data) {
            if (data.result == 'ok') {

               $("#comentarios_contenido").html(data.response);

            } else {
                alert(data.response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //Loading.hide();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});

$(document).on('click', 'a[data-role="denunciar-comentario"]', function () {

    var idComentario = $(this).attr("data-comentario");
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/contenido/denunciar-comentario',
        data: {idComentario: idComentario },
        beforeSend: function () {
            $("#modal-comentario-denuncio").remove();
            //Loading.show();
        },
        complete: function () {
            //Loading.hide();
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
            //Loading.hide();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});

$(document).on('click', 'button[data-role="guardar-denuncio-comentario"]', function () {

    var form = $("#form-comentario-denuncio")
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/contenido/guardar-denuncio-comentario',
        data: form.serialize(),
        beforeSend: function () {

            //Loading.show();
        },
        complete: function () {
            //Loading.hide();
        },
        success: function (data) {
            if (data.result == 'ok') {
                 $("#modal-comentario-denuncio").modal('hide');
            } else {
                alert(data.response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //Loading.hide();
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
        data: {elemento: elemento},
        beforeSend: function () {

            //Loading.show();
        },
        complete: function () {
            //Loading.hide();
        },
        success: function (data) {

        },
        error: function (jqXHR, textStatus, errorThrown) {
            //Loading.hide();
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});
