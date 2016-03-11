/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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



$(document).on('click', "button[data-role='guardar-contenido']", function() {

    var form = $("#nuevoPOST");
    var href = $(this).attr('data-href');
    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/sitio/guardar-contenido',
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
                $(".lineastiempo").html("");
                $(href).html(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {

        }
    });
});
