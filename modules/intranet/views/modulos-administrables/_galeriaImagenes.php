<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;

?>

<?php
  $form = ActiveForm::begin([
    'id' => 'form-imagenes-modulo-galeria',
    'options'=>['encytype'=>'multipart/form-data']
  ]);
?>

<div class="form-group">
  <?= $form->field($modeloImagen, 'nombreImagen')->textInput()->label("Nombre") ?>
</div>

<div class="form-group">
  <?= $form->field($modeloImagen, 'orden')->textInput()->label("Orden") ?>
</div>

<div class="form-group">
  <?= $form->field($modeloImagen, 'imagen')->FileInput()->label("Imagen") ?>
</div>

<div class='form-group'>
    <?php echo Html::submitButton('Cargar', array('id' => 'btnCargar', 'class' => 'btn btn-primary')); ?>
</div>

<?php ActiveForm::end(); ?>

<div id="lista-imagenes-modulo-galeria">
  <?php echo $this->render('_listaImagenes', ['idModulo' => $model->idModulo, 'dataProvider' => $dataProviderImagen, 'searchModel' => $searchModelImagen]); ?>
</div>

<div id="div-editar-imagen"></div>
