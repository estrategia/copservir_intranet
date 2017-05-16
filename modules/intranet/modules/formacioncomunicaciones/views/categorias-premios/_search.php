<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\CategoriasPremiosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categorias-premios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idCategoria') ?>

    <?= $form->field($model, 'nombreCategoria') ?>

    <?= $form->field($model, 'orden') ?>

    <?= $form->field($model, 'rutaIcono') ?>

    <?= $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'idCategoriaPadre') ?>

    <?php // echo $form->field($model, 'fechaCreacion') ?>

    <?php // echo $form->field($model, 'fechaActualizacion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
