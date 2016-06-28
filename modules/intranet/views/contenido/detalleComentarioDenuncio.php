<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use \app\modules\intranet\models\DenunciosContenidosComentarios;

/* @var $this yii\web\View */

$this->title = 'Comentario denunciado';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comentarios denunciados'), 'url' =>['/intranet/contenido/listar-comentarios-denunciados']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', "Comentario #" . $model->objDenuncioComentario->idContenidoComentario)];
?>

<div class="col-md-12">

  <h1><?= Html::encode($this->title) ?></h1>

  <!-- si el conteniido se encuentra pendiente de aprobacion -->
  <?php if ($model->objDenuncioComentario->estado == DenunciosContenidosComentarios::PENDIENTE_APROBACION): ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model->objDenuncioComentario, 'estado')->hiddenInput(['value'=> DenunciosContenidosComentarios::APROBADO ])->label(false); ?>
    <?= $form->field($model->objDenuncioComentario, 'fechaActualizacion')->hiddenInput(['value'=>  Date("Y-m-d H:i:s")])->label(false); ?>
    <div class="form-group col-md-2">
      <?= Html::submitButton('mantener comentario', ['class' => 'btn btn-success' ]) ?>
    </div>
    <?php ActiveForm::end(); ?>

    <?= Html::a('Eliminar comentario', ['eliminar-comentario-denunciado', 'id' => $model->objDenuncioComentario->idDenuncioComentario], [
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
        [
          'label' => 'Noticia del comentario',
          'format'=>'raw',
          'value' => $model->objContenido->titulo
        ],
        [
          'label' => 'Contenido del comentario',
          'format'=>'raw',
          'value' => $model->contenido
        ],
        [
          'label' => 'Publicado por:',
          'format'=>'raw',
          'value' => '<img src="'.Yii::getAlias('@web').'/img/fotosperfil/'. $model->objUsuarioPublicacionComentario->imagenPerfil.'" class="img-circle img-responsive" style="width: 22%;"/><p>'.$model->objUsuarioPublicacionComentario->alias.' </p> '
        ],
        [
          'label' => 'Denunciado por:',
          'format'=>'raw',
          'value' => '<img src="'.Yii::getAlias('@web').'/img/fotosperfil/'. $model->objDenuncioComentario->objUsuario->imagenPerfil.'" class="img-circle img-responsive" style="width: 22%;"/><p>'.$model->objDenuncioComentario->objUsuario->alias.' </p> '
        ],
        [
          'label' => 'Motivo:',
          'format'=>'raw',
          'value' => $model->objDenuncioComentario->descripcionDenuncio
        ],

      ],
      ]) ?>
    </div>
