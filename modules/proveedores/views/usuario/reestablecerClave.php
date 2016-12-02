<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Restablecer contraseña';

?>

<?= $this->render('/common/errores', []) ?>

<div class="container internal">
  <div class="space-2"></div>
  <div class="space-2"></div>
  <div class="row">
    <div class="col-md-12">

      <div class="space-1"></div>

      <h4>Registra una nueva contraseña</h4>

      <div class="col-md-offset-4 col-md-4 autenticacion">

        <div class="space-1"></div>

      <?php
      $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
          'template' => "{label}\n<div class=\"col-md-12 col-sm-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
          'labelOptions' => ['class' => 'col-lg-12'],
        ],
      ]);
      ?>

      <?= $form->field($model, 'password', [
        'inputOptions' => [
          'placeholder' => 'Nueva Contraseña',
        ],
        ])->label(false)->input('password'); ?>

        <?= $form->field($model, 'password2', [
          'inputOptions' => [
            'placeholder' => $model->getAttributeLabel('Confirmar Contraseña'),
          ],
          ])->label(false)->input('password'); ?>

          <?= $form->field($model, 'captcha')->widget(Captcha::className(), ['captchaAction'=>'usuario/captcha'])->label("Ingresa el código") ?>



            <div class="form-group">
              <div class="col-lg-12">
                <?= Html::submitButton('Actualizar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
              </div>
            </div>
            <?php ActiveForm::end(); ?>
         </div>

 </div>
     

    </div>
  </div>

  <div class="space-2"></div>
  <div class="space-2"></div>
</div>