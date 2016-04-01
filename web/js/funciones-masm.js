/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('click', 'button[data-role="contenido-publicar"]', function () {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/intranet/contenido/publicar',
        data: {render: true, linea: $(this).attr('data-linea')},
        beforeSend: function () {
            $("#modal-contenido-publicar").remove();
            //Loading.show();
        },
        complete: function () {
            //Loading.hide();
        },
        success: function (data) {
            if (data.result == 'ok') {
                $('body').append(data.response);
                $("#modal-contenido-publicar").modal("show");
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

$('document').on('beforeSubmit', 'form#form-contenido-publicar', function () {
    var form = $(this);
    // return false if form still have some validation errors
    if (form.find('.has-error').length) {
        return false;
    }
    // submit form
    $.ajax({
        url: form.attr('action'),
        type: 'post',
        data: form.serialize(),
        success: function (data) {
            // do something with response
        }
    });
    return false;
});

var timestampnotif = null;
function cargar_push()
{
    $.ajax({
        async: true,
        type: "POST",
        url: requestUrl + '/intranet/sitio/notificaciones',
        data: "&timestamp=" + timestampnotif,
        dataType: 'json',
        success: function (data){
            timestampnotif = data.response.timestamp;
            if (timestampnotif == null){
            }else{
                $('#notification-list').html(data.response.html);
            }
            setTimeout('cargar_push()', 1000);
        }
    });
}

$(document).ready(function(){
    cargar_push();
});
