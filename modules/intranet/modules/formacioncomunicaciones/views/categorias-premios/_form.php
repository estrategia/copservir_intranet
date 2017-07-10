<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\CategoriasPremios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categorias-premios-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'nombreCategoria')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'orden')->textInput() ?>
    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'rutaIcono')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'],
              'pluginOptions' => [
                'maxFileSize' => 1024,
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'showPreview' => true,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false,
              ]
            ])->label('Icono');
        ?>

    <?php else: ?>
        <?= $form->field($model, 'rutaIcono')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'initialPreview'=>[
                  '<img src="'.Yii::getAlias('@web') . Yii::$app->params['formacioncomunicaciones']['rutaImagenCategorias'] . $model->rutaIcono.'" class="img-responsive"/>'
                ],
                'maxFileSize' => 1024,
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'showPreview' => true,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false,
            ]
        ])->label('Icono'); ?>

    <?php endif ?>

    <?= $form->field($model, 'estado')->widget(Select2::classname(), [
      'data' => ['1' => 'Activo', '0' => 'Inactivo'],
      'options' => ['placeholder' => 'Selecciona estado ...'],
      'hideSearch' => true,
      'pluginOptions' => [
        'allowClear' => true
      ],
    ]); ?>

    <div class="form-group">
      <label for="">Categoria padre</label>
      <div class="input-group">
        <div class="input-group-addon">
          <a href="#" data-toggle="modal" data-role="modal-padre-categoria">
            <?php if (!$model->isNewRecord && !is_null($model->categoriaPadre)): ?>
                <?php echo $model->categoriaPadre->nombreCategoria; ?>
             <?php else: ?>
                Asignar
             <?php endif ?> 
          </a>
        </div>
      </div>
      <a href="#" data-role="categoria-padre-eliminar">Eliminar Asignación</a>
    </div>

    <?= $form->field($model, 'idCategoriaPadre')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
