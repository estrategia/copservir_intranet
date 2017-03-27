<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\ContenidoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contenido-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idContenido') ?>

    <?= $form->field($model, 'contenido') ?>

    <?= $form->field($model, 'estadoContenido') ?>

    <?= $form->field($model, 'idAreaConocimiento') ?>

    <?= $form->field($model, 'idModulo') ?>

    <?php // echo $form->field($model, 'idCapitulo') ?>

    <?php // echo $form->field($model, 'idTipoContenido') ?>

    <?php // echo $form->field($model, 'idContenidoCopia') ?>

    <?php // echo $form->field($model, 'fechaInicio') ?>

    <?php // echo $form->field($model, 'fechaFin') ?>

    <?php // echo $form->field($model, 'frecuenciaMes') ?>

    <?php // echo $form->field($model, 'fechaCreacion') ?>

    <?php // echo $form->field($model, 'fechaActualizacion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
