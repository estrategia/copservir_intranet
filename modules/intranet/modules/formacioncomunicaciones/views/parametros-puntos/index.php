<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\ParametrosPuntosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parametros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parametros-puntos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Parametro', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'idParametroPunto',
            'tipoParametro',
            'valorPuntos',
            'idTipoContenido',
            'condicion',
            // 'estado',
            // 'fechaCreacion',
            // 'fechaActualizacion',
            // 'valorPuntosExtra',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
