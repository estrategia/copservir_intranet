<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\intranet\models\EventosCalendario;

$this->title = 'Eventos Calendario';
?>
<div class="eventos-calendario-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crea un evento en el caledario', ['crear'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tituloEvento',
            'fechaInicioEvento',
            'fechaFinEvento',
            'fechaInicioVisible',
            [
              'attribute' => 'estado',
              'value' => function($model) {
                if ($model->estado == EventosCalendario::ACTIVO ) {
                  return 'Activo';
                }else{
                  return 'Inactivo';
                }
              }
            ],
            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=> ['style'=>'width: 70px;'],
              'template' => '{detalle} {actualizar} {eliminar}',
              'buttons' => [
                'detalle' => function ($url, $model) {
                  return  Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                },
                'actualizar' => function ($url, $model) {
                  return  Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                },
                'eliminar' => function ($url, $model) {
                  return  Html::a('<span class="glyphicon glyphicon-trash"></span>', $url);
                }
              ],
            ],
        ],
    ]); ?>
</div>
