<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\UsuarioTarjetaMas */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Actualiza tu información personal';
?>

<div class="container">
  <div class="space-2"></div>
  <div class="space-2"></div>
  <div class="row">
    <div class="col-md-12">

      <h2><?= Html::encode($this->title) ?></h2>

      <div class="space-1"></div>

      <div class="col-md-offset-3 col-md-6">
        <?php $form = ActiveForm::begin(['options' => ['id' => 'formMenuportales']]); ?>

        <?= $form->field($model, 'numeroTarjeta')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Registrar', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
  <div class="space-2"></div>
  <div class="space-2"></div>
</div>
