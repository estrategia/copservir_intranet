<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Actualizar Inaformacion del Documento: ' . $model->titulo;
?>

<div class="documento-update">

  <h4><?= Html::encode($this->title) ?></h4>

  <div class="documento-form">

    <?php $form = ActiveForm::begin([]); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?php $model->estado = $model->isNewRecord ? 1 : $model->estado;  ?>
    <?= $form->field($model, 'estado')->dropDownList(['0' => 'Inactivo', '1' => 'Activo']); ?>

    <?= $form->field($model, 'fechaActualizacion')->hiddenInput(['value'=> Date("Y-m-d H:i:s")])->label(false); ?>

    <div class="form-group">
      <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

  </div>

</div>
