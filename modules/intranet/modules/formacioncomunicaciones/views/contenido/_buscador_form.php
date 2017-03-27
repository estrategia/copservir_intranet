<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\ContenidoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contenido-search">

    <?php $form = ActiveForm::begin([
        'action' => ['buscador'],
        'method' => 'get',
    ]); ?>
    
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'tituloContenido') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'idAreaConocimiento')->widget(Select2::classname(), [
              'data' => $areas,
              'options' => ['placeholder' => 'Selecciona un Área de conocimiento ...'],
              'pluginOptions' => [
                'allowClear' => true
              ],
            ]); ?>
        </div>
        <div class="col-md-4">
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
        <div class="col-md-4">
            <?= $form->field($model, 'idCapitulo')->widget(Select2::classname(), [
              'data' => $capitulos,
              'options' => ['placeholder' => 'Selecciona un Capítulo ...'],
              'pluginOptions' => [
                'allowClear' => true
              ],
            ]); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'idTipoContenido')->widget(Select2::classname(), [
              'data' => $tipos,
              'options' => ['placeholder' => 'Selecciona un Tipo de Contenido ...'],
              'pluginOptions' => [
                'allowClear' => true
              ],
            ]); ?>
        </div>
        <div class="col-md-4" class="botones-buscador">
        <br>
            <div class="form-group" style="margin: 0;">
                <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary', 'style'=> 'width: 49%;']) ?>
                <?= Html::resetButton('Limpiar', ['class' => 'btn btn-default', 'style'=> 'width: 49%;', 'id' => 'reset-formulario-buscador-contenido']) ?>
            </div>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
