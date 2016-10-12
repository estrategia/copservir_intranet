<?php
    use yii\helpers\Html;
    $this->title = 'Seleccion de ubicacion';
    // $this->params['breadcrumbs'][] = ['label' => 'Reportes', 'url' => ['/proveedores/visitamedica/reportes']];
    $this->params['breadcrumbs'][] = ['label' => 'Seleccion de ubicacion'];
?>

<button id="mostrarMapa" onclick="cargarMapa()" class="btn btn-default">Mapa</button>
<button id="gps" onclick="getLocation()" class="btn btn-default">GPS</button>

<div class="modal fade" id="modal-confirmacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" id="myModalLabel">Confirmar ubicacion</h3>
      </div>
      <div class="modal-body">
        <h4 id="ubicacion"></h4>
        <form name="confirmacion" id="confirmacion" action=" <?= Yii::$app->getUrlManager()->getBaseUrl() . '/proveedores/visitamedica/ubicacion/confirmar' ?> " method="POST" >
          <input type="hidden" name="nombreCiudad" value="">
          <input type="hidden" name="nombreSector" value="">
          <input type="hidden" name="codigoCiudad" value="">
          <input type="hidden" name="codigoSector" value="">
          <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
        </form>
        <div class="row">
          <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary pull-right" onclick="document.forms['confirmacion'].submit();">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

  function cargarMapa()
  {
    if ($('#modal-ubicacion-map').length > 0) {
      $('#modal-ubicacion-map').modal('show');
      resizeMap();
    } else {
      $.ajax({
        url: requestUrl + '/proveedores/visitamedica/ubicacion/mapa',
        type: 'post',
        dataType: 'html',
        beforeSend: function() {
          $('html').showLoading();
        },
        success: function(data) {
            $.getScript("https://maps.googleapis.com/maps/api/js?client=" + gmapKey).done(function(script, textStatus) {
              $.getScript(requestUrl + "/js/ubicacion.js").done(function(script, textStatus) {
                $('body').append(data);
                // $('#select-ubicacion-psubsector .ciudades').select2();
                inicializarMapa();
                $('#modal-ubicacion-map').modal('show');
                resizeMap();
                $('html').hideLoading();
              }).fail( function (jqxhr, settings, exception) {
                $('html').hideLoading();
                alert("Error al inicializar mapa: " + exception);
              });

            }).fail(function(jqxhr, settings, exception) {
                $('html').hideLoading();
                alert("Error al cargar mapa: " + exception);
            });          
        },
       error: function(jqXHR, textStatus, errorThrown) {
          $('html').hideLoading();
          alert('Error: ' + errorThrown);
        }
      });
    }
  }
  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function (position){
        $.ajax({
          type: 'POST',
          dataType: 'json',
          async: true,
          url: requestUrl + '/proveedores/visitamedica/ubicacion/seleccionar',
          data: {
                  lat: position.coords.latitude, 
                  lon: position.coords.longitude
                },
          beforeSend: function() {
            $('html').showLoading;
          },
          success: function (data) {
            json = JSON.parse(data);
            $('#ubicacion').text(json.response.nombreCiudad + " " + json.response.nombreSector);
            $('input[name="nombreCiudad"]').val(json.response.nombreCiudad);
            $('input[name="nombreSector"]').val(json.response.nombreSector);
            $('input[name="codigoCiudad"]').val(json.response.codigoCiudad);
            $('input[name="codigoSector"]').val(json.response.codigoSector);
            $('#modal-confirmacion').modal('show');
            $('html').hideLoading;
          },
          error: function(jqXHR, textStatus, errorThrown) {
            $('html').hideLoading;
          }
        });
      });
    } else {
      alert('Error: tu navegador no soporta localizacion por gps');
    }
  }

  function ubicarSeleccion() {
    $('html').showLoading;
    var lat = 0;
    var lon = 0;
    if (map) {
        lat = map.getCenter().lat();
        lon = map.getCenter().lng();
    }
    // console.log(lat);
    // console.log(lon);
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/proveedores/visitamedica/ubicacion/seleccionar',
        data: {
                lat: lat, 
                lon: lon
              },
        beforeSend: function() {
            $('html').showLoading;
        },
        success: function(data) {
            json = JSON.parse(data);
            if (json.result == 'ok') {
                $('#modal-ubicacion-map').modal('hide');
                // $('#ubicacion-seleccion-ciudad').val(json.response.ciudad);
                // $('#ubicacion-seleccion-sector').val(json.response.sector);
                // $('#ubicacion-seleccion-direccion').val('');

                // $('#div-ubicacion-tipoubicacion > button').removeClass('activo').addClass('inactivo');
                // $('#div-ubicacion-tipoubicacion > button[data-role="ubicacion-mapa"]').removeClass('inactivo').addClass('activo');
                // ubicacionSeleccion();
                $('#modal-confirmacion').modal('show');
            } else {
               alert('Error: ' + json.result);
            }
            $('html').hideLoading;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('html').hideLoading;
            alert('Error: ' + errorThrown);
        }
    });
    return false;
  };

  // function guar(argument) {
  //   // body...
  // }

</script>