<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\LineaTiempo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="linea-tiempo-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'nombreLineaTiempo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>
    <?php
    echo \vova07\imperavi\Widget::widget([
        'selector' => '#lineatiempo-descripcion',
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

    <?php $model->estado = $model->isNewRecord ? 1 : $model->estado;  ?>
    <?= $form->field($model, 'estado')->dropDownList(['0' => 'Inactivo', '1' => 'Activo']); ?>
    <?php $model->tipo = $model->isNewRecord ? 0 : $model->tipo;  ?>
    <?= $form->field($model, 'tipo')->dropDownList(['0' => 'Publicación', '1' => 'Clasificado', '2'=>'Aniversario']); ?>
    <?= $form->field($model, 'orden')->textInput(['type' => 'number']) ?>

    <?=
      $form->field($model, 'fechaInicio')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
          'autoclose' => true,
          'format' => 'yyyy-mm-dd hh:ii:ss'
        ]
      ]);
    ?>

    <?=
      $form->field($model, 'fechaFin')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
          'autoclose' => true,
          'format' => 'yyyy-mm-dd hh:ii:ss'
        ]
      ]);
    ?>

    <?php $model->autorizacionAutomatica = $model->isNewRecord ? 0 : $model->autorizacionAutomatica;  ?>
    <?= $form->field($model, 'autorizacionAutomatica')->dropDownList(['0' => 'No', '1' => 'Si']); ?>

    <?php $model->solicitarGrupoObjetivo = $model->isNewRecord ? 0 : $model->solicitarGrupoObjetivo;  ?>
    <?= $form->field($model, 'solicitarGrupoObjetivo')->dropDownList(['0' => 'No', '1' => 'Si']); ?>

    <?php $model->color = $model->isNewRecord ? "#0090D9" : $model->color;  ?>
    <?= $form->field($model, 'color',
      [
        'template' => "{label}{input}"
      ])->input('color',['class'=>"input_class", 'value' => $model->color]) ?>

    <?= $form->field($model, 'icono')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
