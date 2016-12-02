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
<?php $form = ActiveForm::begin(); ?>
    <div class="form-header">
        <h4>Información Personal</h4>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'numeroDocumento')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'primerApellido')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'segundoApellido')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <?php //echo $form->field($model, 'profesion')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?php /*echo $form->field($model, 'fechaNacimiento')->widget(DatePicker::classname(), [
                'type' => DatePicker::TYPE_INPUT,
                'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd'
                    ]
                ]); */
            ?>
        </div>
    </div>
    <div class="form-header">
        <h4>Información de Contacto</h4>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'celular')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php //echo $form->field($model, 'Direccion')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6"></div>

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
            	echo $form->field($model, 'nitLaboratorio')->hiddenInput(['value' => 'nit'])->label(false);
            ?>
    </div>
    <br>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

