<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\intranet\models\ContenidoEmergente;

$this->title = 'Ver contenido emergente';
$this->params['breadcrumbs'][] = ['label' => 'Contenidos emergentes', 'url'=>['/intranet/contenido-emergente/admin']];
$this->params['breadcrumbs'][] = ['label' => "Ver #$model->idContenidoEmergente"];
?>
<div class="contenido-emergente-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idContenidoEmergente], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Resetear vistos', ['resetear-vistos', 'id' => $model->idContenidoEmergente], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Inactivar', ['eliminar', 'id' => $model->idContenidoEmergente], [
      'class' => 'btn btn-danger',
      'data' => [
        'confirm' => 'Estas seguro de eliminar este contenido emergente?',
        'method' => 'post',
      ],
      ]) ?>
    </p>

    <?= DetailView::widget([
      'model' => $model,
      'attributes' => [
        'contenido:ntext',
        'fechaInicio',
        'fechaFin',
        [
          'label' => 'Estado',
          'value' =>  $model->estado == ContenidoEmergente::ESTADO_ACTIVO ? 'Activo' : 'Inactivo',
        ],
      ],
      ]) ?>

    </div>
