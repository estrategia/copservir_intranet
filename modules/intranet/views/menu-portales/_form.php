<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use app\modules\intranet\models\MenuPortales;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\MenuPortales */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-portales-form">

    <?php $form = ActiveForm::begin(['options' => ['id' => 'formMenuportales']]); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icono')->textInput(['maxlength' => true]) ?>

    <?php $model->estado = $model->isNewRecord ? 1 : $model->estado;  ?>
    <?= $form->field($model, 'estado')->dropDownList(['0' => 'Inactivo', '1' => 'Activo']); ?>

    <?=
        $form->field($model, 'idPortal')->widget(Select2::classname(), [
        'data' => $model->getListaPortales(),
        'options' => ['placeholder' => 'Selecione ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
      ]);
    ?>

    <div class="form-group">
      <label for="">Menu Padre</label>
      <div class="input-group">
        <?php
        $nombreSubmenu = '';
        if (!$model->isNewRecord) {
            if ($model->objMenuPadre) {
              $nombreSubmenu = $model->objMenuPadre->nombre;
            }
        }
        ?>

        <?=  html::textInput ( 'submenu', $value = $nombreSubmenu,
          $options = ['id' => 'submenu', 'class' => 'col-md-6 form-control ', 'disabled' => true] ) ?>
        <div class="input-group-addon">
          <a href="#" data-toggle="modal"  data-role="asignar-padre"> <!--data-target="#widget-submenu-portal"-->
            asignar
          </a>
        </div>
      </div>
    </div>
    <?php $model->idMenuPortalPadre = $model->isNewRecord ? NULL : $model->idMenuPortalPadre;  ?>
    <?= $form->field($model, 'idMenuPortalPadre')->hiddenInput(['value'=> $model->idMenuPortalPadre, ])->label(false); ?>

    <?=
      $form->field($model, 'fechaInicio')->widget(DateTimePicker::classname(), [
      'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:mm'
      ]
    ]);
    ?>

    <?=
      $form->field($model, 'fechaFin')->widget(DateTimePicker::classname(), [
      'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:mm'
      ]
    ]);
    ?>

    <?php $model->fechaRegistro = $model->isNewRecord ? date("Y-m-d H:i:s") : $model->fechaRegistro;  ?>
    <?= $form->field($model, 'fechaRegistro')->hiddenInput(['value'=> $model->fechaRegistro])->label(false); ?>

    <?php $model->fechaActualizacion = $model->isNewRecord ? date("Y-m-d H:i:s") : date("Y-m-d H:i:s");  ?>
    <?= $form->field($model, 'fechaActualizacion')->hiddenInput(['value'=> $model->fechaActualizacion])->label(false); ?>

    <?=
       $form->field($model, 'tipo')->widget(Select2::classname(), [
        'data' => [ MenuPortales::SIN_ENLACE => 'Sin Enlace', MenuPortales::ENLACE_INTERNO => 'Enlace Interno', MenuPortales::ENLACE_EXTERNO => 'Enlace externo'],
        'options' => ['placeholder' => 'Seleccione un tipo'],
        'pluginEvents' => [
                            "select2:selecting" => "function(e) { setInputUrl(e.params.args.data.id);}",
                          ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
      ]);
    ?>

    <div id="divUrlMenu">

    </div>

    <!--  ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::  -->
    <?php

      $inputUrl = $form->field($model, 'urlMenu')->textInput(['maxlength' => true]);
      $inputUrl = str_replace("\n", "", $inputUrl);

      $inputUrlHidden = $form->field($model, 'urlMenu')->hiddenInput(['value'=> ''])->label(false);
      $inputUrlHidden = str_replace("\n", "", $inputUrlHidden);

      $iditem = NULL;
      $bandera = 'false';
      if (!$model->isNewRecord) {
          $bandera = 'true';
          if ($model->objMenuPadre) {
            $iditem = $model->objMenuPadre->idMenuPortales;
          }
      }



      $this->registerJs("
          $( document ).ready(function() {





            valor = $('#menuportales-tipo').val();//parseInt($('#menuportales-tipo').val());
            if(".$bandera."){
              setInputUrl( valor );
              $('#item$iditem').css('background-color', '#0aa699')
              $('#item$iditem').css('color', 'white')
              $('#button$iditem').text('asignado')
            }
          });

        $(document).on('click', 'a[data-role=\'asignar-contenido\']', function() {
          var idModuloContendio = $(this).attr('data-modulo-contenido');
          asignarContenido(idModuloContendio,  $(this))
          return false;
        });

        function asignarContenido(option, element) {
          $('.field-menuportales-urlmenu').remove();
          $('#divUrlMenu').append('$inputUrlHidden');
          $('#menuportales-urlmenu').attr('value', option);
          $('.btn-select').text('seleccionar');
          element.text('ok');
        }

        function setInputUrl(selectedOption) {

          if(parseInt(selectedOption) === ".MenuPortales::ENLACE_EXTERNO."){

            $('#gridView-moduloContenido').hide();
            $('.field-menuportales-urlmenu').remove();
            $('#divUrlMenu').append('$inputUrl');
          }

          if(parseInt(selectedOption) === ".MenuPortales::ENLACE_INTERNO."){

            $('.field-menuportales-urlmenu').remove();
            $('#gridView-moduloContenido').show();
          }

          if(parseInt(selectedOption) === ".MenuPortales::SIN_ENLACE."){

            $('.field-menuportales-urlmenu').remove();
          }
        }
      ");
    ?>
    <?php ActiveForm::end(); ?>

    <div id="gridView-moduloContenido" hidden>
      <?= $this->render('_modulosContenidos', [
          'dataProviderModuloContenido'=> $dataProviderModuloContenido,
          'modelo' => $model,
          'searchModel' => $searchModel
      ]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'enviaFormularioMenuPortales']) ?>
    </div>

</div>

<?php
  /*
  $this->render('_modalSubMenu', [
    'model' => $model,
  ])
  */
?>
