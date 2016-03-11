<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Recuperación contraseña';
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="p-t-30 p-l-40 p-b-20 xs-p-t-10 xs-p-l-10 xs-p-b-10">
  <h2 class="normal">
    Recupera tu acceso
  </h2>
  <p>
    Diligencia el formulario y se te enviara un correo para recuperar tu contraseña<br>
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
                      'template' => "{label}<br>\n<div class=\"col-md-6 col-sm-6\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                      'labelOptions' => ['class' => 'col-lg-11'],
                  ],
      ]);
      ?>

      <?= $form->field($model, 'username', [
          'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('username'),
          ],
      ])->label(false); ?>

      <?= $form->field($model, 'captcha')->widget(Captcha::className())->label("Ingresa el codigo") ?>

      <div class="form-group">
          <div class=" col-lg-11">
              <?= Html::submitButton('Enviar recuperación', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
          </div>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>
