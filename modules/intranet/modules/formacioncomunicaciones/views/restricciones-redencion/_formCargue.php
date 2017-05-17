<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\RestriccionesRedencion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cargue-restricciones-redencion-form">

    
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'archivo')->fileInput(); ?>

    <div class="form-group">
        <?= Html::submitButton('Cargar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
