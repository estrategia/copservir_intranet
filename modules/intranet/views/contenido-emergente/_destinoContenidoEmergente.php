<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\intranet\models\GrupoInteres;
use app\modules\intranet\models\Ciudad;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;

?>


<div class="col-md-12" id="listaContenidoEmergente">
  <h4>Grupos de interes y ciudad de destino</h4>
  <?php $form = ActiveForm::begin(['options' => ['id'=> 'formEnviaDestinosContenidoEmergente']]); ?>

  <div class="col-md-4">
    <?php
      echo $form->field($modelDestinoContenidoEmergente, 'idGrupoInteres')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(GrupoInteres::find()->orderBy('nombreGrupo')->all(), 'idGrupoInteres', 'nombreGrupo'),
        'options' => ['placeholder' => 'Selecione ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
      ]);
    ?>
  </div>
  <div class="col-md-4">
    <?php
    echo $form->field($modelDestinoContenidoEmergente, 'codigoCiudad')->widget(Select2::classname(), [
      'data' => ArrayHelper::map(Ciudad::find()->orderBy('nombreCiudad')->all(), 'codigoCiudad', 'nombreCiudad'),
      'options' => ['placeholder' => 'Selecione ...'],
      'pluginOptions' => [
          'allowClear' => true
      ],
    ]);
    ?>
  </div>
  <?=
    $form->field($modelDestinoContenidoEmergente, 'idContenidoEmergente')->hiddenInput(['value'=> $model->idContenidoEmergente])
    ->label(false);
  ?>
  <?php ActiveForm::end(); ?>
  <div class="col-md-4">

    <?= Html::a('Agregar', ['#'],
    [
      'class' => 'btn btn-primary ',
      'data-role' => 'agregar-destino-contenido-emergente'
    ])
    ?>
  </div>

  <br><br>
  <br><br>
  <br><br>

  <!-- lista de destinos de esa campaña -->
  <div class="col-md-12">
    <div id="listaContenidosEmergentes">

      <?=  GridView::widget([
        'dataProvider' => $destinoContenidoEmergente,
        'pager' => [
          'maxButtonCount' => Yii::$app->params['limiteBotonesPaginador'],    // Set maximum number of page buttons that can be displayed
        ],
        'layout' => "{summary}\n{items}\n<center>{pager}</center>",
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
              'eliminar-destino' => function ($url, $destinoContenidoEmergente) {
                return  Html::a('<span class="glyphicon glyphicon-trash"></span>',
                ['#'],
                [
                  'class' => 'btn btn-danger',
                  'data-grupo' => $destinoContenidoEmergente->idGrupoInteres,
                  'data-ciudad' => $destinoContenidoEmergente->codigoCiudad,
                  'data-contenido-emergente' => $destinoContenidoEmergente->idContenidoEmergente,
                  'data-role' => 'eliminarDestinoContenidoEmergente'
                ]
              );
            }
          ],
        ],
      ],
    ]); ?>

    </div>
  </div>
</div>
