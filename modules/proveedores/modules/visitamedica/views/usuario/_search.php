<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\modules\visitamedica\models\UsuarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'numeroDocumento') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'primerApellido') ?>

    <?= $form->field($model, 'segundoApellido') ?>

    <?= $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'telefono') ?>

    <?php // echo $form->field($model, 'celular') ?>

    <?php // echo $form->field($model, 'nitLaboratorio') ?>

    <?php // echo $form->field($model, 'profesion') ?>

    <?php // echo $form->field($model, 'fechaNacimiento') ?>

    <?php // echo $form->field($model, 'Ciudad') ?>

    <?php // echo $form->field($model, 'Direccion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
