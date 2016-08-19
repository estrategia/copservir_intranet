<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\intranet\models\EventosCalendario;

$this->title = "Detalle evento";

?>
<div class="evento-calendario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idEventoCalendario], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Inactivar', ['eliminar', 'id' => $model->idEventoCalendario], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de eliminar este evento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          'tituloEvento',
          'url:url',
          'fechaInicioEvento',
          'fechaFinEvento',
          'horaInicioEvento',
          'fechaInicioVisible',
          [
            'attribute' => 'idPortal',
            'value' =>  $model->objPortal->nombrePortal
          ],
          [
            'attribute' => 'idContenido',
            'value' =>  $model->objContenido ? $model->objContenido->titulo : 'No se ha asignado',
          ],
          [
            'attribute' => 'numeroDocumento',
            'label' => 'creado por',
            'value' =>  $model->objUsuario->alias
          ],
          [
            'attribute' => 'estado',
            'value' =>  $model->estado == EventosCalendario::ACTIVO ? 'Activo' : 'Inactivo',
          ],
        ],
    ]) ?>

</div>
