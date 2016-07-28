<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\intranet\models\PrioridadTarea;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\intranet\models\PrioridadTareaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Prioridad Tareas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prioridad-tarea-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crea una prioridad para una tarea', ['crear'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',
            [
              'attribute' => 'estado',
              'filter' =>
                Html::activeDropDownList($searchModel, 'estado', ['0' => 'Inactivo', '1' => 'Activo'],
                  ['class'=>'form-control','prompt' => 'Seleccione']),
              'value' => function($model) {
                if ($model->estado == PrioridadTarea::ESTADO_ACTIVO ) {
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
