<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\InformacionContactoOfertaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="informacion-contacto-oferta-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idInformacionContacto') ?>

    <?= $form->field($model, 'plantillaContactoHtml') ?>

    <?= $form->field($model, 'estado') ?>

    <?= $form->field($model, 'fechaRegistro') ?>

    <?= $form->field($model, 'numeroDocumento') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
