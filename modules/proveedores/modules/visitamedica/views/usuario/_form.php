<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
use kartik\select2\Select;
use kartik\select2\Select2;
use bootstrap\modal;

/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\modules\visitamedica\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-md-12 col-xs-12 col-sm-12">
        

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model); ?>
        <div class="page-header">
            <h4>Informacion personal</h4>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'numeroDocumento')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <!-- <?= $form->field($model, 'profesion')->textInput(['maxlength' => true]) ?> -->
                <?= $form->field($model, 'primerApellido')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'segundoApellido')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="page-header">
            <h4>Informacion de contacto</h4>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'celular')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
            </div>
            
        </div>
        <br>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

    </div>
</div>
