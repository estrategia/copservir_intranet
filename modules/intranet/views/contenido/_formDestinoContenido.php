<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\web\JsExpression;
?>
<?php $uid = uniqid(); ?>
<?php 

$format = <<< SCRIPT
function formatSelect(state) {
  console.log(state.element);
  if (!state.id) return state.text; // optgroup
    return '<span style="' + state.element.style.cssText + '">' + state.text + '</span>';
}
SCRIPT;

$this->registerJs($format, \yii\web\View::POS_HEAD);
$escape = new JsExpression("function(m) {return m; }");
?>

<div class="row" id='<?= $uid ?>'>
  <div class="col-md-5">
    <?php echo Html::label('Grupo de Interés') ?>
    <?php
    echo Select2::widget([
      'name' => 'ContenidoDestino[idGrupoInteres][]',
      'id' => "grupo_$uid",
      // 'data' => $objContenidoDestino->getListaGrupoInteres($consultaTodos),
      'data' => $objContenidoDestino->getDatosSelectGruposInteres($consultaTodos)['data'],
      'options' => [
        'placeholder' => 'Selecione ...',
        'options' => $objContenidoDestino->getDatosSelectGruposInteres($consultaTodos)['options'],
      ],
      'pluginOptions' => [
        'allowClear' => true,
        'templateResult' => new JsExpression('formatSelect'),
        'templateSelection' => new JsExpression('formatSelect'),
        'escapeMarkup' => $escape,
      ],
      'hideSearch' => false,
    ]);
    ?>
  </div>
  <div class="col-md-5">
    <?php echo Html::label('Ciudad') ?>
    <?php
    echo
    Select2::widget([
      'name' => 'ContenidoDestino[codigoCiudad][]',
      'value' => '',
      'id' => "ciudad_$uid",
      'data' => $objContenidoDestino->getListaCiudades($consultaTodos),
      'options' => ['placeholder' => 'Selecione ...'],
      'hideSearch' => false,
      'pluginOptions' => [
        'allowClear' => true
      ],
    ]);
    ?>
  </div>
  <div class="col-md-1">
    <?= Html::label('Quitar') ?>
    <?=
    Html::a('<i class = "fa fa-minus-square" ></i>', '#', [
      'data-role' => 'quitar-destino-contenido',
      'data-row' => "#$uid",
      'title' => 'Quitar'
    ]);
    ?>
  </div>

</div>
<br/>
