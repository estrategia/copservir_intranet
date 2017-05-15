<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Recordar Clave';

?>
<div class="container internal">
  <div class="space-2"></div>
  <div class="space-2"></div>
  <div class="row">
    <div class="col-md-12">

      <div class="space-1"></div>

      <?= $this->render('/common/errores', []) ?>

      <h4>Recupera tu contraseña</h4>

      <div class="col-md-offset-4 col-md-4 autenticacion">

        <div class="space-1"></div>
        <p>
          Ingresa una nueva contraseña de acceso
        </p>

        <div class="space-1"></div>

        <?php $form = ActiveForm::begin([
          'id' => 'login-form',
          'options' => ['class' => 'animated fadeIn validate'],
        ]); ?>

        <?=
          $form->field($model, 'password', [
            'inputOptions' => [
              'placeholder' => 'Nueva Contraseña',
            ],
          ])->label(false)->passwordInput();
        ?>

        <?=
          $form->field($model, 'password2', [
            'inputOptions' => [
              'placeholder' => $model->getAttributeLabel('password2'),
            ],
          ])->label(false)->passwordInput();
        ?>

        <?= Html::submitButton('Reestablecer', ['class' => 'btn btn-primary btn-sm btn-block', 'name' => 'login-button']) ?>

        </div>

        <?php ActiveForm::end(); ?>

    </div>
  </div>

  <div class="space-2"></div>
  <div class="space-2"></div>
</div>
