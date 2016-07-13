<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TipoPQRS */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="">
    <?php $form = ActiveForm::begin(); ?>
    <input type='hidden' value='<?= $model->idModulo ?>' id='idGrupo' name='idGrupo'/>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'tipo')->dropDownList(Yii::$app->params['modulosContenido'], ['prompt' => 'Seleccione...',]) ?>
    <?php else: ?>
        <?= $form->field($model, 'tipo')->dropDownList(Yii::$app->params['modulosContenido'], ['prompt' => 'Seleccione...', 'disabled' => ('disabled')]) ?>
    <?php endif; ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Actualizar'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
