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
        url: requestUrl + '/intranet/site/cambiar-linea-tiempo',
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
        type: 'GET',
        async: true,
        url: requestUrl + '/intranet/sitio/agregarOpcion',
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


$(document).on('click', "button[data-role='guardar-contenido']", function() {

    var form = $("#nuevoPOST");
    var href = $(this).attr('data-href');
    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/site/guardar-contenido',
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
