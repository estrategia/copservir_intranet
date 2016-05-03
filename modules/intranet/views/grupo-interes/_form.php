<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\GrupoInteres */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grupo-interes-form">

  <?php $form = ActiveForm::begin(["options" => ["enctype" => "multipart/form-data"],]); ?>

  <?= $form->field($model, 'nombreGrupo')->textInput(['maxlength' => true]) ?>
  <?= $form->field($model, "imagenGrupo")->fileInput(['multiple' => false ]) ?>
  <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

  </div>

  <?php ActiveForm::end(); ?>

</div>
