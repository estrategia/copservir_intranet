<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\AreaContenido */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="area-contenido-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombreArea')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcionArea')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estadoArea')->widget(Select2::classname(), [
      'data' => ['1' => 'Activo', '0' => 'Inactivo'],
      'options' => ['placeholder' => 'Selecciona estado ...'],
      'hideSearch' => true,
      'pluginOptions' => [
        'allowClear' => true
      ],
    ]);
  ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
