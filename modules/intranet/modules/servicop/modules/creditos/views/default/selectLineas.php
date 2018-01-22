<?php 
    use kartik\select2\Select2; 
    use yii\web\JsExpression;
?>

<label for="lineadCredito">Línea de Crédito</label>
<?= Select2::widget([
    'id' => 'linea-credito-detalle',
    'name' => 'lineaCredito',
    'data' => $selectLineasCredito,
    'options' => [
        'placeholder' => 'Seleccione una línea de crédito',
    ]
]); ?>

<?php $script = <<< SCRIPT
$('select[name="lineaCredito"]').on("change", function(e) {
  var idCredito = $(this).val();
  $.ajax({
    type: 'GET',
    async: true,
    data: {idCredito: idCredito},
    url: requestUrl + '/intranet/servicop/creditos/default/render-detalle-linea',
    dataType: 'json',
    beforeSend: function() {
      $('body').showLoading();
    },
    complete: function(data) {
      $('body').hideLoading();
    },
    success: function(data) {
      $('#widget-detalle-linea').html(data.response.descripcionCredito);
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