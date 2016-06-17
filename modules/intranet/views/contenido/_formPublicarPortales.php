<?php

use app\modules\intranet\models\ContenidoDestino;
use app\modules\intranet\models\Parametros;
use kartik\select2\Select2;
use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\file\FileInput;

$maxFileCount = Parametros::obtenerValorParametro('contenido_maxFileCount');
$maxFileSize = Parametros::obtenerValorParametro('contenido_maxFileSize');

?>
<div class="publicar-portales">

<?php
  $form = ActiveForm::begin([
    'id' => 'form-contenido-publicar-portales',
    'options'=>['encytype'=>'multipart/form-data']
  ]);
?>


<?php
  echo $form->field($contenidoModel, 'titulo')->input(['value' => 1]);
?>

<?php
  echo $form->field($contenidoModel, 'contenido')->widget(Widget::className(), [

    'settings' => [
      'lang' => 'es',
      'minHeight' => 100,
      //'buttons' => ['format', 'bold', 'italic'],
      'imageUpload' => Url::toRoute('contenido/cargar-imagen'),
      'fileUpload' => Url::toRoute('contenido/cargar-archivo'),
      'plugins' => [
        'imagemanager',
      ],
      'fileManagerJson' => Url::to(['sitio/files-get']),
    ]
    ])->label(false);
?>

<?=
  FileInput::widget([
    'name'=> 'imagen[]',
    'id' => 'contenido-imagenes',
    'options' => ['multiple' => true, 'accept' => 'image/*'],
    'pluginOptions' => [
      'uploadAsync'=>false,
      'maxFileCount' => $maxFileCount,
      'validateInitialCount'=> true,
      'maxFileSize' => $maxFileSize,
      'previewFileType' => 'image',
      'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
      'browseLabel' =>  '',
      'showPreview' => true,
      'showCaption' => true,
      'showRemove' => true,
      'showUpload' => false,
      'uploadUrl' => Url::to(['/intranet/contenido/prueba']),
      'layoutTemplates' => [
        'actions' => '<div class="file-actions">' .
                    '    <div class="file-footer-buttons">' .
                      '        {delete}' .
                      '  </div>' .
                      '  <div class="clearfix"></div>' .
                      '</div>',
      ],
    ],
    'pluginLoading' => false,
  ]);
?>

<?php
  echo $form->field($contenidoModel, 'portales')->widget(Select2::classname(), [
    'data' => $contenidoModel->getListaPortales($esAdmin),
    'options' => ['placeholder' => 'Seleccione los portales', 'class'=>'js-example-disabled-multi'],
    'pluginEvents' => [
                        "select2:selecting" => "function(e) { setInputTimeLine(e.params.args.data.text); }",
                        "select2:unselecting" => "function(e) { setInputTimeLimeHide(e.params.args.data.text); }",
                      ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple' => true
    ],
  ]);
?>
<br>
<br>
<div id="divTimeLime">

</div>
<br>
<br>
<!-- DESTINOS -->

<div id="divDestinos" hidden>
  <?=
  Html::a('<i class = "fa fa-plus-square" ></i>', '#', [
    'data-role' => 'agregar-destino-contenido',
    'title' => 'Agregar nuevo'
  ]);
  ?>
  <?= Html::label('Añadir otro') ?>

  <div id="contenido-destino">
    <?php echo $this->render('_formDestinoContenido', ['objContenidoDestino' => new ContenidoDestino, 'consultaTodos' => $esAdmin]) ?>
  </div>

</div>

<?php

  $inputTimeLine = $form->field($contenidoModel, 'idLineaTiempo')->dropDownList(
    $contenidoModel->getListaLineasTiempo(),
    ['prompt'=>'Select...'])
    ->label('Linea de tiempo para el portal intranet');

  $inputTimeLine = str_replace("\n", "", $inputTimeLine);


  $bandera = 'true';
  if ($esAdmin) {
      $bandera = 'false';
  }

  $this->registerJs("

    $( document ).ready(function() {

      if ($bandera) {
         $('.js-example-disabled-multi').prop('disabled', true);
         $('.select2-search__field').remove()
         $('.js-example-disabled-multi').val(1);
         $('.js-example-disabled-multi').change();
         setInputTimeLine($('.js-example-disabled-multi option:selected').text());
      }
    });

    function setInputTimeLine(selectedOption) {

      if(selectedOption === 'intranet'){

        $('.field-contenido-idlineatiempo').remove();
        $('#divTimeLime').append('$inputTimeLine');
        $('#divDestinos').show();
      }
    }

    function setInputTimeLimeHide(selectedOption) {
      if(selectedOption === 'intranet'){
        $('.field-contenido-idlineatiempo').remove();
        $('#divDestinos').hide();
      }
    }
  ");
?>

<?php ActiveForm::end(); ?>

<br>
<br>
<div class="form-group">
  <?=
    Html::a($contenidoModel->isNewRecord ? 'Crear' : 'Actualizar', '#',  ['class' => 'btn btn-primary',
     'data-role' => $contenidoModel->isNewRecord ? 'guardar-contenido-publicar-portales' : 'actualizar-contenido-publicar-portales'])
  ?>
</div>
</div>