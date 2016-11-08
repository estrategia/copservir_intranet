<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="grupo-interes-form">

  <?php $form = ActiveForm::begin(["options" => ["enctype" => "multipart/form-data"],]); ?>

  <?= $form->field($model, 'nombreGrupo')->textInput(['maxlength' => true]) ?>

  <?php $model->estado = $model->isNewRecord ? 1 : $model->estado;  ?>
  <?= $form->field($model, 'estado')->dropDownList(['0' => 'Inactivo', '1' => 'Activo']); ?>

  <?= $form->field($model, "imagenGrupo")->fileInput() ?>
  <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
