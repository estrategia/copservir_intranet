<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\intranet\models\ModuloContenido;
use yii\widgets\Pjax;

?>
<div class="menu-portales-index">
    <?php Pjax::begin(['timeout' => 10000, 'clientOptions' => ['container' => 'pjax-container']]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProviderModuloContenido,
        'filterModel' => $searchModel,
        'pager' => [
          'maxButtonCount' => Yii::$app->params['limiteBotonesPaginador'],    // Set maximum number of page buttons that can be displayed
        ],
        'layout' => "{summary}\n{items}\n<center>{pager}</center>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'titulo',
            'descripcion',
            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=> ['style'=>'width: 70px;'],
              'template' => '{visualizar}',
              'buttons' => [
                'visualizar' => function ($url, $model) {
                  return  Html::a('visualizar', $url, ['class' => 'btn btn-danger']);
                },
              ],
            ],
            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=> ['style'=>'width: 70px;'],
              'template' => '{selecciona}',
              'buttons' => [
                'selecciona' => function ($url, $model) use ($modelo){
                  if ($model->idModulo == $modelo->urlMenu) {
                    return  Html::a('asignado', '#', ['class' => 'btn btn-danger btn-select btn-'.$model->idModulo.'',
                    //'data-role'=>'asignar-contenido',
                    //'data-modulo-contenido'=>$model->idModulo
                  ]);
                  }else{
                    return  Html::a('seleccionar', '#', ['class' => 'btn btn-danger btn-select btn-'.$model->idModulo.'',
                    'data-role'=>'asignar-contenido',
                    'data-modulo-contenido'=>$model->idModulo]);
                  }

                }
              ],
            ]
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
