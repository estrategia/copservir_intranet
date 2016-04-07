<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\jui\DatePicker;
use app\modules\intranet\models\ContenidoDestino;
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
     echo $form->field($model, 'fechaPublicacion')->widget(DatePicker::className(),[
        'dateFormat' => 'yyyy-MM-dd hh:mm:ss',
        'options' => [
        'class' => 'input-sm form-control',
        'placeholder' => 'yyyy-MM-dd hh:mm:ss'
        ]
      ]);
    ?>


    <?php
     echo $form->field($model, 'fechaCierre')->widget(DatePicker::className(),[
        'dateFormat' => 'yyyy-MM-dd hh:mm:ss',
        'options' => [
        'class' => 'input-sm form-control',
        'placeholder' => 'yyyy-MM-dd hh:mm:ss'
        ]
      ]);
    ?>

    <?= $form->field($model, 'numeroDocumento')->hiddenInput(['value'=> Yii::$app->user->identity->numeroDocumento])->label(false); ?>


    <?php
     echo $form->field($model, 'fechaInicioPublicacion')->widget(DatePicker::className(),[
        'dateFormat' => 'yyyy-MM-dd hh:mm:ss',
        'options' => [
        'class' => 'input-sm form-control',
        'placeholder' => 'yyyy-MM-dd hh:mm:ss'
        ]
      ]);
    ?>


    <?php
     echo $form->field($model, 'fechaFinPublicacion')->widget(DatePicker::className(),[
        'dateFormat' => 'yyyy-MM-dd hh:mm:ss',
        'options' => [
        'class' => 'input-sm form-control',
        'placeholder' => 'yyyy-MM-dd hh:mm:ss'
        ]
      ]);
    ?>

    <?php /*$form->field($model, 'idCargo')->dropDownList($model->listaCargo, ['prompt' => 'Seleccione el cargo' ]);*/?>

    <?= $form->field($model, 'idInformacionContacto')->hiddenInput(['value'=> 1])->label(false); ?>

    <!-- grupos inters y ciudad -->
    <h4>Grupos de interes y ciudad de destino</h4>

    <!-- si crea una oferta muestra el formulario para añadir los destinos -->
    <?php if ($model->isNewRecord): ?>
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
  <h4></h4>
  <?php if (!$model->isNewRecord): ?>
      <?= $this->render('_destinoOfertas', ['destinoOfertasLaborales' => $destinoOfertasLaborales]) ?>
  <?php endif ?>

</div>
