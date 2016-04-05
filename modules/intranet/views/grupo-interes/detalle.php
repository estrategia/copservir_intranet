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


          <?= $this->render('cargosGrupoInteres', ['grupoInteresCargo' => $grupoInteresCargo, 'listaCargos' => $listaCargos, 'idGrupo'=>$grupo->idGrupoInteres]) ?>
    






</div>
