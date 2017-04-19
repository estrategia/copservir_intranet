<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\Curso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="curso-form">

      <?php $form = ActiveForm::begin(); ?>

      <?= $form->field($model, 'nombreCurso')->textInput(['maxlength' => true]) ?>

      <?= $form->field($model, 'presentacionCurso')->textInput(['maxlength' => true]) ?>

      <?= $form->field($model, 'cursoGruposInteres')->widget(Select2::classname(), [
          'data' => $gruposInteres,
          'options' => ['placeholder' => 'Agregar grupo de interes', 'multiple' => true],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]); ?>

      <?= $form->field($model, 'idTipoContenido')->widget(Select2::classname(), [
        'data' => $tiposContenido,
        'options' => ['placeholder' => 'Selecciona tipo de contenido ...'],
        'hideSearch' => true,
        'pluginOptions' => [
          'allowClear' => true
        ],
      ]); ?>

      <?= $form->field($model, 'fechaInicio')->widget(DatePicker::classname(), [
          'type' => DatePicker::TYPE_INPUT,
          'options' => ['placeholder' => ''],
              'pluginOptions' => [
              'autoclose'=>true,
              'format' => 'yyyy-mm-dd'
              ]
          ]);
      ?>
      
      <?= $form->field($model, 'estadoCurso')->hiddenInput(['value' => 0])->label(false) ?>

      <div class="form-group">
          <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
      </div>

    <?php ActiveForm::end(); ?>

</div>
