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

/*
* peticion ajax para guardar un contenido de una publicacion
*/
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

<<<<<<< HEAD
//::::::::::::::::::::::
// TAREAS
//::::::::::::::::::::::
=======
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


>>>>>>> 487f0b37f8424bdf0c1fe4c3e2d9a34eba88ddc9

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
