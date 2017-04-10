<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\ParametrosPuntos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parametros-puntos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tipoParametro')->textInput() ?>

    <?= $form->field($model, 'valorPuntos')->textInput() ?>

    <?= $form->field($model, 'idTipoContenido')->textInput() ?>

    <?= $form->field($model, 'condicion')->textInput() ?>

    <?= $form->field($model, 'estado')->widget(Select2::classname(), [
      'data' => ['1' => 'Activo', '0' => 'Inactivo'],
      'options' => ['placeholder' => 'Selecciona estado ...'],
      'hideSearch' => true,
      'pluginOptions' => [
        'allowClear' => true
      ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
