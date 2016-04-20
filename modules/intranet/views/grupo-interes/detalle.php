<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\JsExpression;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $grupo app\modules\intranet\grupos\GrupoInteres */

$this->title = $grupo->nombreGrupo;
//$this->params['breadcrumbs'][] = ['label' => 'Grupo Interes', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">
  <div class="grupo-interes-view">

      <p>
          <?= Html::a('Actualizar', ['actualizar', 'id' => $grupo->idGrupoInteres], ['class' => 'btn btn-primary']) ?>
          <?= Html::a('Eliminar', ['eliminar', 'id' => $grupo->idGrupoInteres], [
              'class' => 'btn btn-danger',
              'data' => [
                  'confirm' => 'estas seguro de eliminar este grupo de interes?',
                  'method' => 'post',
              ],
          ]) ?>
      </p>

      <?= DetailView::widget([
          'model' => $grupo,
          'attributes' => [
              'nombreGrupo',
          ],
      ]) ?>

  </div>
</div>

<div class="col-md-12" id="cargosGrupo">
  <h4>Cargos asociados al grupo de interes</h4>
  <p>
    agrega un cargo a este grupo
  </p>
  <?= Html::beginForm(['grupo-interes/agregar-cargo'], 'post', ['id'=> 'formEnviaCargos']); ?>
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
      echo Select2::widget([
            'name' => 'agregaCargos',
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

  <?=  Html::hiddenInput('grupoInteres', $grupo->idGrupoInteres, []);  ?>
  <?= Html::endForm()     ?>
  <br>

  <?= Html::a('Agregar cargo', ['#'],
                  [
                    'class' => 'btn btn-primary',
                    'data-grupo' => $grupo->idGrupoInteres,
                    'data-role' => 'agregar-cargo'
                  ])
  ?>
  <br>

  <?= $this->render('cargosGrupoInteres', ['grupoInteresCargo' => $grupoInteresCargo, 'idGrupo'=>$grupo->idGrupoInteres]) ?>
</div>
