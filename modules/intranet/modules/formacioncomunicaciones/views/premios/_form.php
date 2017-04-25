<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\select2\Select2;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\CategoriasPremios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categorias-premios-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'nombrePremio')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'descripcionPremio')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'puntosRedimir')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'cantidad')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'tipoRedimir')->widget(Select2::classname(), [
      'data' => \Yii::$app->params['formacioncomunicaciones']['tiposRedimirPremios'],
      'options' => ['placeholder' => 'Selecciona estado ...'],
      'hideSearch' => true,
      'pluginOptions' => [
        'allowClear' => true
      ],
    ]); ?>
    <?= $form->field($model, 'numeroPremios')->textInput(['maxlength' => true]) ?>
    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'rutaImagen')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'],
              'pluginOptions' => [
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
        <?= $form->field($model, 'rutaImagen')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'initialPreview'=>[
                  '<img src="'.Yii::getAlias('@web').'/img/formacioncomunicaciones/premios/'. $model->rutaImagen.'" class="img-responsive"
                    />'
                ],
                'maxFileSize' => 1024,
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'showPreview' => true,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false,
            ]
        ])->label('Imagen'); ?>

    <?php endif ?>
	  <?= $form->field($model, 'fechaInicioVigencia')->widget(DatePicker::classname(), [
          'type' => DatePicker::TYPE_INPUT,
          'options' => ['placeholder' => ''],
              'pluginOptions' => [
              'autoclose'=>true,
              'format' => 'yyyy-mm-dd'
              ]
          ]);
      ?>
      
        <?= $form->field($model, 'fechaFinVigencia')->widget(DatePicker::classname(), [
          'type' => DatePicker::TYPE_INPUT,
          'options' => ['placeholder' => ''],
              'pluginOptions' => [
              'autoclose'=>true,
              'format' => 'yyyy-mm-dd'
              ]
          ]);
      ?>
    <?= $form->field($model, 'estado')->widget(Select2::classname(), [
      'data' => ['1' => 'Activo', '0' => 'Inactivo'],
      'options' => ['placeholder' => 'Selecciona estado ...'],
      'hideSearch' => true,
      'pluginOptions' => [
        'allowClear' => true
      ],
    ]); ?>

    <div class="form-group">
      <label for="">Categoria</label>
      <div class="input-group">
        <div class="input-group-addon">
          <a href="#" data-toggle="modal" data-role="modal-padre-categoria">
            <?php if (!$model->isNewRecord && !is_null($model->objCategoria)): ?>
                <?php echo $model->objCategoria->nombreCategoria; ?>
             <?php else: ?>
                Asignar
             <?php endif ?> 
          </a>
        </div>
      </div>
    </div>

    <?= $form->field($model, 'idCategoria')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
