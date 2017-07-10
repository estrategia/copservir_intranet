<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use kartik\select2\Select2;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\Contenido */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contenido-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
      <div class="col-md-6">
        <?= $form->field($model, 'tituloContenido')->textInput() ?>
      </div>
      <div class="col-md-6">
        <?= $form->field($model, 'descripcionContenido')->textInput() ?>
      </div>
    </div>
  
    <div class="row">
      <div class="col-md-6">
        <?= $form->field($model, 'frecuenciaMes')->widget(Select2::classname(), [
          'data' => ['1' => 'Semestral', '2' => 'Anual'],
          'options' => ['placeholder' => 'Selecciona estado ...'],
          'hideSearch' => true,
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]); ?>
      </div>
      <div class="col-md-6">
        <?= $form->field($model, 'estadoContenido')->widget(Select2::classname(), [
          'data' => ['1' => 'Activo', '0' => 'Inactivo'],
          'options' => ['placeholder' => 'Selecciona estado ...'],
          'hideSearch' => true,
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]); ?>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <?= $form->field($model, 'idTercero')->widget(Select2::classname(), [
              'data' => $terceros,
              'options' => ['placeholder' => 'Selecciona proveedor ...'],
              'hideSearch' => false,
              'pluginOptions' => [
                'allowClear' => true
              ],
            ]); 
        ?>
      </div>
      <div class="col-md-6">
         <?= $form->field($model, 'cantidadPuntos')->textInput() ?>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <?php
          echo '<label class="control-label">Cargar paquete</label>';
          echo FileInput::widget([
            'name' => 'paqueteContenido',
            'pluginOptions' => [
              'allowedFileExtensions'  => ['zip'],
              'uploadUrl' => Url::toRoute('contenido/cargar-paquete'),
              'uploadAsync' => true,
              'maxFileCount' => 1,
              'uploadExtraData' => ['modelId' => $model->idContenido]
            ],
            // 'pluginEvents' => [
            //   'fileupload' => new JsExpression("function FunctionName() { console.log('Cargado'); }"),
            // ]
          ]);
        ?>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <?= $form->field($model, 'contenido')->widget(Widget::className(), [
            'id' => 'redactor',
            'settings' => [
              'replaceDivs' => false,
              'lang' => 'es',
              'minHeight' => 200,
              'imageUpload' => Url::toRoute('contenido/cargar-imagen'),
              'fileUpload' => Url::toRoute('contenido/cargar-archivo'),
              'plugins' => [
                'imagemanager',
                'localvideo' => 'localvideo',
              ],
              'fileManagerJson' => Url::to(['sitio/files-get']),
            ]
        ]); ?>
      </div>
    </div>
        
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['id' => 'btn-actualizar-contenido','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>