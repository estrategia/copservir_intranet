<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Recuperación contraseña';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-8">
  <div class="page-title">
      <h4> Actualiza tu clave de acceso</h4>
  </div>

  <div class="grid simple">
    <div class="grid-title no-border">

    </div>
    <div class="grid-body no-border">

      <?php
      $form = ActiveForm::begin([
                  'id' => 'login-form',
                  'options' => ['class' => 'form-horizontal', 'enableClientValidation' => true],
                  'fieldConfig' => [
                      'template' => "{label}\n<div class=\"col-md-6 controls\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                      'labelOptions' => ['class' => 'col-lg-11'],
                  ],
      ]);
      ?>

      <?= $form->field($model, 'password')->passwordInput() ?>
      <?= $form->field($model, 'password2')->passwordInput()->label('Confirmar contraseña') ?>
      <?= $form->field($model, 'captcha')->widget(Captcha::className(), ['captchaAction'=>'usuario/captcha'])->label("Ingresa el codigo") ?>

      <div class="form-group">
          <div class="col-lg-offset-1 col-lg-11">
              <?= Html::submitButton('Actualizar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
          </div>
      </div>
      <?php ActiveForm::end(); ?>

    </div>
  </div>
</div>
