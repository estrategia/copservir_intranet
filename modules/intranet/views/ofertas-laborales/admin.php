<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Ofertas Laborales';
?>
<div class="ofertas-laborales-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crea una oferta laboral', ['crear'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tituloOferta',
            [
              'attribute' => 'idCiudad',
              'value' => 'objCiudad.nombreCiudad',
            ],
            [
              'attribute' => 'idCargo',
              'value' => 'objCargo.nombreCargo',
            ],
            [
              'attribute' => 'idArea',
              'value' => 'objArea.nombreArea',
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
