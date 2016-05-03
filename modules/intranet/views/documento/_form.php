<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\Documento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="documento-form">

  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

  <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'file')->fileInput(); ?>

  <?php if (!$model->isNewRecord): ?>
    <?= $form->field($model, 'descripcionLog')->textInput(); ?>
  <?php endif ?>
  <br>
  <?php $model->estado = $model->isNewRecord ? 1 : $model->estado;  ?>
  <?= $form->field($model, 'estado')->dropDownList(['0' => 'Inactivo', '1' => 'Activo']); ?>

  <?php $fechaCreacion = $model->isNewRecord ? Date("Y-m-d H:i:s") : $model->fechaCreacion;  ?>
  <?= $form->field($model, 'fechaCreacion')->hiddenInput(['value'=> $fechaCreacion])->label(false); ?>

  <?= $form->field($model, 'fechaActualizacion')->hiddenInput(['value'=> Date("Y-m-d H:i:s")])->label(false); ?>

  <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
