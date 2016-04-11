<?php
use yii\grid\GridView;
use yii\helpers\Html;
?>
<div id="listaCargos">

<?= GridView::widget([
    'dataProvider' => $grupoInteresCargo,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
          'attribute' => 'idCargo',
          'value' => function($model) {
            return $model->objGrupoInteresCargo->nombreCargo;
          }
        ],
        [
        'class' => 'yii\grid\ActionColumn',
        'headerOptions'=> ['style'=>'width: 70px;'],
        'template' => '{eliminar-cargo}',
        'buttons' => [
            'eliminar-cargo' => function ($url, $grupoInteresCargo) {
                return  Html::a('<span class="glyphicon glyphicon-trash"></span>',
                ['#'],
                [
                  'class' => 'btn btn-danger',
                  'data-grupo' => $grupoInteresCargo->idGrupoInteres,
                  'data-cargo' => $grupoInteresCargo->idCargo,
                  'data-role' => 'eliminarCargoGrupo'
                ]
              );
            }
        ],
    ],
    ],
]); ?>

</div>
