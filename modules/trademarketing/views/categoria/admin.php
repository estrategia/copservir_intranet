<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\trademarketing\models\Categoria;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\trademarketing\models\CategoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider de Categorias*/

$this->title = 'Categorias';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'TradeMarketing-Categorías')];?>
<div class="">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/common/errores', []) ?>

    <p>
        <?= Html::a('Crea una Categoria', ['crear'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',
            'descripcion',
            [
              'attribute' => 'estado',
              'filter' =>
                Html::activeDropDownList($searchModel, 'estado', [ Categoria::ESTADO_INACTIVO => 'Inactivo',
                  Categoria::ESTADO_ACTIVO => 'Activo'], ['class'=>'form-control','prompt' => 'Seleccione']),
                'value' => function($model) {
                  if ($model->estado == Categoria::ESTADO_ACTIVO ) {
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
                          'confirm' => 'Estas seguro de inactivar esta categoria?',
                          'method' => 'post',
                      ],
                  ]);
                }
              ],
            ],
        ],
    ]); ?>

</div>
