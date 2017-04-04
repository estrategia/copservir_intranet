<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\ModuloContenidoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Módulo de Interés';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modulo-contenido-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Módulo de Interés', ['crear'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idModulo',
            'nombreModulo',
            'descripcionModulo',
            'estadoModulo',
            'fechaCreacion',
            [
                'attribute' => '',
                'format' => 'raw',
                'value' => function ($model) {                      
                    return '<a class="btn btn-default" href="'. Url::to(['detalle', 'id' => $model->idModulo]) .'">Detalle</a>';
                },
            ],
            [
                'attribute' => '',
                'format' => 'raw',
                'value' => function ($model) {                      
                    return '<a class="btn btn-default" href="'. Url::to(['actualizar', 'id' => $model->idModulo]) .'">Actualizar</a>';
                },
            ],
        ],
    ]); ?>
</div>
