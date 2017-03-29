<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\Portal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="portal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombrePortal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado')->textInput() ?>
    
    <?= $form->field($model, 'logoPortal')->fileInput() ?>

    <?= $form->field($model, 'colorPortal', [
      'template' => "{input}"
    ])->input('color',['class'=>"input_class"]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
