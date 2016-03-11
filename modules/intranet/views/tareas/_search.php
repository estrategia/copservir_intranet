<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\TareasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tareas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idTarea') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'idUsuario') ?>

    <?= $form->field($model, 'fechaRegistro') ?>

    <?php // echo $form->field($model, 'estadoTarea') ?>

    <?php // echo $form->field($model, 'fechaEstimada') ?>

    <?php // echo $form->field($model, 'prioridad') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
