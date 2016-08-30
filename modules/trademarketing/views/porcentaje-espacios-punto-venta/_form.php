<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $modelosEspacio array modelos Espacio */
/* @var $modelosPorcentaje array modelos PorcentajeEspaciosPuntoVenta*/
/* @var $form yii\widgets\ActiveForm */

?>

<div class="porcentaje-espacios-punto-venta-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-12">
        <?php foreach ($modelosEspacio as $index => $espacio): ?>

          <?php
          $modelosPorcentaje[$index]->idEspacio = $modelosPorcentaje[$index]->isNewRecord ?
                $espacio->idEspacio : $modelosPorcentaje[$index]->idEspacio;

          $modelosPorcentaje[$index]->valor = $modelosPorcentaje[$index]->isNewRecord ?
                0 : $modelosPorcentaje[$index]->valor
          ?>

          <?= 'Espacio: '.$espacio->nombre ?>

          <?= $form->field($modelosPorcentaje[$index], '['.$index.']idEspacio')->hiddenInput(
                ['value'=> $modelosPorcentaje[$index]->idEspacio])->label(false); ?>

          <?= $form->field($modelosPorcentaje[$index], '['.$index.']valor')->textInput(['maxlength' => true,
                ]) ?>

        <?php endforeach; ?>

        <div class="form-group">
            <?= Html::submitButton('Asignar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
