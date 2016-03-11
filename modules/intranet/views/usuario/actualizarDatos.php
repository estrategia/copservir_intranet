<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Actualizar Datos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-8">
  <div class="page-title">
      <h4>  Actualiza tu información personal</h4>
  </div>

  <div class="grid simple">
    <div class="grid-title no-border">

    </div>
    <div class="grid-body no-border">

      <?php
      $form = ActiveForm::begin([
                  'id' => 'login-form',
                  'options' => ['class' => 'form-horizontal'],
                  'fieldConfig' => [
                      'template' => "{label}\n<div class=\"col-md-6 controls\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                      'labelOptions' => ['class' => 'col-lg-1 control-label'],
                  ],
      ]);
      ?>

      <?= $form->field($model, 'email') ?>      
      <?= $form->field($model, 'celular') ?>
      <?= $form->field($model, 'residencia') ?>

      <div class="form-group">
          <div class="col-lg-offset-1 col-lg-11">
              <?= Html::submitButton('Actualizar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
          </div>
      </div>
      <?php ActiveForm::end(); ?>

    </div>
  </div>
</div>
