<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\ContenidoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contenido-search">

    <?php $form = ActiveForm::begin([
        'action' => ['buscador'],
        'method' => 'get',
    ]); ?>
    
    <?= $form->field($model, 'nombreCurso') ?>
    
    <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
    
    <?php ActiveForm::end(); ?>

</div>
