<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\PublicacionesCampanasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="publicaciones-campanas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idImagenCampana') ?>

    <?= $form->field($model, 'nombreImagen') ?>

    <?= $form->field($model, 'rutaImagen') ?>

    <?= $form->field($model, 'numeroDocumento') ?>

    <?= $form->field($model, 'urlEnlaceNoticia') ?>

    <?php // echo $form->field($model, 'fechaInicio') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'posicion') ?>

    <?php // echo $form->field($model, 'fechaFin') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
