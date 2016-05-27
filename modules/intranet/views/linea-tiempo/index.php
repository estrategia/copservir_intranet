<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\models\LineaTiempoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Linea Tiempos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linea-tiempo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Linea Tiempo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idLineaTiempo',
            'nombreLineaTiempo',
            'estado',
            'autorizacionAutomatica',
            'tipo',
            // 'solicitarGrupoObjetivo',
            // 'orden',
            // 'fechaInicio',
            // 'fechaFin',
            // 'color',
            // 'icono',
            // 'descripcion',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
