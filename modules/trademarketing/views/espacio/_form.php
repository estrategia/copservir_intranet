<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\trademarketing\models\Espacio;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\Espacio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-12 espacio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?php $model->estado = $model->isNewRecord ? Espacio::ESTADO_ACTIVO : $model->estado;  ?>
    <?=
      $form->field($model, 'estado')->dropDownList([Espacio::ESTADO_INACTIVO => 'Inactivo',
        Espacio::ESTADO_ACTIVO => 'Activo']);
    ?>

     <?php
      // $form->field($model, 'idVariable')->widget(Select2::classname(), [
      //   'data' => $model->getMapListaVariables(),
      //   'options' => ['placeholder' => 'Seleccione la una variable']
      // ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar',
              ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
