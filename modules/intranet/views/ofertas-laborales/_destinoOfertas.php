<?php
use yii\grid\GridView;
use yii\helpers\Html;

?>
<div id="listaOfertas">

  <?=  GridView::widget([
    'dataProvider' => $destinoOfertasLaborales,
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],
      [
        'attribute' => 'idGrupoInteres',
        'value' => function($model) {
          return $model->objGrupoInteres->nombreGrupo;
        }
      ],
      [
        'attribute' => 'codigoCiudad',
        'value' => function($model) {
          return $model->objCiudad->nombreCiudad;
        }
      ],
      [
        'class' => 'yii\grid\ActionColumn',
        'headerOptions'=> ['style'=>'width: 70px;'],
        'template' => '{eliminar-destino}',
        'buttons' => [
          'eliminar-destino' => function ($url, $destinoOfertasLaborales) {
            return  Html::a('<span class="glyphicon glyphicon-trash"></span>',
            ['#'],
            [
              'class' => 'btn btn-danger',
              'data-grupo' => $destinoOfertasLaborales->idGrupoInteres,
              'data-ciudad' => $destinoOfertasLaborales->codigoCiudad,
              'data-oferta' => $destinoOfertasLaborales->idOfertaLaboral,
              'data-role' => 'eliminarDestino'
            ]
          );
        }
      ],
    ],
  ],
]); ?>

</div>
