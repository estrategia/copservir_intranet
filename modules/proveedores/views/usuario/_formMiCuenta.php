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

    <?php $form = ActiveForm::begin(); ?>
        <div class="form-header">
            <h4>Información Personal</h4>
        </div>
        <div class="row">
            <div class="col-md-6">
                <!-- <?= $form->field($model, 'profesion')->textInput(['maxlength' => true]) ?> -->
                <?php 
                    echo $form->field($model, 'idProfesion')->widget(Select2::classname(), [
                        'data' => $profesiones,
                        'options' => ['placeholder' => 'Selecciona una profesion'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'fechaNacimiento')->widget(DatePicker::classname(), [
                    'type' => DatePicker::TYPE_INPUT,
                    'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                        ]
                    ]); 
                ?>
            </div>
        </div>
        <div class="form-header">
            <h4>Información de Contacto</h4>
        </div>
        <div class="row">
            <div class="col-md-6">
                <!-- <?= $form->field($model, 'nitLaboratorio')->textInput(['maxlength' => true]) ?> -->
                <?= $form->field($model, 'Direccion')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?php 
                    echo $form->field($model, 'Ciudad')->widget(Select2::classname(), [
                        'data' => $ciudades,
                        'options' => ['placeholder' => 'Selecciona una ciudad'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>
            </div>
            <div class="col-md-6">
				<?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
				<?= $form->field($model, 'celular')->textInput(['maxlength' => true]) ?>
            </div>				
        </div>
        <?php if(Yii::$app->user->identity->confirmarDatosPersonales == 0): ?>
            <div class="form-header">
                <h4>Política de Tratamiento de Datos</h4>
            </div>
            <div class="row">
                <div class="col-md-12" style="display: inline-flex;">
                    <?= $form->field($model, 'confirmarDatosPersonales')->checkbox() ?>
                    <a style="margin-left: 5px;" class="pull-left" href=" <?php echo Yii::$app->getUrlManager()->getBaseUrl() . Yii::$app->params['habeasDataLink']; ?> ">Ver términos.</a>
                </div>
            </div>
        <?php endif; ?>
        <br>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
