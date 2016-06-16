<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use \app\modules\intranet\models\Contenido;

/* @var $this yii\web\View */

$this->title = 'Aprobar contenido';
?>

<div class="col-md-12">

  <h1><?= Html::encode($this->title) ?></h1>

  <!-- si el contido se encuentra pendiente de aprobacion -->
  <?php if ($model->estado == Contenido::PENDIENTE_APROBACION): ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'estado')->hiddenInput(['value'=> Contenido::APROBADO ])->label(false); ?>
    <?= $form->field($model, 'fechaActualizacion')->hiddenInput(['value'=>  Date("Y-m-d H:i:s")])->label(false); ?>
    <?= $form->field($model, 'fechaInicioPublicacion')->hiddenInput(['value'=>  Date("Y-m-d H:i:s")])->label(false); ?>
    <?= $form->field($model, 'fechaAprobacion')->hiddenInput(['value'=>  Date("Y-m-d H:i:s")])->label(false); ?>
    <?= $form->field($model, 'numeroDocumentoAprobacion')->hiddenInput(['value'=>  Yii::$app->user->identity->numeroDocumento])->label(false); ?>
    <div class="form-group col-md-2">
      <?= Html::submitButton('Aprobar contenido', ['class' => 'btn btn-success' ]) ?>
    </div>
    <?php ActiveForm::end(); ?>

    <?= Html::a('Eliminar contenido', ['eliminar-contenido', 'id' => $model->idContenido], [
      'class' => 'btn btn-danger',
      'data' => [
        'confirm' => 'Estas seguro de eliminar este contenido?',
        'method' => 'post',
      ],
      ]) ?>

    <?php endif; ?>

    <?= DetailView::widget([
      'model' => $model,
      'attributes' => [
        'titulo',
        [

          'attribute' =>'contenido',
          'format'=>'raw',
          'value'=>$model->contenido,

        ],
        [
          'label' => 'Linea de tiempo',
          'value'=>$model->objLineaTiempo->nombreLineaTiempo,
        ],
        'fechaPublicacion',
        [
          'label' => 'Publicado por:',
          'format'=>'raw',
          'value' => '<img src="'.Yii::getAlias('@web').'/img/fotosperfil/'. $model->objUsuarioPublicacion->imagenPerfil.'" class="img-circle img-responsive" style="width: 22%;"/><p>'.$model->objUsuarioPublicacion->alias.' </p> '
        ],

      ],
      ]) ?>
    </div>
