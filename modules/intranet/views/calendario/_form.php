<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
use kartik\select2\Select2;
use app\modules\intranet\models\MenuPortales;
use app\modules\intranet\models\EventosCalendarioDestino;
use app\modules\intranet\models\EventosCalendario;

?>

<div class="menu-portales-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-6">
        <?= $form->field($model, 'tituloEvento')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

        <?php $model->estado = $model->isNewRecord ? 1 : $model->estado;  ?>
        <?= $form->field($model, 'estado')->dropDownList(['0' => 'Inactivo', '1' => 'Activo']); ?>

        <?=
          $form->field($model, 'fechaInicioEvento')->widget(DatePicker::classname(), [
          'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
          ]
        ]);
        ?>

        <?=
          $form->field($model, 'fechaFinEvento')->widget(DatePicker::classname(), [
          'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
          ]
        ]);
        ?>

    </div>

    <div class="col-md-6">

      <?=
        $form->field($model, 'horaInicioEvento')->widget(TimePicker::classname(), [
        'pluginOptions' => [
          'autoclose' => true,
          'minuteStep' => 5,
          'secondStep' => 5,
          'showMeridian' => false,

        ]
      ]);
      ?>

      <?=
        $form->field($model, 'horaFinEvento')->widget(TimePicker::classname(), [
        'pluginOptions' => [
          'autoclose' => true,
          'minuteStep' => 5,
          'secondStep' => 5,
          'showMeridian' => false,

        ]
      ]);
      ?>

      <?=
        $form->field($model, 'fechaInicioVisible')->widget(DatePicker::classname(), [
        'pluginOptions' => [
          'autoclose' => true,
          'format' => 'yyyy-mm-dd'
        ]
      ]);
      ?>

      <?php
        echo $form->field($model, 'idPortal')->widget(Select2::classname(), [
          'data' => $model->getListaPortales(),
          'options' => ['placeholder' => 'Seleccione el portal'],
          'pluginEvents' => [
                              "select2:selecting" => "function(e) { setInputTimeLine(e.params.args.data.text); }",
                            ],
          'pluginOptions' => [
              'allowClear' => true,
          ],
        ]);
      ?>
    </div>

    <?php $model->numeroDocumento = $model->isNewRecord ? Yii::$app->user->identity->numeroDocumento : $model->numeroDocumento;  ?>
    <?= $form->field($model, 'numeroDocumento')->hiddenInput(['value'=> $model->numeroDocumento])->label(false);  ?>

    <?php $model->fechaRegistro = $model->isNewRecord ? date("Y-m-d H:i:s") : $model->fechaRegistro;  ?>
    <?= $form->field($model, 'fechaRegistro')->hiddenInput(['value'=> $model->fechaRegistro])->label(false); ?>

    <div class="col-md-12" id="divDestinos" hidden>
      <div id="contenido-destino">
          <?= $this->render('_formCalendarioDestino', ['objContenidoDestino' => new EventosCalendarioDestino]); ?>
      </div>
    </div>

    <div class="form-group col-md-12">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'enviaFormularioMenuPortales']) ?>
    </div>

    <?php

      $bandera = 'true';
      if (!$model->isNewRecord) {
          $bandera = 'false';
      }

      $inputUrl = $form->field($model, 'url')->textInput(['maxlength' => true]);
      $inputUrl = str_replace("\n", "", $inputUrl);

      $inputUrlHidden = $form->field($model, 'url')->hiddenInput(['value'=> ''])->label(false);
      $inputUrlHidden = str_replace("\n", "", $inputUrlHidden);

      $this->registerJs("
        function setInputTimeLine(selectedOption) {
          if(selectedOption === 'intranet' && ".$bandera."){
            $('#divDestinos').show();
          }else{
            $('#divDestinos').hide();
          }
        }
      ");
    ?>

    <?php ActiveForm::end(); ?>

</div>

<div class="col-md-12"> <hr> </div>

<div class="col-md-12">
  <?php if (!$model->isNewRecord): ?>
      <div id="destinosEventos">
        <?= $this->render('_destinoEventos', ['model' => $model, 'destinoEventosCalendario' => $destinoEventosCalendario, 'modelDestinoEventos' => $modelDestinoEventos]) ?>
      </div>
    </div>
  <?php endif ?>
</div>
