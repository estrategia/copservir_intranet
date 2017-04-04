<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\CapituloContenidoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Capítulo de Interés';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="capitulo-contenido-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Capítulo de Interés', ['crear'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idCapitulo',
            'nombreCapitulo',
            'descripcionCapitulo',
            'estadoCapitulo',
            'fechaCreacion',
            [
                'attribute' => '',
                'format' => 'raw',
                'value' => function ($model) {                      
                    return '<a class="btn btn-default" href="'. Url::to(['detalle', 'id' => $model->idCapitulo]) .'">Detalle</a>';
                },
            ],
            [
                'attribute' => '',
                'format' => 'raw',
                'value' => function ($model) {                      
                    return '<a class="btn btn-default" href="'. Url::to(['actualizar', 'id' => $model->idCapitulo]) .'">Actualizar</a>';
                },
            ],
            
        ],
    ]); ?>
</div>
