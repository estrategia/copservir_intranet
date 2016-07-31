<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="grupo-interes-search">

  <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
  ]); ?>

  <?= $form->field($model, 'idGrupoInteres') ?>

  <?= $form->field($model, 'nombreGrupo') ?>

  <div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
