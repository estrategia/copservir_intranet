/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).on('click', 'a[data-role="bloquear-tarjeta"]', function () {

    var dataTarjeta = $(this).attr('data-tarjeta');

    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/tarjetamas/usuario/confirmar-bloqueo',
        data: {dataTarjeta: dataTarjeta},
        beforeSend: function () {
         //   $('html').showLoading()
         $("#modal-bloqueo").remove();
        },
        complete: function () {
         //   $('html').hideLoading();
        },
        success: function (data) {
            $('body').append(data);
            $("#modal-bloqueo").modal('show');
        },
        error: function (jqXHR, textStatus, errorThrown) {
        //    $('html').hideLoading();

            alert('Error: ' + errorThrown);
        }
    });
    return false;
});


$(document).on('click', 'button[data-role="bloquear-tarjeta"]', function () {

    var dataTarjeta = $(this).attr('data-tarjeta');

    $.ajax({
        type: 'POST',
        async: true,
        dataType: 'json',
        url: requestUrl + '/tarjetamas/usuario/suspender',
        data: {numeroTarjeta: dataTarjeta},
        beforeSend: function () {
         //   $('html').showLoading()
        
        },
        complete: function () {
         //   $('html').hideLoading();
        },
        success: function (data) {
            $("#modal-bloqueo").remove();
             window.location.href = data.response;
        },
        error: function (jqXHR, textStatus, errorThrown) {
        //    $('html').hideLoading();

            alert('Error: ' + errorThrown);
        }
    });
    return false;
});