<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\AreaContenidoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Áreas de Interés';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-contenido-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Área de Interés', ['crear'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idAreaConocimiento',
            'nombreArea',
            'descripcionArea',
            'estadoArea',
            'fechaCreacion',
            [
                'attribute' => '',
                'format' => 'raw',
                'value' => function ($model) {                      
                    return '<a class="btn btn-default" href="'. Url::to(['detalle', 'id' => $model->idAreaConocimiento]) .'">Detalle</a>';
                },
            ],
            [
                'attribute' => '',
                'format' => 'raw',
                'value' => function ($model) {                      
                    return '<a class="btn btn-default" href="'. Url::to(['actualizar', 'id' => $model->idAreaConocimiento]) .'">Actualizar</a>';
                },
            ],
        ],
    ]); ?>
</div>
