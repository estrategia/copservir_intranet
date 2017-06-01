<?php
use yii\grid\GridView;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\modules\intranet\models\GrupoInteres;
use app\modules\intranet\models\Funciones;
use app\modules\intranet\models\Ciudad;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

$format = <<< SCRIPT
function formatSelect(state) {
  console.log(state.element);
  if (!state.id) return state.text; // optgroup
    return '<span style="' + state.element.style.cssText + '">' + state.text + '</span>';
}
SCRIPT;

$this->registerJs($format, \yii\web\View::POS_HEAD);
$escape = new JsExpression("function(m) {return m; }");
?>

<div class="col-md-12" id="listaEventos">

      <h4>Grupos de interes y ciudad de destino</h4>
      <!-- formulario para agregar un destino nuevo -->
      <?php $form = ActiveForm::begin(['options' => ['id'=> 'formEnviaDestinosEventos']]); ?>

      <div class="col-md-4">
        <?php
          echo $form->field($modelDestinoEventos, 'idGrupoInteres')->widget(Select2::classname(), [
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
        echo $form->field($modelDestinoEventos, 'codigoCiudad')->widget(Select2::classname(), [
          'data' => ArrayHelper::map(Ciudad::find()->orderBy('nombreCiudad')->all(), 'codigoCiudad', 'nombreCiudad'),
          'options' => ['placeholder' => 'Selecione ...'],
          'pluginOptions' => [
              'allowClear' => true
          ],
        ]);
        ?>
      </div>

      <?=
        $form->field($modelDestinoEventos, 'idEventoCalendario')->hiddenInput(['value'=> $model->idEventoCalendario])
        ->label(false);
      ?>
      <?php ActiveForm::end(); ?>
      <div class="col-md-4">

        <?= Html::a('Agregar', ['#'],
        [
          'class' => 'btn btn-primary ',
          'data-role' => 'agregar-destino-evento-calendario'
        ])
        ?>
      </div>



  <!-- lista de destinos de esa oferta laboral solo se muestra si va a actualizar -->
  <br><br>
  <br><br>
  <br><br>
  <div class="col-md-12">
    <div>

      <?=  GridView::widget([
        'dataProvider' => $destinoEventosCalendario,
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
              'eliminar-destino' => function ($url, $destinoEventosCalendario) {
                return  Html::a('<span class="glyphicon glyphicon-trash"></span>',
                ['#'],
                [
                  'class' => 'btn btn-danger',
                  'data-grupo' => $destinoEventosCalendario->idGrupoInteres,
                  'data-ciudad' => $destinoEventosCalendario->codigoCiudad,
                  'data-evento' => $destinoEventosCalendario->idEventoCalendario,
                  'data-role' => 'eliminarDestinoEventoCalendario'
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
