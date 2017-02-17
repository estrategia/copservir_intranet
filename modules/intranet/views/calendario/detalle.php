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
    <?php 
      $portales = implode(", ",
        array_map(
          function ($portal) { 
            return $portal->nombrePortal; 
          }, 
          $model->eventosPortalesDestino
        )
      );
    ?>
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
            'attribute' => 'numeroDocumento',
            'label' => 'creado por',
            'value' =>  $model->objUsuario->alias
          ],
          [
            'attribute' => 'estado',
            'value' =>  $model->estado == EventosCalendario::ACTIVO ? 'Activo' : 'Inactivo',
          ],
          [
            'attribute' => 'portales',
            'value' => $portales,
          ]
        ],
    ]) ?>

</div>
