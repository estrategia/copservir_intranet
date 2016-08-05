<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Perfil de usuario'), 'url'=>['/intranet/usuario/perfil']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cambiar contraseña')];
?>

<div class="col-md-12">
  <div class="page-title">
    <h4> Actualiza tu contraseña</h4>
  </div>

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
