<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\JsExpression;
use kartik\select2\Select2;

?>
<div id="listaCargos">

<h4>Cargos asociados al grupo de interes</h4>
<p>
  agrega un cargo a este grupo
</p>
<?= Html::beginForm(['grupo-interes/agregar-cargo'], 'post', ['id'=> 'formEnviaCargos']); ?>
<?php

    echo Select2::widget([
          'name' => 'agregaCargos',
          'data' => \yii\helpers\ArrayHelper::map($listaCargos, 'idCargo', 'nombreCargo'),
          'size' => Select2::MEDIUM,
          'showToggleAll' => false,
          'changeOnReset' => false,
          'options' => ['class'=>'select2-container','placeholder' => 'buscar cargos...'],
          'pluginOptions' => [
            'allowClear' => true,
            'escapeMarkup' => new JsExpression("function(m) { return m; }")
          ],

    ])

?>

<?=  Html::hiddenInput('grupoInteres', $idGrupo, []);  ?>
<?= Html::endForm()     ?>
<br>

<?= Html::a('Agregar cargo', ['#'],
                [
                  'class' => 'btn btn-primary',
                  'data-grupo' => $idGrupo,
                  'data-role' => 'agregar-cargo'
                ])
?>
<br>
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
