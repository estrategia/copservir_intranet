<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
use kartik\select2\Select;
use bootstrap\modal;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\models\UsuarioProveedor */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="row">       

        <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <?= $form->field($model, 'numeroDocumento')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="row">
                    <?= $form->field($model, 'primerApellido')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'segundoApellido')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="row">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'celular')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="row">
                    <?php
                       /* echo '<label for="laboratorio" class="control-label">Laboratorio</label>';
                        echo Select2::widget([
                            'model' => $model,
                            'name' => 'laboratorio',
                            'attribute' => 'nitLaboratorio',
                            'value' => '',
                            'data' => $terceros,
                            'options' => ['multiple' => false, 'placeholder' => 'Selecciona laboratorio ...']
                        ]);*/
                    	echo $form->field($model, 'nitLaboratorio')->widget(Select2::classname(), [
                    		'data' => $terceros,
                    		'options' => ['placeholder' => 'Selecciona laboratorio ...'],
                    		'pluginOptions' => [
                    				'allowClear' => true
                    		],
                    	]);
                    ?>
                    <?php //echo $form->field($model, 'nitLaboratorio')->textInput(['maxlength' => true]) ?>
                    <?php
                        /*echo '<label for="unidadNegocio" class="control-label">Unidad de negocio</label>';
                        echo Select2::widget([
                            'model' => $model,
                            'name' => 'unidadNegocio',
                            'attribute' => 'idAgrupacion',
                            'value' => '',
                            'data' => $unidadesNegocio,
                            'options' => ['multiple' => false, 'placeholder' => 'Selecciona unidad de negocio ...']
                        ]);*/
                    	// echo $form->field($model, 'idAgrupacion')->widget(Select2::classname(), [
                    	// 	'data' => $unidadesNegocio,
                    	// 	'options' => ['placeholder' => 'Selecciona unidad negocio ...'],
                    	// 	'pluginOptions' => [
                    	// 			'allowClear' => true
                    	// 	],
                    	// ]);
                    ?>
            </div>
            <br>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>
</div>
