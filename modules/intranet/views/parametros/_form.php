<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\Parametros */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parametros-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'valorParametro')->textInput(['maxlength' => true]) ?>

    <?php
      //$form->field($model, 'idParametro')->textInput(['maxlength' => true])
      // $form->field($model, 'descripcion')->textInput(['maxlength' => true])
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
