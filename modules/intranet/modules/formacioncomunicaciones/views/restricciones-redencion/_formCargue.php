<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\RestriccionesRedencion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cargue-restricciones-redencion-form">

    
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
      <div class="col-md-3">
        <?= $form->field($model, 'archivo')->fileInput()->label(false); ?>
      </div>

      <div class="col-md-4">
        <?= Html::submitButton('Cargar', ['class' => 'btn btn-primary']) ?>
      </div>  
    </div>

    <?php ActiveForm::end(); ?>

</div>
