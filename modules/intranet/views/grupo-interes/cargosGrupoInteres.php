<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;

?>
<div id="listaCargos">

  <h4>Cargos asociados al grupo de interes</h4>
  <p>
    agrega un cargo a este grupo
  </p>
  <?php //Html::beginForm(['grupo-interes/agregar-cargo'], 'post', ['id'=> 'formEnviaCargos']); ?>
  <?php $form = ActiveForm::begin(['options' => ['id'=> 'formEnviaCargos']]); ?>
  <div class="col-md-6">
  <?php
      $url = \yii\helpers\Url::to(['lista-cargos']);
      $initScript = <<< SCRIPT
function (element, callback) {
   var id=$(element).val();
   if (id !== "") {
       $.ajax("{$url}?id=" + id, {
           dataType: "json"
       }).done(function(data) { callback(data.results);});
   }
}
SCRIPT;

    echo  $form->field($modelGrupoInteresCargo, 'idCargo')->widget(Select2::classname(), [
            //'name' => 'agregaCargos',
            'showToggleAll' => false,
            'options' => ['placeholder' => 'buscar cargos...','id'=>'agregaCargos'],
            'pluginOptions' => [
              'allowClear' => false,
              'ajax' => [
                    'url' => $url,
                    'dataType' => 'json',
                    'tags' => true,
                    'data' => new JsExpression('function(params) { return {search:params.term, page: params.page}; }'),
                    'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
              ],
              'initSelection' => new JsExpression($initScript),
              'initValueText'=>'buscar'
            ],

      ])

  ?>

  <?= $form->field($modelGrupoInteresCargo, 'idGrupoInteres')->hiddenInput(['value'=> $grupo->idGrupoInteres])->label(false); ?>

  <?php ActiveForm::end(); ?>
  </div>
  <div class="col-md-6">
    <?= Html::a('Agregar cargo', ['#'],
                    [
                      'class' => 'btn btn-primary',
                      'data-grupo' => $grupo->idGrupoInteres,
                      'data-role' => 'agregar-cargo'
                    ])
    ?>
  </div>

  <br>
  <div class="col-md-12">


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
</div>
