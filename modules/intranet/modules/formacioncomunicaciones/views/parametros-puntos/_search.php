<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\ParametrosPuntosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parametros-puntos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idParametroPunto') ?>

    <?= $form->field($model, 'tipoParametro') ?>

    <?= $form->field($model, 'valorPuntos') ?>

    <?= $form->field($model, 'idTipoContenido') ?>

    <?= $form->field($model, 'condicion') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'fechaCreacion') ?>

    <?php // echo $form->field($model, 'fechaActualizacion') ?>

    <?php // echo $form->field($model, 'valorPuntosExtra') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
