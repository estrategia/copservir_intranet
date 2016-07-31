<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
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
  
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
