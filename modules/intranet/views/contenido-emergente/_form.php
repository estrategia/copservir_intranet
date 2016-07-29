<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;

?>

<div class="contenido-emergente-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'contenido')->textarea(['rows' => 6]) ?>

    <?php
    echo \vova07\imperavi\Widget::widget([
        'selector' => '#contenidoemergente-contenido',
        'settings' => [
            'replaceDivs' => false,
            'lang' => 'es',
            'minHeight' => 80,
            'imageUpload' => Url::toRoute('contenido/cargar-imagen'),
            'fileUpload' => Url::toRoute('contenido/cargar-archivo'),
            'plugins' => [
                'imagemanager',
            ],
            'fileManagerJson' => Url::to(['sitio/files-get']),
        ]
    ]);
    ?>

    <?php
    echo $form->field($model, 'fechaInicio')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-m-d H:i:s'
        ]
    ]);
    ?>
    <br>
    <?php
    echo $form->field($model, 'fechaFin')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-m-d H:i:s'
        ]
    ]);
    ?>
    <br>

    <?php $model->estado = $model->isNewRecord ? 1 : $model->estado; ?>
    <?= $form->field($model, 'estado')->dropDownList(['0' => 'Inactivo', '1' => 'Activo']); ?>

    <?php $fechaRegistro = $model->isNewRecord ? Date("Y-m-d H:i:s") : $model->fechaRegistro; ?>
    <?= $form->field($model, 'fechaRegistro')->hiddenInput(['value' => $fechaRegistro])->label(false); ?>

    <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div class="col-md-12"> <hr> </div>

<div class="col-md-12">
    <?php if (!$model->isNewRecord): ?>
        <div class="col-md-12">
            <br><br>
            <div id="destinosContenidoEmergente">
            <?= $this->render('_destinoContenidoEmergente', ['model' => $model, 'destinoContenidoEmergente' => $destinoContenidoEmergente, 'modelDestinoContenidoEmergente' => $modelDestinoContenidoEmergente]) ?>
            </div>
        </div>
    <?php endif ?>
</div>
