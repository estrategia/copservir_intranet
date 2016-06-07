<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\MenuPortalesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-portales-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idMenuPortales') ?>

    <?= $form->field($model, 'idPortal') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'urlMenu') ?>

    <?= $form->field($model, 'tipo') ?>

    <?php // echo $form->field($model, 'icono') ?>

    <?php // echo $form->field($model, 'fechaInicio') ?>

    <?php // echo $form->field($model, 'fechaFin') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'fechaRegistro') ?>

    <?php // echo $form->field($model, 'fechaActualizacion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
