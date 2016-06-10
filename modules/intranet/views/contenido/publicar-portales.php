<?php
use kartik\select2\Select2;
use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\intranet\models\ContenidoDestino;


$this->title = 'Publicar en portales';
?>

<div class="col-md-12">
  <h3>Publica una noticia en un portal</h3>
  <br>
  <?php
    $form = ActiveForm::begin([
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
        'imageUpload' => Url::toRoute('sitio/cargar-imagen'),
        'fileUpload' => Url::toRoute('sitio/cargar-archivo'),
        'plugins' => [
          'imagemanager',
        ],
        'fileManagerJson' => Url::to(['sitio/files-get']),
      ]
      ])->label(false);
  ?>

  <?php
    echo $form->field($contenidoModel, 'portales')->widget(Select2::classname(), [
      'data' => $contenidoModel->getListaPortales(),
      'options' => ['placeholder' => 'Seleccione los portales'],
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
      <?php echo $this->render('_formDestinoContenido', ['objContenidoDestino' => new ContenidoDestino]) ?>
    </div>

  </div>


  <br>
  <br>
  <div class="form-group">
    <?=
      Html::submitButton('Publicar', ['class' => 'btn btn-primary'])
    ?>
  </div>

  <?php

    $inputTimeLine = $form->field($contenidoModel, 'idLineaTiempo')->dropDownList(
      $contenidoModel->getListaLineasTiempo(),
      ['prompt'=>'Select...'])
      ->label('Linea de tiempo para el portal intranet');

    $inputTimeLine = str_replace("\n", "", $inputTimeLine);

    $this->registerJs("

      function setInputTimeLine(selectedOption) {
        if(selectedOption === 'intranet'){
          console.log('entro');
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
</div>
