<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\Documento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="documento-form">

  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

  <?= $form->field($model, 'archivo')->fileInput(); ?>


  <div class="form-group">
    <?= Html::submitButton('cargar', ['class' => 'btn btn-primary']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
