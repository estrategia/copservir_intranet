<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\models\PublicacionesCampanasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Publicaciones Campanas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publicaciones-campanas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Publicaciones Campanas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idImagenCampana',
            'nombreImagen',
            'rutaImagen',
            'numeroDocumento',
            'urlEnlaceNoticia:url',
            // 'fechaInicio',
            // 'estado',
            // 'posicion',
            // 'fechaFin',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
