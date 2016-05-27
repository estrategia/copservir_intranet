<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\PublicacionesCampanas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="publicaciones-campanas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombreImagen')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rutaImagen')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'numeroDocumento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'urlEnlaceNoticia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fechaInicio')->textInput() ?>

    <?= $form->field($model, 'estado')->textInput() ?>

    <?= $form->field($model, 'posicion')->textInput() ?>

    <?= $form->field($model, 'fechaFin')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
