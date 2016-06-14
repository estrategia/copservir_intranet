<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\file\FileInput;
use kartik\select2\Select2;
use app\modules\intranet\models\CampanasDestino;
?>

<div class="publicaciones-campanas-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'nombreImagen')->textInput(['maxlength' => true]) ?>

    <?php if ($model->isNewRecord): ?>
      <?=
        $form->field($model, 'rutaImagen')->widget(FileInput::classname(), [
          'options' => ['accept' => 'image/*'],
          'pluginOptions' => [
            'maxFileCount' => 1,
            'validateInitialCount'=> true,
            'maxFileSize' => 5120,
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            'showPreview' => true,
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => false,
          ]
        ])->label('Imagen');
      ?>

    <?php else: ?>
      <?=
        $form->field($model, 'rutaImagen')->widget(FileInput::classname(), [
          'options' => ['accept' => 'image/*'],
          'pluginOptions' => [
            'initialPreview'=>[

              '<img src="'.Yii::getAlias('@web').'/img/campanas/'. $model->rutaImagen.'" class="img-responsive"
                />'

            ],
            'overwriteInitial'=>false,
            'initialPreviewAsData'=>true,
            'maxFileCount' => 1,
            'validateInitialCount'=> true,
            'maxFileSize' => 5120,
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            'showPreview' => true,
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => false,
          ]
        ])->label('Imagen');
      ?>

    <?php endif; ?>


    <?php $model->numeroDocumento = $model->isNewRecord ? Yii::$app->user->identity->numeroDocumento : $model->numeroDocumento;  ?>
    <?= $form->field($model, 'numeroDocumento')->hiddenInput(['value'=> $model->numeroDocumento])->label(false); ?>

    <?= $form->field($model, 'urlEnlaceNoticia')->textInput(['maxlength' => true]) ?>

    <?php $model->estado = $model->isNewRecord ? 1 : $model->estado;  ?>
    <?= $form->field($model, 'estado')->dropDownList(['0' => 'Inactivo', '1' => 'Activo']); ?>

    <?php $model->posicion = $model->isNewRecord ? 0 : $model->posicion;  ?>
    <?= $form->field($model, 'posicion')->dropDownList(['0' => 'Superior', '1' => 'Inferior', '2'=>'Derecha']); ?>

    <?php
    echo  $form->field($model, 'fechaInicio')->widget(DateTimePicker::classname(), [
      'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:mm'
      ]
    ]);
    ?>

    <?php
    echo  $form->field($model, 'fechaFin')->widget(DateTimePicker::classname(), [
      'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:mm'
      ]
    ]);
    ?>

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
      <div id="destinosCampana">
        <?= $this->render('_destinoCampanas', ['model' => $model, 'destinoCampanas' => $destinoCampanas, 'modelDestinoCampana' => $modelDestinoCampana]) ?>
      </div>
    </div>
  <?php endif ?>
</div>
