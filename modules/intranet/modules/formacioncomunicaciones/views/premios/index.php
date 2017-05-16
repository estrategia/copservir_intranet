<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\modules\formacioncomunicaciones\models\CategoriasPremiosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Premios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="premios-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Premio', ['crear'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'idPremio',
            'nombrePremio',
        	'descripcionPremio',
            'puntosRedimir',
            'cantidad',
            [
            	'attribute' => 'estado',
            	'value' => function($model){return ($model->estado == 1)?'Activo':'Inactivo';}
            ],
            [
            'attribute' => 'Categoria',
            'value' => function($model){return $model->objCategoria->nombreCategoria;}
            ],
        	'fechaInicioVigencia',
        	'fechaFinVigencia',
		
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
              ],
            ],
        ],
    ]); ?>
</div>
