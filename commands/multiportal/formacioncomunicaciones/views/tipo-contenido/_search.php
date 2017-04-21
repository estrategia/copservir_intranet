<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\TipoContenidoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipo-contenido-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idTipoContenido') ?>

    <?= $form->field($model, 'nombreTipoContenido') ?>

    <?= $form->field($model, 'estadoTipoContenido') ?>

    <?= $form->field($model, 'fechaCreacion') ?>

    <?= $form->field($model, 'fechaActualizacion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
