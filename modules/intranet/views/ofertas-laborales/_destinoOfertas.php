<?php
use yii\grid\GridView;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\modules\intranet\models\GrupoInteres;
use app\modules\intranet\models\Ciudad;
use app\modules\intranet\models\Funciones;
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
<div class="col-md-12" id="listaOfertas">

      <h4>Grupos de interes y ciudad de destino</h4>
      <?php $form = ActiveForm::begin(['options' => ['id'=> 'formEnviaDestinosOferta']]); ?>

      <div class="col-md-4">
        <?php
          echo $form->field($modelDestinoOferta, 'idGrupoInteres')->widget(Select2::classname(), [
            'data' => Funciones::getDatosSelectGruposInteres()['data'],
            'options' => [
              'placeholder' => 'Selecione ...',
              'options' => Funciones::getDatosSelectGruposInteres()['options'],
              'multiple' => false,
            ],
            'pluginOptions' => [
              'allowClear' => true,
              'templateResult' => new JsExpression('formatSelect'),
              'templateSelection' => new JsExpression('formatSelect'),
              'escapeMarkup' => $escape,
            ],
            'hideSearch' => false,
          ]);
        ?>
      </div>
      <div class="col-md-4">
        <?php
        echo $form->field($modelDestinoOferta, 'codigoCiudad')->widget(Select2::classname(), [
          'data' => ArrayHelper::map(Ciudad::find()->orderBy('nombreCiudad')->all(), 'codigoCiudad', 'nombreCiudad'),
          'options' => ['placeholder' => 'Selecione ...'],
          'pluginOptions' => [
              'allowClear' => true
          ],
        ]);
        ?>
      </div>

      <?=
        $form->field($modelDestinoOferta, 'idOfertaLaboral')->hiddenInput(['value'=> $model->idOfertaLaboral])
        ->label(false);
      ?>
      <?php ActiveForm::end(); ?>
      <div class="col-md-4">

        <?= Html::a('Agregar', ['#'],
        [
          'class' => 'btn btn-primary ',
          'data-role' => 'agregar-destino-oferta'
        ])
        ?>
      </div>

  <br><br>
  <br><br>
  <br><br>
  <!-- lista de destinos de esa oferta laboral solo se muestra si va a actualizar -->
  <div class="col-md-12">
    <div>
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
  </div>
</div>
