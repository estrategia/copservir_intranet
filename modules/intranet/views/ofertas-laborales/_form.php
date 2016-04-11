<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;
use app\modules\intranet\models\ContenidoDestino;
use app\modules\intranet\models\GrupoInteres;
use app\modules\intranet\models\Ciudad;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\OfertasLaborales */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ofertas-laborales-form">

    <?php $form = ActiveForm::begin(); ?>


    <?php //$form->field($model, 'idOfertaLaboral')->hiddenInput(['value'=> Yii::$app->user->identity->numeroDocumento])->label(false); ?>

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
          'format' => 'yyyy/mm/dd hh:ii:ss'
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
          'format' => 'yyyy/mm/dd hh:ii:ss'
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
          'format' => 'yyyy/mm/dd hh:ii:ss'
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
          'format' => 'yyyy/mm/dd hh:ii:ss'
      	]
      ]);

    ?>

    <?php /*$form->field($model, 'idCargo')->dropDownList($model->listaCargo, ['prompt' => 'Seleccione el cargo' ]);*/?>

    <?= $form->field($model, 'idInformacionContacto')->hiddenInput(['value'=> 1])->label(false); ?>

    <!-- grupos inters y ciudad -->


    <!-- si crea una oferta muestra el formulario para añadir los destinos -->
    <?php if ($model->isNewRecord): ?>

        <h4>Grupos de interes y ciudad de destino</h4>
        <div id="contenido-destino">
            <?php echo $this->render('/contenido/_formDestinoContenido', ['objContenidoDestino' => new ContenidoDestino]) ?>
        </div>


        <?=
        Html::a('<i class = "fa fa-plus-square" ></i>', '#', [
            'data-role' => 'agregar-destino-contenido',
            'title' => 'Agregar nuevo'
        ]);
        ?>

        <?= Html::label('Añadir otro') ?>
      <?php endif ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div class="col-md-12">
  <hr>

</div>
<div class="col-md-12">
  <?php if (!$model->isNewRecord): ?>
  <h4>Grupos de interes y ciudad de destino</h4>

  <?= Html::beginForm(['ofertas-laborales/agregar-destino-oferta'], 'post', ['id'=> 'formEnviaDestinosOferta']); ?>

  <div class="col-md-4">
      <?php echo Html::label('Grupo de Interés') ?>
      <?php
      echo Select2::widget([
          'name' => 'grupo',
          'id' => "Grupo_",
          'data' => ArrayHelper::map(GrupoInteres::find()->orderBy('nombreGrupo')->all(), 'idGrupoInteres', 'nombreGrupo'),
          'options' => ['placeholder' => 'Selecione ...'],
          'pluginOptions' => [
              'allowClear' => true
          ],
      ]);
      ?>
  </div>
  <div class="col-md-4">
      <?php echo Html::label('Ciudad') ?>
      <?php
      echo
      Select2::widget([
          'name' => 'ciudad',
          'id' => "ciudad_",
          'data' => ArrayHelper::map(Ciudad::find()->orderBy('nombreCiudad')->all(), 'codigoCiudad', 'nombreCiudad'),
          'options' => ['placeholder' => 'Selecione ...'],
          'pluginOptions' => [
              'allowClear' => true
          ],
      ]);
      ?>
  </div>
  <?=  Html::hiddenInput('ofertaLaboral', $model->idOfertaLaboral, []);  ?>
  <?= Html::endForm() ?>
  <div class="col-md-4">

    <?= Html::a('Agregar', ['#'],
                    [
                      'class' => 'btn btn-primary ',
                      //'data-oferta' => $model->idOfertaLaboral,
                      'data-role' => 'agregar-destino-oferta'
                    ])
    ?>

  </div>

      <div class="col-md-12">
        <br><br>
          <div id="destinosOfertas">
              <?= $this->render('_destinoOfertas', ['destinoOfertasLaborales' => $destinoOfertasLaborales]) ?>
          </div>

      </div>
  <?php endif ?>

</div>
