<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $grupo app\modules\intranet\grupos\GrupoInteres */

$this->title = $grupo->nombreGrupo;
//$this->params['breadcrumbs'][] = ['label' => 'Grupo Interes', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">
  <div class="grupo-interes-view">

      <p>
          <?= Html::a('Actualizar grupo interes', ['actualizar', 'id' => $grupo->idGrupoInteres], ['class' => 'btn btn-primary']) ?>
          <?= Html::a('Eliminar grupo interes', ['eliminar', 'id' => $grupo->idGrupoInteres], [
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

        echo Select2::widget([
              'name' => 'agregaCargos',
              'data' => \yii\helpers\ArrayHelper::map($listaCargos, 'idCargo', 'nombreCargo'),
              'size' => Select2::MEDIUM,
              'showToggleAll' => false,
              'changeOnReset' => false,
              'options' => ['class'=>'select2-container select2-container-multi', 'id' => 'enviaAmigo','placeholder' => 'buscar...', 'multiple' => true],
              'pluginOptions' => [
                'allowClear' => true,
                'escapeMarkup' => new JsExpression("function(m) { return m; }")
              ],

        ])

    ?>

    <?=  Html::hiddenInput('grupoInteres',$grupo, []);  ?>
    <?= Html::endForm()     ?>

    <?= Html::a('Agregar cargo', ['#'],
                    [
                      'class' => 'btn btn-primary',
                      'data-grupo' => $grupo->idGrupoInteres,
                      'data-role' => 'agregar-cargo'
                    ])
    ?>
    <?php //var_dump($grupoInteresCargo) ?>

    <div id="listaCargos">
          <?= $this->render('cargosGrupoInteres', ['grupoInteresCargo' => $grupoInteresCargo]) ?>
    </div>






</div>
