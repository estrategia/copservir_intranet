<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\CapituloContenido */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="capitulo-contenido-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombreCapitulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcionCapitulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estadoCapitulo')->widget(Select2::classname(), [
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
