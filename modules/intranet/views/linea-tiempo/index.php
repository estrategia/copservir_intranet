<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\intranet\models\LineaTiempo;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\models\LineaTiempoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lineas de Tiempo';
$this->params['breadcrumbs'][] = ['label' => 'Líneas de tiempo'];
?>
<div class="linea-tiempo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crea una linea de tiempo', ['crear'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombreLineaTiempo',
            [
              'attribute' => 'estado',
              'filter' =>
                Html::activeDropDownList($searchModel, 'estado', ['0' => 'Inactivo', '1' => 'Activo'],
                  ['class'=>'form-control','prompt' => 'Seleccione']),
              'value' => function($model) {
                if ($model->estado == LineaTiempo::ESTADO_ACTIVO ) {
                  return 'Activo';
                }else{
                  return 'Inactivo';
                }
              }
            ],
            [
              'attribute' => 'autorizacionAutomatica',
              'filter' =>
                Html::activeDropDownList($searchModel, 'autorizacionAutomatica', ['0' => 'No', '1' => 'Si'],
                  ['class'=>'form-control','prompt' => 'Seleccione']),
              'value' => function($model) {
                if ($model->autorizacionAutomatica == LineaTiempo::AUTORIZACION_AUTOMATICA ) {
                  return 'Si';
                }else{
                  return 'No';
                }
              }
            ],
            [
              'attribute' => 'tipo',
              'filter' =>
                Html::activeDropDownList($searchModel, 'tipo', ['0' => 'Publicacion', '1' => 'Clasificado', '2' => 'Aniversario'],
                  ['class'=>'form-control','prompt' => 'Seleccione']),
              'value' => function($model) {
                if ($model->tipo == LineaTiempo::TIPO_PUBLICACION ) {
                  return 'Publicación';
                }
                if ($model->tipo == LineaTiempo::TIPO_CLASIFICADO ) {
                  return 'Clasificado';
                }
                if ($model->tipo == LineaTiempo::TIPO_ANIVERSARIO ) {
                  return 'Aniversario';
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
