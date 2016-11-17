<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="documento-search">

  <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
  ]); ?>

  <?= $form->field($model, 'idDocumento') ?>

  <?= $form->field($model, 'titulo') ?>

  <?= $form->field($model, 'descripcion') ?>

  <?= $form->field($model, 'rutaDocumento') ?>

  <?= $form->field($model, 'estado') ?>

  <div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
