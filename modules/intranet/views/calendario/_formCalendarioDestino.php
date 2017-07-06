<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\modules\intranet\models\GrupoInteres;
use app\modules\intranet\models\Ciudad;
use app\modules\intranet\models\Funciones;
use kartik\select2\Select2;
use yii\web\JsExpression;

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

<?php $uid = uniqid(); ?>
<?=
  Html::a('<span class = "fa fa-plus-square" ></span>', '#', [
    'data-role' => 'agregar-destino-contenido',
    'title' => 'Agregar nuevo'
  ]);?><div class="row destinos" id="<?= $uid ?>"><div class="col-md-5"><?php echo Html::label('Grupo de Interés') ?><?php
    echo Select2::widget([
      'name' => 'EventosCalendarioDestino[idGrupoInteres][]',
      'id' => "grupo_$uid",
      // 'data' => ArrayHelper::map(GrupoInteres::find()->orderBy('nombreGrupo')->all(), 'idGrupoInteres', 'nombreGrupo'),
      'data' => Funciones::getDatosSelectGruposInteres()['data'],
      'options' => [
          'placeholder' => 'Selecione ...',
          'options' => Funciones::getDatosSelectGruposInteres()['options'],
          // 'multiple' => true,
        ],
      // 'options' => ['placeholder' => 'Selecione ...'],
      'pluginOptions' => [
          'allowClear' => true,
          'templateResult' => new JsExpression('formatSelect'),
          'templateSelection' => new JsExpression('formatSelect'),
          'escapeMarkup' => $escape,
        ],
      'hideSearch' => false,
    ]);


    ?></div><div class="col-md-5"><?php echo Html::label('Ciudad') ?><?php
    echo
    Select2::widget([
      'name' => 'EventosCalendarioDestino[codigoCiudad][]',
      'value' => '',
      'id' => "ciudad_$uid",
      'data' => ArrayHelper::map(Ciudad::find()->orderBy('nombreCiudad')->all(), 'codigoCiudad', 'nombreCiudad'),
      'options' => ['placeholder' => 'Selecione ...'],
      'hideSearch' => false,
      'pluginOptions' => [
        'allowClear' => true
      ],
    ]);
    ?>
  </div><div class="col-md-1"><?= Html::label('Quitar') ?>
    <?=
    Html::a('<i class = "fa fa-minus-square" ></i>', '#', [
      'data-role' => 'quitar-destino-contenido',
      'data-row' => "#$uid",
      'title' => 'Quitar'
    ]);
    ?>
  </div></div><br/>
