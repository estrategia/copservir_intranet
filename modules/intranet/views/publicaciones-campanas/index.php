<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\intranet\models\PublicacionesCampanas;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\models\PublicacionesCampanasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Campañas publicitarias';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publicaciones-campanas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear una campanas', ['crear'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombreImagen',
            [
              'label'=>'Imagen',
              'attribute' => 'rutaImagen',
              'format'=>'raw',
              'value' => function($model) {
                return '<img src="'.Yii::getAlias('@web').'/img/campanas/'. $model->rutaImagen.'" class="img-responsive"
                  style="width: 22%;"/>';
              }
            ],
            [
              'attribute' => 'estado',
              'filter' =>
                Html::activeDropDownList($searchModel, 'estado', ['0' => 'Inactivo', '1' => 'Activo'],
                  ['class'=>'form-control','prompt' => 'Seleccione']),
              'value' => function($model) {
                if ($model->estado == PublicacionesCampanas::ESTADO_ACTIVO ) {
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
