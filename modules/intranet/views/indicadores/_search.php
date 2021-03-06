<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="indicadores-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idIndicador') ?>

    <?= $form->field($model, 'colorFondo') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'valor') ?>

    <?= $form->field($model, 'textoComplementario') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
