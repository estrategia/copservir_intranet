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
  <?php $form = ActiveForm::begin(['options' => ['id'=> 'formEnviaCargos']]); ?>
  <div class="col-md-6">
  <?php

    echo  $form->field($modelGrupoInteresCargo, 'idCargo')->widget(Select2::classname(), [
            'data' => $modelGrupoInteresCargo->listaCargo,
            'options' => ['placeholder' => 'buscar cargos...','id'=>'agregaCargos'
            ],
            'pluginEvents' => [
                                "select2:selecting" => "function(e) { $('#grupointerescargo-nombrecargo').val(e.params.args.data.text); }",
                              ],
      ])
  ?>

  <?= $form->field($modelGrupoInteresCargo, 'idGrupoInteres')->hiddenInput(['value'=> $grupo->idGrupoInteres])->label(false); ?>

  <?= $form->field($modelGrupoInteresCargo, 'nombreCargo')->hiddenInput(['value'=> ''])->label(false); ?>

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
      'nombreCargo',
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
