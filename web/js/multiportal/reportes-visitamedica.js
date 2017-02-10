$('#selectorNitLaboratorio').change( function () {
  $.ajax({
        type: 'GET',
        async: true,
        url: requestUrl + '/intranet/visita-medica-reportes/seleccionar-laboratorio',
        data: {nitLaboratorio: $('#selectorNitLaboratorio').val()},
        dataType: 'json',
        beforeSend: function () {
            $('html').showLoading();
        },
        complete: function (response) {
            $('html').hideLoading();
        },
        success: function (response) {
            $('#boton-reportes-consultas').removeClass("hidden");
            $('#boton-reportes-acceso').removeClass("hidden");
            console.log(response);
            $('html').hideLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('html').hideLoading();
        }
    });
});