<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\trademarketing\models\RangoCalificaciones;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\RangoCalificaciones */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-12 rango-calificaciones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valor')->textInput(['maxlength' => true]) ?>

    <?php $model->estado = $model->isNewRecord ? RangoCalificaciones::ESTADO_ACTIVO : $model->estado;  ?>
    <?= $form->field($model, 'estado')->dropDownList([RangoCalificaciones::ESTADO_INACTIVO => 'Inactivo',
            RangoCalificaciones::ESTADO_ACTIVO => 'Activo']); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', 
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
