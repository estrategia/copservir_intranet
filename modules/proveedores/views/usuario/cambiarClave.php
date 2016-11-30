<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->params['breadcrumbs'][] = ['label' =>  'Mi Cuenta', 'url'=>['mi-cuenta']];
$this->params['breadcrumbs'][] = ['label' => 'Cambiar contraseña'];
?>
<div class="container">
  <div class="row">
    
    <h1> Actualiza tu contraseña</h1>

  <?= $this->render('/common/errores', []) ?>

  <?php
  $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['enableClientValidation' => true],

  ]);
  ?>

  <?= $form->field($model, 'password')->passwordInput(['autocomplete'=>'off'])->label('Nueva contraseña') ?>
  <?= $form->field($model, 'password2')->passwordInput(['autocomplete'=>'off'])->label('Confirmar contraseña') ?>
  <?= $form->field($model, 'captcha')->widget(Captcha::className(), ['captchaAction'=>'usuario/captcha'])->label("Ingresa el codigo") ?>

  <div class="form-group">
    <?= Html::submitButton('Actualizar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
  </div>
  <?php ActiveForm::end(); ?>

  </div>
</div>
