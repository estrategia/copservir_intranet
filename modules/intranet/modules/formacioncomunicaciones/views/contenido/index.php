<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\ContenidoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contenidos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contenido-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Contenido', ['crear'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idContenido',
            'contenido:ntext',
            'estadoContenido',
            'idAreaConocimiento',
            'idModulo',
            // 'idCapitulo',
            // 'idTipoContenido',
            // 'idContenidoCopia',
            // 'fechaInicio',
            // 'fechaFin',
            // 'frecuenciaMes',
            // 'fechaCreacion',
            // 'fechaActualizacion',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
