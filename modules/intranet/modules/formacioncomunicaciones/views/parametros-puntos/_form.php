<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\ParametrosPuntos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parametros-puntos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'valorPuntos')->textInput() ?>

    <?= $form->field($model, 'tipoParametro')->widget(Select2::classname(), [
      'data' => ['1' => 'Tipo de Contenido', '2' => 'Cumpleaños', '3' => 'Aniversario'],
      'options' => ['placeholder' => 'Selecciona tipo de parametro ...'],
      'hideSearch' => true,
      'pluginOptions' => [
        'allowClear' => true
      ],
    ]); ?>

    <?= $form->field($model, 'idTipoContenido', ['options' => ['class' => 'form-group hidden']])->widget(Select2::classname(), [
        'data' => $tiposContenido,
        'options' => ['placeholder' => 'Selecciona tipo de contenido ...'],
        'hideSearch' => true,
        'pluginOptions' => [
          'allowClear' => true
        ],
      ]); ?>
  
    <?= $form->field($model, 'condicion', ['options' => ['class' => 'form-group hidden']])->textInput() ?>

    <?= $form->field($model, 'estado')->widget(Select2::classname(), [
      'data' => ['1' => 'Activo', '0' => 'Inactivo'],
      'options' => ['placeholder' => 'Selecciona estado ...'],
      'hideSearch' => true,
      'pluginOptions' => [
        'allowClear' => true
      ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
