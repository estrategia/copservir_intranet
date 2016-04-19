<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use vova07\imperavi\Widget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\ContenidoEmergente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contenido-emergente-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'contenido')->textarea(['rows' => 6]) ?>

    <?php
      echo \vova07\imperavi\Widget::widget([
          'selector' => '#contenidoemergente-contenido',
          'settings' => [
              'lang' => 'es',
              'minHeight' => 80,
              'imageManagerJson' => Url::to(['/default/images-get']),
              'plugins' => [
                  'imagemanager'
              ]
          ]
      ]);
    ?>

    <?php

    echo '<label class="control-label">Fecha de inicio de campaña</label>';
    echo DateTimePicker::widget([
      'model' => $model,
      'attribute' => 'fechaInicio',
      'options' => ['placeholder' => ''],
      'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-m-d H:i:s'
      ]
    ]);

    ?>
    <br>
    <?php

    echo '<label class="control-label">Fecha de fin de campaña</label>';
    echo DateTimePicker::widget([
      'model' => $model,
      'attribute' => 'fechaFin',
      'options' => ['placeholder' => ''],
      'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-m-d H:i:s'
      ]
    ]);

    ?>
    <br>

    <?php $model->estado = $model->isNewRecord ? 1 : $model->estado;  ?>
    <?= $form->field($model, 'estado')->dropDownList(['0' => 'Inactivo', '1' => 'Activo']); ?>

    <?php $fechaRegistro = $model->isNewRecord ? Date("Y-m-d H:i:s") : $model->fechaRegistro;  ?>
    <?= $form->field($model, 'fechaRegistro')->hiddenInput(['value'=> $fechaRegistro])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
