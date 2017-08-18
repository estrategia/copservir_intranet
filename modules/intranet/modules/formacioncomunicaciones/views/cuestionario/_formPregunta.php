<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use vova07\imperavi\Widget;
?>

<div class="cuestionario-form">
    
    <?php $form = ActiveForm::begin(); ?>
    
    <?php $model->estado = $model->isNewRecord ? 1 : $model->estado;  ?>

    <?= $form->field($model, 'pregunta')->textArea(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado')->dropDownList(['0' => 'Inactivo', '1' => 'Activo']); ?>

    <?= $form->field($model, 'idTipoPregunta')->dropDownList(ArrayHelper::map($tipoPreguntas, 'idTipoPregunta','tipoPregunta')); ?>
    
    <?= $form->field($model, 'idCuestionario')->hiddenInput(['value' => $modelCuestionario->idCuestionario])->label(false); ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>