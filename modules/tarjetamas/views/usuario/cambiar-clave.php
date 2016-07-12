<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Cambiar Clave';

?>
<div class="container">
  <div class="space-2"></div>
  <div class="space-2"></div>
  <div class="row">
    <div class="col-md-12">
      <div class="space-1"></div>

      <?= $this->render('/common/errores', []) ?>

      <h2> Actualiza tu clave de acceso</h2>

      <div class="col-md-offset-4 col-md-4">
        <?php
          $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['enableClientValidation' => true],
          ]);
        ?>

        <?= $form->field($model, 'password')->passwordInput()->label('Nueva contraseña') ?>
        <?= $form->field($model, 'password2')->passwordInput()->label('Confirmar contraseña') ?>

        <div class="form-group">
          <?= Html::submitButton('Actualizar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
         
        </div>

        <?php ActiveForm::end(); ?>

      </div>

    </div>

  </div>
  <div class="space-2"></div>
  <div class="space-2"></div>
</div>
