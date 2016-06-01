<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\datetime\DateTimePicker;
use app\modules\intranet\models\ContenidoDestino;


use kartik\select2\Select2;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\OfertasLaborales */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ofertas-laborales-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'tituloOferta')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'descripcionContactoOferta')->textarea(['rows' => 6]) ?>

  <?= $form->field($model, 'urlElEmpleo')->textInput(['maxlength' => true]) ?>

  <?= Select2::widget([
    'name' => 'OfertasLaborales[idCargo]',
    'value' => $model->idCargo,
    'id' => "grupo1_",
    'data' => $model->listaCargo,
    'options' => ['placeholder' => 'Seleccione el cargo de la oferta']
  ]);
  ?>

  <br>

  <?= Select2::widget([
    'name' => 'OfertasLaborales[idArea]',
    'value' => $model->idArea,
    'id' => "grupo2_",
    'data' => $model->listaArea,
    'options' => ['placeholder' => 'Seleccione el area de la oferta']
  ]);
  ?>

  <br>

  <?= Select2::widget([
    'name' => 'OfertasLaborales[idCiudad]',
    'value' => $model->idCiudad,
    'id' => "grupo_",
    'data' => $model->listaCiudad,
    'options' => ['placeholder' => 'Seleccione la ciudad de la oferta']
  ]);
  ?>
  <br>
  <?php

  echo '<label class="control-label">fecha publicacion</label>';
  echo DateTimePicker::widget([
    'model' => $model,
    'attribute' => 'fechaPublicacion',
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
      'autoclose' => true,
      'format' => 'yyyy-m-d H:i:s'
    ]
  ]);
  ?>

  <?php

  echo '<label class="control-label">fecha cierra</label>';
  echo DateTimePicker::widget([
    'model' => $model,
    'attribute' => 'fechaCierre',
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
      'autoclose' => true,
      'format' => 'yyyy-m-d H:i:s'
    ]
  ]);
  ?>

  <?= $form->field($model, 'numeroDocumento')->hiddenInput(['value'=> Yii::$app->user->identity->numeroDocumento])->label(false); ?>

  <?php
  echo '<label class="control-label">fecha inicio publicacion</label>';
  echo DateTimePicker::widget([
    'model' => $model,
    'attribute' => 'fechaInicioPublicacion',
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
      'autoclose' => true,
      'format' => 'yyyy-m-d H:i:s'
    ]
  ]);
  ?>

  <?php

  echo '<label class="control-label">fecha fin publicacion</label>';
  echo DateTimePicker::widget([
    'model' => $model,
    'attribute' => 'fechaFinPublicacion',
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
      'autoclose' => true,
      'format' => 'yyyy-m-d H:i:s'
    ]
  ]);
  ?>

  <br>

  <?= $form->field($model, 'idInformacionContacto')->dropDownList(
  $model->listaPlantillas,
  [
    'prompt'=>'Seleccione la plantilla',
    'onchange'=>'
    getPlantilla($(this).val());
    '
  ]
); ?>

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
  $this->registerJs("
  getPlantilla($('#ofertaslaborales-idinformacioncontacto').val());
  ");
  endif
  ?>
