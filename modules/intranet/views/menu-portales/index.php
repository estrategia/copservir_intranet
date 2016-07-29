<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\intranet\models\MenuPortales;

$this->title = 'Menu Portales';
$this->params['breadcrumbs'][] = ['label' => 'Menú portales'];
?>
<div class="menu-portales-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crea un item de menu para un portal', ['crear'], ['class' => 'btn btn-success']) ?>
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
                if ($model->estado == MenuPortales::APROBADO ) {
                  return 'Activo';
                }else{
                  return 'Inactivo';
                }
              }
            ],
            [
              'attribute' => 'idPortal',
              'filter' =>
                Html::activeDropDownList($searchModel, 'idPortal', MenuPortales::getListaPortales(),
                  ['class'=>'form-control','prompt' => 'Seleccione']),
              'value' => function($model) {
                return $model->objPortal->nombrePortal;
              }
            ],
            [
              'attribute' => 'tipo',
              'filter' =>
                Html::activeDropDownList($searchModel, 'tipo', ['1' => 'Enlace interno', '2' => 'Enlace externo'],
                  ['class'=>'form-control','prompt' => 'Seleccione']),
              'value' => function($model) {
                if ($model->tipo == MenuPortales::ENLACE_INTERNO) {
                  return 'Enlace interno';
                }else{
                  return 'Enlace externo';
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
