<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use \app\modules\intranet\models\Contenido;
use \app\modules\intranet\models\DenunciosContenidos;

/* @var $this yii\web\View */

$this->title = 'Contenido denunciado';
?>

<div class="col-md-12">

  <h1><?= Html::encode($this->title) ?></h1>

  <!-- si el conteniido se encuentra pendiente de aprobacion -->
  <?php if ($model->objDenunciosContenidos->estado == DenunciosContenidos::PENDIENTE_APROBACION): ?>
    <?php $form = ActiveForm::begin(); ?>
      <?= $form->field($model->objDenunciosContenidos, 'estado')->hiddenInput(['value'=> DenunciosContenidos::APROBADO ])->label(false); ?>
      <?= $form->field($model->objDenunciosContenidos, 'fechaActualizacion')->hiddenInput(['value'=>  Date("Y-m-d H:i:s")])->label(false); ?>
      <div class="form-group col-md-2">
          <?= Html::submitButton('mantener contenido', ['class' => 'btn btn-success' ]) ?>
      </div>
    <?php ActiveForm::end(); ?>

    <?= Html::a('Eliminar contenido', ['eliminar-contenido-denunciado', 'id' => $model->objDenunciosContenidos->idDenuncioContenido], [
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
          [
            'label' => 'Denunciado por:',
            'format'=>'raw',
            'value' => '<img src="'.Yii::getAlias('@web').'/img/fotosperfil/'. $model->objDenunciosContenidos->objUsuario->imagenPerfil.'" class="img-circle img-responsive" style="width: 22%;"/><p>'.$model->objUsuarioPublicacion->alias.' </p> '
          ],
          [
            'label' => 'Motivo:',
            'format'=>'raw',
            'value' => $model->objDenunciosContenidos->descripcionDenuncio
          ],

      ],
  ]) ?>
</div>
