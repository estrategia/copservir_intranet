<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use app\modules\intranet\models\ContenidoDestino;
use kartik\select2\Select2;
use yii\helpers\Url;

?>

<div class="ofertas-laborales-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'tituloOferta')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'descripcionContactoOferta')->textarea(['rows' => 6]) ?>

  <?php $model->estado = $model->isNewRecord ? 1 : $model->estado;  ?>
  <?= $form->field($model, 'estado')->dropDownList(['0' => 'Inactivo', '1' => 'Activo']); ?>

  <?= $form->field($model, 'urlElEmpleo')->textInput(['maxlength' => true]) ?>

  <?=
  $form->field($model, 'nombreCargo')->widget(Select2::classname(), [
    'data' => $model->listaCargo,
    'options' => ['placeholder' => 'Seleccione el cargo de la oferta']
  ]);
  ?>
  
  <?=
  $form->field($model, 'idCiudad')->widget(Select2::classname(), [
    'data' => $model->listaCiudad,
    'options' => ['placeholder' => 'Seleccione la ciudad de la oferta']
  ]);
  ?>

  <?=
  $form->field($model, 'fechaPublicacion')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
      'autoclose' => true,
      'format' => 'yyyy-m-d H:i:s'
    ]
  ]);
  ?>

  <?=
   $form->field($model, 'fechaCierre')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
      'autoclose' => true,
      'format' => 'yyyy-m-d H:i:s'
    ]
  ]);
  ?>

  <?= $form->field($model, 'numeroDocumento')->hiddenInput(['value'=> Yii::$app->user->identity->numeroDocumento])->label(false); ?>

  <?= 
  $form->field($model, 'idInformacionContacto')->dropDownList(
	  $model->listaPlantillas,
	  [
	  	'prompt'=>'Seleccione la plantilla',
	    'onchange'=>'getPlantilla($(this).val());'
	  ]
  ); 
  ?>

<br>

<div id="plantilla" hidden >
  <label> Contenido de la plantilla</label>
  <div id="contenido-plantilla"></div>
</div>
<br>
<br>

<div class="form-group">
  <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>

<div class="col-md-12"> <hr> </div>

<div class="col-md-12">
  <?php if (!$model->isNewRecord): ?>

      <div id="destinosOfertas">
        <?= $this->render('_destinoOfertas', ['model' => $model, 'destinoOfertasLaborales' => $destinoOfertasLaborales, 'modelDestinoOferta' => $modelDestinoOferta]) ?>
      </div>

    </div>
  <?php endif ?>
</div>

<!-- para cargar la plantilla si va a actualizar -->
<?php
if (!$model->isNewRecord):
  $this->registerJs("getPlantilla($('#ofertaslaborales-idinformacioncontacto').val());");
  endif
  ?>
