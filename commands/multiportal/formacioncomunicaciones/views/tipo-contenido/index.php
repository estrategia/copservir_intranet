<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\TipoContenidoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipos de Contenidos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-contenido-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Tipo Contenido', ['crear'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idTipoContenido',
            'nombreTipoContenido',
            'estadoTipoContenido',
            'fechaCreacion',
            'fechaActualizacion',
            [
                'attribute' => '',
                'format' => 'raw',
                'value' => function ($model) {                      
                    return '<a class="btn btn-default" href="'. Url::to(['detalle', 'id' => $model->idTipoContenido]) .'">Detalle</a>';
                },
            ],
            [
                'attribute' => '',
                'format' => 'raw',
                'value' => function ($model) {                      
                    return '<a class="btn btn-default" href="'. Url::to(['actualizar', 'id' => $model->idTipoContenido]) .'">Actualizar</a>';
                },
            ],
        ],
    ]); ?>
</div>
