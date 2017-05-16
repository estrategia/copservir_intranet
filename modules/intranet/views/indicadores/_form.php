<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="indicadores-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valor')->textInput(['maxlength' => true]) ?>

    <?php $model->estado = $model->isNewRecord ? 1 : $model->estado;  ?>
    <?= $form->field($model, 'estado')->dropDownList(['0' => 'Inactivo', '1' => 'Activo']); ?>


    <?php $model->colorFondo = $model->isNewRecord ? "#0090D9" : $model->colorFondo;  ?>
    <?= $form->field($model, 'colorFondo',
      [
        'template' => "{label}{input}"
      ])->input('color',['class'=>"input_class", 'value' => $model->colorFondo]) ?>


    <?= $form->field($model, 'textoComplementario')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar',
          ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
