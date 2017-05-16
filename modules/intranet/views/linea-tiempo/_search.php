<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="linea-tiempo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idLineaTiempo') ?>

    <?= $form->field($model, 'nombreLineaTiempo') ?>

    <?= $form->field($model, 'estado') ?>

    <?= $form->field($model, 'autorizacionAutomatica') ?>

    <?= $form->field($model, 'tipo') ?>

    <?php // echo $form->field($model, 'solicitarGrupoObjetivo') ?>

    <?php // echo $form->field($model, 'orden') ?>

    <?php // echo $form->field($model, 'fechaInicio') ?>

    <?php // echo $form->field($model, 'fechaFin') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'icono') ?>

    <?php // echo $form->field($model, 'descripcion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
