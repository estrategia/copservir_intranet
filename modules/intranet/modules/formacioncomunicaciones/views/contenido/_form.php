<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
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
        <?= $form->field($model, 'idAreaConocimiento')->widget(Select2::classname(), [
          'data' => $areas,
          'options' => ['placeholder' => 'Selecciona un Área de conocimiento ...'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]); ?>
      </div>
      <div class="col-md-6">
        <?= $form->field($model, 'idModulo')->widget(Select2::classname(), [
          'data' => $modulos,
          'options' => ['placeholder' => 'Selecciona un Modulo ...'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <?= $form->field($model, 'idCapitulo')->widget(Select2::classname(), [
          'data' => $capitulos,
          'options' => ['placeholder' => 'Selecciona un Capítulo ...'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]); ?>
      </div>
      <div class="col-md-6">
        <?= $form->field($model, 'idTipoContenido')->widget(Select2::classname(), [
          'data' => $tipos,
          'options' => ['placeholder' => 'Selecciona un Tipo de Contenido ...'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <?= $form->field($model, 'fechaInicio')->widget(DatePicker::classname(), [
            'type' => DatePicker::TYPE_INPUT,
            'options' => ['placeholder' => ''],
                'pluginOptions' => [
                  'autoclose'=>true,
                  'format' => 'yyyy-mm-dd'
                ]
            ]); 
        ?>
      </div>
      <div class="col-md-6">
        <?= $form->field($model, 'fechaFin')->widget(DatePicker::classname(), [
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
      <div class="col-md-12">
        <?= $form->field($model, 'contenido')->widget(Widget::className(), [
            'settings' => [
              'replaceDivs' => false,
              'lang' => 'es',
              'minHeight' => 200,
              'imageUpload' => Url::toRoute('contenido/cargar-imagen'),
              'fileUpload' => Url::toRoute('contenido/cargar-archivo'),
              'plugins' => [
                'imagemanager',
              ],
              'fileManagerJson' => Url::to(['sitio/files-get']),
            ]
        ]); ?>
      </div>
    </div>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
