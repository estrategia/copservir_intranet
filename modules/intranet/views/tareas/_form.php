<?php

//use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\intranet\models\Tareas;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\Tareas */
/* @var $form yii\widgets\ActiveForm */
?>
<?= $this->render('/common/errores', []) ?>

<div class="tareas-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

  <?php if (!$model->isNewRecord): ?>

    <?= $form->field($model, 'progreso')->textInput(['type' => 'number']) ?>
  <?php else: ?>
    <?= $form->field($model, 'progreso')->hiddenInput(['value'=> Tareas::PROGRESO_TAREA_INICIAL])->label(false); ?>
  <?php endif ?>


  <?= $form->field($model, 'numeroDocumento')->hiddenInput(['value'=> Yii::$app->user->identity->numeroDocumento])->label(false); ?>

  <?= $form->field($model, 'fechaRegistro')->hiddenInput(['value'=> date('YmdHis')])->label(false); ?>

  <?= $form->field($model, 'estadoTarea')->hiddenInput(['value'=> Tareas::ESTADO_TAREA_NO_TERMINADA])->label(false); ?>

  <?= $form->field($model, 'fechaRegistro')->hiddenInput(['value' => date('YmdHis')])->label(false); ?>

  <?= $form->field($model, 'estadoTarea')->hiddenInput(['value' => 2])->label(false); ?>

  <div class="form-group field-tareas-fechaestimada">
    <label class="control-label" for="tareas-fechaestimada">Fecha estimada</label>
    <?php
    echo DateTimePicker::widget([
      'model' => $model,
      'attribute' => 'fechaEstimada',
      'options' => ['placeholder' => 'yyyy-mm-dd hh:mm'],
      'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:mm'
      ]
    ]);
    ?>
    <?php echo yii\bootstrap\Html::error($model, 'fechaEstimada', ['class' =>'help-block']); ?>
  </div>


  <?= $form->field($model, 'idPrioridad')->dropDownList($model->listaPrioridad, ['prompt' => 'Seleccione la prioridad']); ?>

  <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
