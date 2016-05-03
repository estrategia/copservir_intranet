<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\ContenidoEmergenteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contenido-emergente-search">

  <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
  ]); ?>

  <?= $form->field($model, 'idContenidoEmergente') ?>

  <?= $form->field($model, 'contenido') ?>

  <?= $form->field($model, 'fechaInicio') ?>

  <?= $form->field($model, 'fechaFin') ?>

  <?= $form->field($model, 'estado') ?>

  <?php // echo $form->field($model, 'fechaRegistro') ?>

  <div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
