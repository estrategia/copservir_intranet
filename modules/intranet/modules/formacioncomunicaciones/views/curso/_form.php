<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
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

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\Curso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="curso-form">
      
      <?php $form = ActiveForm::begin(); ?>

      <?= $form->field($model, 'nombreCurso')->textInput(['maxlength' => true]) ?>

      <?= $form->field($model, 'presentacionCurso')->textInput(['maxlength' => true]) ?>

      <?= $form->field($model, 'cursoGruposInteres')->widget(Select2::classname(),[
        'data' => $objCursoGruposInteres->getDatosSelectGruposInteres()['data'],
        'options' => [
          'placeholder' => 'Selecione ...',
          'options' => $objCursoGruposInteres->getDatosSelectGruposInteres()['options'],
          'multiple' => true,
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

      <?= $form->field($model, 'idTipoContenido')->widget(Select2::classname(), [
        'data' => $tiposContenido,
        'options' => ['placeholder' => 'Selecciona tipo de contenido ...'],
        'hideSearch' => true,
        'pluginOptions' => [
          'allowClear' => true
        ],
      ]); ?>

      <?= $form->field($model, 'fechaInicio')->widget(DatePicker::classname(), [
          'type' => DatePicker::TYPE_INPUT,
          'options' => ['placeholder' => ''],
              'pluginOptions' => [
              'autoclose'=>true,
              'format' => 'yyyy-mm-dd'
              ]
          ]);
      ?>
      
      <?= $form->field($model, 'estadoCurso')->hiddenInput(['value' => 0])->label(false) ?>

      <div class="form-group">
          <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
      </div>

    <?php ActiveForm::end(); ?>

</div>
