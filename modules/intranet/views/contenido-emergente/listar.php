<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\intranet\models\ContenidoEmergente;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\models\ContenidoEmergenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contenido Emergente';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contenido-emergente-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crea un contenido emergente', ['crear'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'contenido:ntext',
            'fechaInicio',
            'fechaFin',
            [
  		        'attribute' => 'estado',
  		        'value' => function($model) {
                if ($model->estado == ContenidoEmergente::ESTADO_ACTIVO ) {
                  return 'Activo';
                }else{
                  return 'Inactivo';
                }
  			         }
			       ],
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
                  'eliminar' => function ($url, $model) {
                      return  Html::a('<span class="glyphicon glyphicon-trash"></span>', $url);
                  }
              ],
            ],

        ],
    ]); ?>
</div>
