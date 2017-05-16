<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\ModuloContenido */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modulo-contenido-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombreModulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcionModulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcionModulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'duracionDias')->textInput(['maxlength' => true]) ?>    

    <?= $form->field($model, 'estadoModulo')->widget(Select2::classname(), [
          'data' => ['1' => 'Activo', '0' => 'Inactivo'],
          'options' => ['placeholder' => 'Selecciona estado ...'],
          'hideSearch' => true,
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
