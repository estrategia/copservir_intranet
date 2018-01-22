<?php 
    use kartik\select2\Select2; 
    use yii\web\JsExpression;
?>

<label for="lineadCredito">Seleccione la Modalidad de crédito a utilizar <small style="color: crimson">(Obligatorio)</small></label>
<?= Select2::widget([
    'id' => 'selector-lineas-credito',
    'name' => 'lineaCredito',
    'data' => $selectLineasCredito,
    'options' => [
        'placeholder' => 'Seleccione una línea de crédito',
    ],
    'pluginEvents' => [
        "select2:select" => "function() { $('#valor-cuota').val(0).trigger('change'); }"
    ]
]); ?>

<?php $script = <<< SCRIPT
$('select[name="lineaCredito"]').on("change", function(e) {
  var idCredito = $(this).val();
  var credito = $('#form-creditos').serialize();
  $.ajax({
    type: 'POST',
    async: true,
    data: {idCredito: idCredito, datos: credito},
    url: requestUrl + '/intranet/servicop/creditos/simulador/render-widgets',
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      $('#widget-info-basica').html(data.response.infoBasica);
      $('#widget-cuotas-extra').html(data.response.tiposCuotaExtra);
      $('#widget-garantias').html(data.response.garantiasNoCombinadas);
      $('#widget-garantias-combinadas').html(data.response.garantiasCombinadas);
      $('#widget-parametros').html(data.response.parametros);
      $('#widget-descripcion').html(data.response.descripcion);
      $('input[name="valor"]').val("");
      $('input[name="plazo"]').val("");
      $('#forms-cuotas-extra').html("");
      $('input[name="nivel-endeudamiento-cuota"]').val(0);
      $('#widget-codeudor').hide();
      // consultarCupoMaximo(idCredito);
      // mostrarParametrosGenerales();
      $('input.formatear-numero').numeric({allowMinus: false});
      inicializarFormularioSimulador();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});
SCRIPT;

$script = <<< SCRIPT
$('select[name="lineaCredito"]').on("change", function(e) {
  var idCredito = $(this).val();
  $.ajax({
    type: 'GET',
    async: true,
    data: {idCredito: idCredito},
    url: requestUrl + '/intranet/servicop/creditos/simulador/render-widgets',
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      $('#widget-info-basica').html(data.response.infoBasica);
      $('#widget-cuotas-extra').html(data.response.tiposCuotaExtra);
      $('#widget-garantias').html(data.response.garantiasNoCombinadas);
      $('#widget-garantias-combinadas').html(data.response.garantiasCombinadas);
      $('#widget-parametros').html(data.response.parametros);
      $('#widget-descripcion').html(data.response.descripcion);
      $('input[name="valor"]').val("");
      $('input[name="plazo"]').val("");
      $('#forms-cuotas-extra').html("");
      $('#widget-codeudor').hide();
      // consultarCupoMaximo(idCredito);
      $('input.formatear-numero').numeric({allowMinus: false});
      $('input.formatear-numero').number(true,0);
      inicializarFormularioSimulador();
      validarAntiguedadCredito(idCredito);
      validarAntiguedadCargo(idCredito);
      preSeleccionarGarantia();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('body').hideLoading();
    }
  });
  return false;
});
SCRIPT;


$this->registerJs($script, \yii\web\View::POS_END);

?>