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
<div class="col-md-12">
    

        <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <?php if ($model->isNewRecord): ?>
                    <?= $form->field($model, 'numeroDocumento')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                <?php endif ?>
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
            </div>
            <br>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>
</div>

</div>
