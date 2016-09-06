<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\trademarketing\models\VariableMedicion;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\trademarketing\models\VariableMedicionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider VariableMedicion */

$this->title = 'Variables de medicion';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="space-1"></div>
<div class="space-2"></div>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/common/errores', []) ?>

    <p>
        <?= Html::a('Crea una variable de medicion', ['crear'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
              'attribute' => 'idCategoria',
              'value' => 'categoria.nombre',
            ],
            'nombre',
            'descripcion',
            [
              'attribute' => 'estado',
              'filter' =>
                Html::activeDropDownList($searchModel, 'estado', [VariableMedicion::ESTADO_INACTIVO => 'Inactivo',
                  VariableMedicion::ESTADO_ACTIVO => 'Activo'], ['class'=>'form-control','prompt' => 'Seleccione']),
                  'value' => function($model) {
                      if ($model->estado == VariableMedicion::ESTADO_ACTIVO ) {
                        return 'Activo';
                      }else{
                        return 'Inactivo';
                      }
                    }
            ],
            //--
            [
              'attribute' => 'calificaUnidadNegocio',
              'filter' =>
                Html::activeDropDownList($searchModel, 'calificaUnidadNegocio', ['0' => 'No',
                  '1' => 'Si'], ['class'=>'form-control','prompt' => 'Seleccione']),
                  'value' => function($model) {
                      if ($model->calificaUnidadNegocio == VariableMedicion::CALIFICA_UNIDAD ) {
                        return 'Si';
                      }else{
                        return 'No';
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
                          'confirm' => 'Estas seguro de inactivar esta variable de medicion?',
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
