<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Ofertas Laborales';
?>
<div class="ofertas-laborales-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(['timeout' => 10000, 'clientOptions' => ['container' => 'pjax-container']]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tituloOferta',
            'descripcionContactoOferta:ntext',
            'urlElEmpleo:url',
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
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
