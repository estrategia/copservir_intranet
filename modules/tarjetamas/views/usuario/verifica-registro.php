<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Verificar Usuario';

?>

<div class="container internal">
  <div class="row">
    <div class="col-md-12">
      <div class="space-2"></div>
      <div class="space-2"></div>
      <div class="space-1"></div>

      <h4>Activa tu registro</h4>

      <div class="col-md-offset-4 col-md-4 autenticacion">
        <div class="space-1"></div>

        <?php $form = ActiveForm::begin([
          'id' => 'login-form',
          'options' => ['class' => 'animated fadeIn validate'],
        ]); ?>

        <?=
          $form->field($model, 'username', [
            'inputOptions' => [
              'placeholder' => $model->getAttributeLabel('username'),
            ],
          ])->label(false);
        ?>

        <?= Html::submitButton('Verificar Usuario', ['class' => 'btn btn-primary btn-sm btn-block', 'name' => 'login-button']) ?>

        <?php ActiveForm::end(); ?>
      </div>
    </div>

    <div class="col-md-12">
      <div class="space-2"></div>
      <div class="space-2"></div>
    </div>

  </div>
</div>
