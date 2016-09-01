<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\AsignacionPuntoVentaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asignacion-punto-venta-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idAsignacion') ?>

    <?= $form->field($model, 'idComercial') ?>

    <?= $form->field($model, 'NombrePuntoDeVenta') ?>

    <?= $form->field($model, 'nombreTipoNegocio') ?>

    <?= $form->field($model, 'idCiudad') ?>

    <?php // echo $form->field($model, 'idZona') ?>

    <?php // echo $form->field($model, 'nombreZona') ?>

    <?php // echo $form->field($model, 'idSede') ?>

    <?php // echo $form->field($model, 'nombreSede') ?>

    <?php // echo $form->field($model, 'numeroDocumento') ?>

    <?php // echo $form->field($model, 'numeroDocumentoAdministradorPuntoVenta') ?>

    <?php // echo $form->field($model, 'numeroDocumentosubAdministradorpuntoVenta') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'fechaAsignacion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
