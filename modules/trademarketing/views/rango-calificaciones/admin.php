<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\trademarketing\models\RangoCalificaciones;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\trademarketing\models\RangoCalificacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rangos de calificaciones';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="space-1"></div>
<div class="space-2"></div>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/common/errores', []) ?>

    <p>
        <?= Html::a('Crea un rango de calificaciones', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',
            'valor',
            [
              'attribute' => 'estado',
              'filter' =>
                Html::activeDropDownList($searchModel, 'estado', [ RangoCalificaciones::ESTADO_INACTIVO => 'Inactivo',
                  RangoCalificaciones::ESTADO_ACTIVO => 'Activo'], ['class'=>'form-control','prompt' => 'Seleccione']),
                'value' => function($model) {
                  if ($model->estado == RangoCalificaciones::ESTADO_ACTIVO ) {
                    return 'Activo';
                  }else{
                    return 'Inactivo';
                }
              }
            ],

            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=> ['style'=>'width: 70px;'],
              'template' => '{detalle}',
              'buttons' => [
                'detalle' => function ($url, $model) {
                  return  Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                }
              ],
            ],
            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=> ['style'=>'width: 70px;'],
              'template' => '{actualizar}',
              'buttons' => [
                'actualizar' => function ($url, $model) {
                  return  Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                }
              ],
            ],
            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=> ['style'=>'width: 70px;'],
              'template' => '{inactivar}',
              'buttons' => [
                'inactivar' => function ($url, $model) {
                  return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                      'data' => [
                          'confirm' => 'Estas seguro de inactivar este rango de calificaciones?',
                          'method' => 'post',
                      ],
                  ]);
                }
              ],
            ],
        ],
    ]); ?>
</div>

<div class="space-1"></div>
<div class="space-2"></div>
