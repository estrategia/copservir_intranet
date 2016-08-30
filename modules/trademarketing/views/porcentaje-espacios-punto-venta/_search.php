<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\PorcentajeEspaciosPuntoVentaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="porcentaje-espacios-punto-venta-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idPorcentajeEspacio') ?>

    <?= $form->field($model, 'idComercial') ?>

    <?= $form->field($model, 'idEspacio') ?>

    <?= $form->field($model, 'valor') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
