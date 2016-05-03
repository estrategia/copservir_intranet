<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Restablecer contraseña';

?>

<div class="p-t-30 p-l-40 p-b-20 xs-p-t-10 xs-p-l-10 xs-p-b-10">
  <p class="normal">
    Registra una nueva contraseña de acceso
  </p>
</div>

<div class="tiles grey p-t-20 p-b-20 no-margin text-black tab-content">
  <div role="tabpanel" class="tab-pane active" id="tab_login">
    <div class="row form-row m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
      <?php
      $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
          'template' => "{label}\n<div class=\"col-md-6 col-sm-6\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
          'labelOptions' => ['class' => 'col-lg-11'],
        ],
      ]);
      ?>

      <?= $form->field($model, 'password', [
        'inputOptions' => [
          'placeholder' => $model->getAttributeLabel('password'),
        ],
        ])->label(false)->input('password'); ?>

        <?= $form->field($model, 'password2', [
          'inputOptions' => [
            'placeholder' => $model->getAttributeLabel('Confirmar contraseña'),
          ],
          ])->label(false)->input('password'); ?>

          <?= $form->field($model, 'captcha', [
            'inputOptions' => [
              'placeholder' => $model->getAttributeLabel('Ingresa el codigo'),
            ],
            ])->label('ingresa el codigo')->widget(Captcha::className()); ?>



            <div class="form-group">
              <div class="col-lg-11">
                <?= Html::submitButton('Actualizar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
              </div>
            </div>
            <?php ActiveForm::end(); ?>
          </div>
        </div>
      </div>
