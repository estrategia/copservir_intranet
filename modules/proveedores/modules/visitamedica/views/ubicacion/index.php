<?php
    use yii\helpers\Html;
    use app\modules\intranet\models\Funciones;
    $this->title = 'Seleccion de ubicacion';
    // $this->params['breadcrumbs'][] = ['label' => 'Reportes', 'url' => ['/proveedores/visitamedica/reportes']];
    $this->params['breadcrumbs'][] = ['label' => 'Seleccion de ubicacion'];
    $this->registerCssFile('@web/libs/bootstrap-select2/select2.css');
    $this->registerJsFile('@web/libs/bootstrap-select2/select2.js', ['depends' => [app\assets\VisitaMedicaAsset::className()]]);
?>
<?php 
    $this->registerCssFile('@web/libs/bootstrap-select2/select2.css');
?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
<div class="alert alert-info" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
    <strong>
      <?= Yii::$app->session->getFlash('error') ?>
    </strong>
</div>
<?php endif; ?>

<button id="mostrarMapa" onclick="cargarMapa()" class="btn btn-default">Mapa</button>
<button id="gps" onclick="getLocation()" class="btn btn-default">GPS</button>

<div id="div-modal">
	<div class="modal fade" id="modal-confirmacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-focus-on="input:first">
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
	
	<div class="modal fade" id="modal-error" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="z-index: 9999">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h3 class="modal-title" id="myModalLabel">Error</h3>
	      </div>
	      <div class="modal-body">
	          <h4>No tenemos cobertura para el lugar seleccionado. Por favor selecciona otra ubicacion</h4>
	          <div class="row">
	            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
	          </div>
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
                $('#div-modal').prepend(data);
                $('#ciudad-selector').select2();
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
                //console.log(json.response);
                //$('#modal-ubicacion-map').modal('hide');
                $('#ubicacion').text(json.response.nombreCiudad + " " + json.response.nombreSector);
                $('input[name="nombreCiudad"]').val(json.response.nombreCiudad);
                $('input[name="nombreSector"]').val(json.response.nombreSector);
                $('input[name="codigoCiudad"]').val(json.response.codigoCiudad);
                $('input[name="codigoSector"]').val(json.response.codigoSector);
                $('#modal-confirmacion').modal('show');
            } else {
               // alert('Error: ' + json.response);
              $('#modal-error').modal('show');
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

  window.onload = function () {
    console.log($('#ciudad-selector').length);
    $(document).on('change', 'select[data-role="ciudad-despacho-map"]', function () {
      var val = $(this).val();
      if (val.length > 0) {
        var option = $('select[data-role="ciudad-despacho-map"] option[value="' + val + '"]').attr('selected', 'selected');

        if (map) {
          map.setCenter(new google.maps.LatLng(parseFloat(option.attr('data-latitud')), parseFloat(option.attr('data-longitud'))));

          $.ajax({
            type: 'POST',
            dataType: 'json',
            async: true,
            url: requestUrl + '/proveedores/visitamedica/ubicacion/get-sectores',
            data: {codigoCiudad: val},
            beforeSend: function() {
                $('html').showLoading;
            },
            success: function(data) {
                json = data.response;
                if (json.result == 'ok') {
                    if (json.response != 'Sin sectores') {
                      var selectSectores = crearSelectSectores(json.sectores);
                      $('#select-ubicacion-sector').show();
                      $('#select-ubicacion-sector').html(selectSectores);
                      $('#sector-selector').select2();
                    }
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
        }
      } 
    });
  };

  function crearSelectSectores(sectores) {
    var options = '<select style="width: 100%;" id="sector-selector" onchange="centrarMapaSector()">';
    options += "<option value=''> Selecciona un sector </option>";
    for (var i = sectores.length - 1; i >= 0; i--) {
      sector = sectores[i];
      options += "<option value="+ sector.codigoSector +" data-latitud-sector="+ sector.latitudGoogle +" data-longitud-sector="+ sector.longitudGoogle +"> " + sectores[i].nombreSector + " </option>";
    }
    options += '</select>';
    return options;
  }

  function centrarMapaSector() {
    var latitud = $('#sector-selector').find(':selected').data('latitud-sector');
    var longitud = $('#sector-selector').find(':selected').data('longitud-sector');
    map.setCenter(new google.maps.LatLng(parseFloat(latitud), parseFloat(longitud)));
    map.setZoom(12);
  }
</script>
