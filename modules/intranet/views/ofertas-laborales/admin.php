<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\intranet\models\OfertasLaborales;

$this->title = 'Ofertas Laborales';
?>
<div class="ofertas-laborales-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crea una oferta laboral', ['crear'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tituloOferta',
            [
              'attribute' => 'idCiudad',
              'value' => 'objCiudad.nombreCiudad',
            ],
            [
              'attribute' => 'idCargo',
              'value' => 'objCargo.nombreCargo',
            ],
            [
              'attribute' => 'idArea',
              'value' => 'objArea.nombreArea',
            ],
            [
              'attribute' => 'estado',
              'filter' =>
                Html::activeDropDownList($searchModel, 'estado', ['0' => 'Inactivo', '1' => 'Activo'],
                  ['class'=>'form-control','prompt' => 'Seleccione']),
              'value' => function($model) {
                if ($model->estado == OfertasLaborales::ESTADO_ACTIVO ) {
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
