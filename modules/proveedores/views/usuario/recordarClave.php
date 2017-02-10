<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Recuperación de contraseña';
?>

<div class="container internal">
  <div class="space-2"></div>
  <div class="space-2"></div>
  <div class="row">
    <div class="col-md-12">

      <div class="space-1"></div>

      <h4>Recuperar Contraseña</h4>
	  <div class="col-md-offset-4 col-md-4 autenticacion">

<!-- <div class="tiles grey p-t-20 p-b-20 no-margin text-black tab-content">
  <div role="tabpanel" class="tab-pane active" id="tab_login">
    <div class="row form-row m-l-20 m-r-20 xs-m-l-10 xs-m-r-10"> -->
      <?php
      $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
          'template' => "{label}<br>\n<div class=\"col-md-12 col-sm-12\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
          'labelOptions' => ['class' => 'col-lg-11'],
        ],
      ]);
      ?>

      <?= $form->field($model, 'username', [
        'inputOptions' => [
          'placeholder' => $model->getAttributeLabel('username'),
        ],
        ])->label(false); ?>

        <?= $form->field($model, 'captcha')->widget(Captcha::className(), ['captchaAction'=>'usuario/captcha'])->label("Código:") ?>
        <br>

        <div class="form-group">
          <div class=" col-lg-12">
            <?= Html::submitButton('Aceptar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
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
