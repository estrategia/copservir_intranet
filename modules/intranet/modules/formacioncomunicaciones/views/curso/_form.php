<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\Curso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="curso-form">
      
      <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
      
      <?= $form->field($model, 'nombreCurso')->textInput(['maxlength' => true]) ?>

      <?= $form->field($model, 'presentacionCurso')->textInput(['maxlength' => true]) ?>

      <?= $form->field($model, 'fechaInicio')->widget(DatePicker::classname(), [
          'type' => DatePicker::TYPE_INPUT,
          'options' => ['placeholder' => ''],
              'pluginOptions' => [
              'autoclose'=>true,
              'format' => 'yyyy-mm-dd'
              ]
          ]);
      ?>
      
      <?= $form->field($model, 'cantidadPuntos')->textInput(['maxlength' => true]) ?>

      <?= $form->field($model, 'idTercero')->widget(Select2::classname(), [
            'data' => $terceros,
            'options' => ['placeholder' => 'Selecciona proveedor ...'],
            'hideSearch' => true,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]); 
      ?>

      <?= $form->field($model, 'estadoCurso')->hiddenInput(['value' => 0])->label(false) ?>

      <div class="form-group">
          <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
      </div>

    <?php ActiveForm::end(); ?>

</div>
