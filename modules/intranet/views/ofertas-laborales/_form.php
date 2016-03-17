<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\OfertasLaborales */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ofertas-laborales-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idOfertaLaboral')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cargo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idContenidoDestino')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idCiudad')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fechaPublicacion')->textInput() ?>

    <?= $form->field($model, 'fechaCierre')->textInput() ?>

    <?= $form->field($model, 'idUsuarioPublicacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fechaInicioPublicacion')->textInput() ?>

    <?= $form->field($model, 'fechaFinPublicacion')->textInput() ?>

    <?= $form->field($model, 'tituloOferta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'urlElEmpleo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idCargo')->textInput() ?>

    <?= $form->field($model, 'idArea')->textInput() ?>

    <?= $form->field($model, 'descripcionContactoOferta')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'idInformacionContacto')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
