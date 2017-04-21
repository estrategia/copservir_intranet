<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\CursoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="curso-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idCurso') ?>

    <?= $form->field($model, 'nombreCurso') ?>

    <?= $form->field($model, 'presentacionCurso') ?>

    <?= $form->field($model, 'estadoCurso') ?>

    <?= $form->field($model, 'fechaCreacion') ?>

    <?php // echo $form->field($model, 'fechaActualizacion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
