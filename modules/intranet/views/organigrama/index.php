<?php
/* @var $this yii\web\View */
use yii\web\JsExpression;

$format = <<< SCRIPT
var organigrama_config = {
    chart: {
      container: "#organigrama",
      connectors: {
        type: "step"
      },
      node: {
        HTMLclass: 'nodo-organigrama'
      }
    },
  };

$(document).ready(function () {
  $.ajax({
    type: 'GET',
    async: true,
    url: requestUrl + '/intranet/organigrama/consultar',
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
        if (data.result == "ok") {
          organigrama_config.nodeStructure = data.response;
          var organigrama = new Treant(organigrama_config, null, $);
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
});

$(document).on('click', '.node img', function () {
  var nodo = $(this).parent();
  var numeroDocumento = nodo.attr('id');
  var expandido = nodo.attr('data-expandido');
  if(expandido != 1 && numeroDocumento != 1) {
    $.ajax({
      type: 'GET',
      async: true,
      url: requestUrl + '/intranet/organigrama/colaboradores?numeroDocumento=' + numeroDocumento,
      dataType: 'json',
      beforeSend: function() {
        $('body').showLoading();
      },
      complete: function(data) {
        $('body').hideLoading();
      },
      success: function(data) {
          if (data.result == "ok") {
            organigrama_config.nodeStructure = data.response;
            organigrama = new Treant(organigrama_config, null, $);
          }
            $('#'+numeroDocumento).attr('data-expandido', '1');
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('body').hideLoading();
      }
    });
  }
});

$(document).on('click', 'a[data-role="perfil-usuario"]', function () {
  var numeroDocumento = $(this).attr('data-numero-documento');
  $.ajax({
    type: 'GET',
    async: true,
    url: requestUrl + '/intranet/organigrama/perfil?numeroDocumento=' + numeroDocumento,  
    dataType: 'html',
      beforeSend: function() {
        $('body').showLoading();
      },
      complete: function(data) {
        $('body').hideLoading();
      },
      success: function(data) {
          $('body').append(data);
          $('#modal-perfil').modal('show');
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('body').hideLoading();
      }
  });
});
SCRIPT;

$this->registerJs($format, \yii\web\View::POS_END);
?>
<h1>Organigrama</h1>

<div id="organigrama">

</div>
