<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\OfertasLaboralesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ofertas-laborales-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idOfertaLaboral') ?>

    <?= $form->field($model, 'idCiudad') ?>

    <?= $form->field($model, 'fechaPublicacion') ?>

    <?= $form->field($model, 'fechaCierre') ?>

    <?= $form->field($model, 'numeroDocumento') ?>

    <?php // echo $form->field($model, 'fechaInicioPublicacion') ?>

    <?php // echo $form->field($model, 'fechaFinPublicacion') ?>

    <?php // echo $form->field($model, 'tituloOferta') ?>

    <?php // echo $form->field($model, 'urlElEmpleo') ?>

    <?php // echo $form->field($model, 'idCargo') ?>

    <?php // echo $form->field($model, 'idArea') ?>

    <?php // echo $form->field($model, 'descripcionContactoOferta') ?>

    <?php // echo $form->field($model, 'idInformacionContacto') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
