<?php
use yii\grid\GridView;
use yii\helpers\Html;

?>
<div id="listaCargos">
aca viene la lista de los destino

<?php  GridView::widget([
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
        'class' => 'yii\grid\ActionColumn',
        'headerOptions'=> ['style'=>'width: 70px;'],
        'template' => '{eliminar-destino-oferta}',
        'buttons' => [
            'eliminar-cargo' => function ($url, $destinoOfertasLaborales) {
                return  Html::a('<span class="glyphicon glyphicon-trash"></span>',
                ['#'],
                [
                  'class' => 'btn btn-danger',
                  'data-grupo' => $destinoOfertasLaborales->idGrupoInteres,
                  'data-ciudad' => $destinoOfertasLaborales->codigoCiudad,
                  'data-role' => 'eliminarDestinoOferta'
                ]
              );
            }
        ],
    ],
    ],
]); ?>

</div>
