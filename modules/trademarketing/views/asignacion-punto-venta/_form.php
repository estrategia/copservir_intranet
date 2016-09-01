<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\AsignacionPuntoVenta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-12 asignacion-punto-venta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idComercial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NombrePuntoDeVenta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombreTipoNegocio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idCiudad')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idZona')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombreZona')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idSede')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombreSede')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'numeroDocumento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'numeroDocumentoAdministradorPuntoVenta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'numeroDocumentosubAdministradorpuntoVenta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado')->textInput() ?>

    <?= $form->field($model, 'fechaAsignacion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
