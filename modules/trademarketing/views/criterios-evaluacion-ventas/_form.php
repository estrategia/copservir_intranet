<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\trademarketing\models\CriteriosEvalucionVentas;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\CriteriosEvaluacionVentas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-12 criterios-evaluacion-ventas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valor')->textInput(['maxlength' => true]) ?>

    <?php $model->estado = $model->isNewRecord ? CriteriosEvaluacionVentas::ESTADO_ACTIVO : $model->estado;  ?>
    <?= $form->field($model, 'estado')->dropDownList([CriteriosEvaluacionVentas::ESTADO_INACTIVO => 'Inactivo',
            CriteriosEvaluacionVentas::ESTADO_ACTIVO => 'Activo']); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar',
              ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
