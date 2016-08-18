<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use yii\widgets\Pjax;
/*
$columnas = [];

if ($modelo->objPortal->nombrePortal == 'intranet') {
  $columnas = [
    ['class' => 'yii\grid\SerialColumn'],
    'titulo',
    [
      'attribute' => 'idLineaTiempo',
      'value' => 'objLineaTiempo.nombreLineaTiempo',
    ],
    [
      'class' => 'yii\grid\ActionColumn',
      'headerOptions'=> ['style'=>'width: 70px;'],
      'template' => '{asignar-contenido-evento}',
      'buttons' => [
        'asignar-contenido-evento' => function ($url, $model) use  ($modelo)  {

          if ($model->idContenido == $modelo->idContenido) {

            return  Html::button('Asignado', ['class' => 'btn btn-danger',
            'disabled' => 'disabled'
            ]);

          }else{
            return  Html::a('Seleccionar', $url.'&idEvento='.$modelo->idEventoCalendario, ['class' => 'btn btn-danger',
            'data-role'=>'asignar-contenido-evento-calendario',
            'data-contenido'=>$model->idContenido,
          ]);
          }
        }
      ],
    ]
  ];
}else{
  $columnas = [
    ['class' => 'yii\grid\SerialColumn'],
    'titulo',
    [
      'class' => 'yii\grid\ActionColumn',
      'headerOptions'=> ['style'=>'width: 70px;'],
      'template' => '{asignar-contenido-evento}',
      'buttons' => [
        'asignar-contenido-evento' => function ($url, $model) use  ($modelo)  {

          if ($model->idContenido == $modelo->idContenido) {

            return  Html::button('Asignado', ['class' => 'btn btn-danger',
            'disabled' => 'disabled'
            ]);

          }else{
            return  Html::a('Seleccionar', $url.'&idEvento='.$modelo->idEventoCalendario, ['class' => 'btn btn-danger',
            'data-role'=>'asignar-contenido-evento-calendario',
            'data-contenido'=>$model->idContenido,
          ]);
          }
        }
      ],
    ]
  ];
}
*/
?>
<!--
<div class="col-md-12" id="contenidos-lista">

  <br><br>
  <h4>Asigna un contenido a este evento </h4>
  <hr>
  <div>
    <?php

     //Pjax::begin(['timeout' => 10000, 'clientOptions' => ['container' => 'pjax-container']]); ?>
    <?php /* GridView::widget([
      'dataProvider' => $dataProviderContenido,
      'filterModel' => $searchModel,
      'columns' => $columnas,
  ]); */?>
  <?php //Pjax::end(); ?>
  </div>
</div>
