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

    <?= Html::a('Agregar cargo', ['agregar-cargo', 'id' => $grupo->idGrupoInteres], ['class' => 'btn btn-primary']) ?>
    <?php //var_dump($grupoInteresCargo) ?>

    <div id="listaCargos">
          <?= $this->render('cargosGrupoInteres', ['grupoInteresCargo' => $grupoInteresCargo]) ?>
    </div>






</div>
